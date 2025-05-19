<?php

namespace App\Http\Controllers\Web;

use App\Models\Topic;
use App\Models\UserPoint;
use Illuminate\Http\Request;
use App\Models\UserActivityLog;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Container\Attributes\Log;


class AIController extends Controller
{
    public function store_user_activity_log($activity_type, $token_used, $topic, $file_name) {
        $user = Auth::user();

        $activity_log = UserActivityLog::create([
            'user_id' => $user->id,
            'activity_type' => $activity_type,
            'xp_earned' => 0,
            'max_xp' => 0,
            'points_earned' => 0,
            'token_used' => $token_used ?? 0,
            'topic' => $topic ?? null,
            'file_name' => $file_name ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return $activity_log->id;
    }

    public function show_ai_mcq_section()
    {
        return view('ai.mcq.mcq');
    }

    public function show_ai_mcq(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:500',
        ], [
            'text.required' => 'Please enter a topic for your quiz.',
            'text.max' => 'Topic text should not exceed 500 characters.',
        ]);
        
        // dd($request->all());

        try {
            $textContent = trim($request->input('text'));
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.key'),
                'Content-Type' => 'application/json',
            ])->timeout(15)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an educational assistant specialized in creating challenging but fair multiple-choice quizzes. Generate questions that test understanding, not just memorization.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "
                        Generate 5 multiple-choice questions based on the topic: $textContent
                        
                        Make sure each question is unique and tests a different aspect of the topic.
                        Each question should have 4 options with only one correct answer.
                        Make the distractors (wrong answers) plausible but clearly incorrect to someone who understands the topic.
                        
                        Provide the response in this structure:
                        Question: [Question Text]
                        Options: [Option1; Option2; Option3; Option4]
                        Answer: [Correct answer index of option, where 0 is the first option]
                        
                        Format example = [{question: What is Apple?, options: [Vegetable, Fruit, Water, Bread], answer: 1}]
                        
                        Ensure that correct answers are distributed evenly and not in a predictable pattern.",
                    ]
                ],
                'max_tokens' => 1500,
                'temperature' => 0.7,
            ]);
            
            if ($response->failed()) {
                // dd("masuk sini 2", $response->body());
                return redirect()->back()->with('error', 'An error occurred while generating the quiz. Please try again.');
                throw new \Exception("OpenAI API error: " . $response->body());
            }
            
            
            $message = $response->json('choices.0.message.content');

            $responseData = $response->json();
            $token_used = $responseData['usage']['total_tokens'] ?? 0;

            if (!$message) {
                throw new \Exception("Unexpected response structure from OpenAI.");
            }

            $activityLogId = $this->store_user_activity_log('mcq', $token_used, $textContent, null);
            
            $quiz = $this->parseMCQ($message);
            
            if (empty($quiz)) {
                return redirect()->back()->with('error', 'An error occurred while generating the quiz. Please try again.');
                // return back()->withErrors(['error' => 'Could not generate quiz questions. Please try a different topic.']);
            }
            
            return view('ai.mcq.mcq_generated', [
                'title' => 'Quiz on ' . ucfirst($textContent),
                'questions' => $quiz,
                'topic' => $textContent,
                'user_activity_log_id' => $activityLogId
            ]);
        } catch (\Exception $e) {
            \Log::error('Quiz generation error: ' . $e->getMessage());
            
            if (str_contains($e->getMessage(), 'timeout')) {
                return redirect()->back()->with('error', 'An error occurred while generating the quiz. Please try again.');
                // return back()->withErrors(['error' => 'The quiz generation timed out. Please try again or use a simpler topic.']);
            }
            
            return redirect()->back()->with('error', 'An error occurred while generating the quiz. Please try again.');
            // return back()->withErrors(['error' => 'Failed to generate quiz. ' . $e->getMessage()]);
        }
    }

    /**
     * Parse the MCQ response from OpenAI API
     * 
     * @param string $rawText The response text from OpenAI
     * @return array The parsed MCQ questions
     */
    private function parseMCQ(string $rawText): array
    {
        try {
            // First attempt: Parse structured format
            $pattern = '/Question:\s*(.*?)\s*Options:\s*(.*?)\s*Answer:\s*(\d+)/s';
            preg_match_all($pattern, $rawText, $matches, PREG_SET_ORDER);
            
            $questions = [];
            
            if (!empty($matches)) {
                foreach ($matches as $match) {
                    $questionText = trim($match[1]);
                    $optionsText = trim($match[2]);
                    $answerIndex = (int) trim($match[3]);
                    
                    // Split options - handle both semicolon and comma delimiters
                    if (strpos($optionsText, ';') !== false) {
                        $options = array_map('trim', explode(';', $optionsText));
                    } else {
                        $options = array_map('trim', explode(',', $optionsText));
                    }
                    
                    // Clean up any remaining brackets
                    $options = array_map(function($option) {
                        return trim($option, "[] \t\n\r\0\x0B");
                    }, $options);
                    
                    // Ensure we have exactly 4 options and the answer index is valid
                    if (count($options) === 4 && $answerIndex >= 0 && $answerIndex < 4) {
                        $questions[] = [
                            'question' => $questionText,
                            'options' => $options,
                            'answer' => $answerIndex,
                        ];
                    }
                }
            }
            
            // If we couldn't parse with the first method, try to parse as JSON
            if (empty($questions)) {
                // Extract JSON-like structure if present
                if (preg_match('/\[\s*{.*}\s*\]/s', $rawText, $jsonMatch)) {
                    $jsonText = $jsonMatch[0];
                    
                    // Clean up common formatting issues
                    $jsonText = preg_replace('/"question":\s*"(.*?)",/s', '"question": "$1",', $jsonText);
                    $jsonText = preg_replace('/"options":\s*\[(.*?)\],/s', '"options": [$1],', $jsonText);
                    $jsonText = preg_replace('/"answer":\s*(\d+)/s', '"answer": $1', $jsonText);
                    
                    // Convert single quotes to double quotes for JSON
                    $jsonText = str_replace("'", '"', $jsonText);
                    
                    $decoded = json_decode($jsonText, true);
                    
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        foreach ($decoded as $item) {
                            if (isset($item['question']) && isset($item['options']) && isset($item['answer'])) {
                                if (count($item['options']) === 4 && $item['answer'] >= 0 && $item['answer'] < 4) {
                                    $questions[] = [
                                        'question' => $item['question'],
                                        'options' => $item['options'],
                                        'answer' => $item['answer'],
                                    ];
                                }
                            }
                        }
                    }
                }
            }
            
            return $questions;
        } catch (\Exception $e) {
            \Log::error('Error parsing MCQ response: ' . $e->getMessage());
            return [];
        }
    }

    public function show_ai_flashcard_section()
    {
        return view('ai.flashcard.flashcard');
    }

    public function show_ai_flashcard(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:500',
        ], [
            'text.required' => 'Please enter a topic for your quiz.',
            'text.max' => 'Topic text should not exceed 500 characters.',
        ]);

        try {
            $textContent = trim($request->input('text'));
            // $sessionKey = 'flashcards_' . md5($textContent);

            // // Check session first to avoid re-calling OpenAI
            // if (session()->has($sessionKey)) {
            //     $flashcards = session()->get($sessionKey);

            //     return view('ai.flashcard.flashcard_generated', [
            //         'title' => 'Flashcards on ' . ucfirst($textContent),
            //         'flashcards' => $flashcards,
            //         'topic' => $textContent,
            //     ]);
            // }
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.key'),
                'Content-Type' => 'application/json',
            ])->timeout(15)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an educational assistant specialized in creating comprehensive list of 10 flashcards base on the topic given by the user.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "
                        Generate list of 10 flashcards based on the topic: $textContent

                        Make sure each flashcard have 2 sides. 1 side is the question or term, the other is the answer or definition.

                        Provide the response in this structure: 
                        {
                            \"flashcards\": [
                                {
                                    \"frontside\": \"term1\",
                                    \"backside\": \"definition1\"
                                },
                                {
                                    \"frontside\": \"term2\",
                                    \"backside\": \"definition2\"
                                },
                                ...
                            ]
                        }

                        Ensure that flashcards are distributed evenly and not in a predictable pattern."
                    ]
                ],
                'max_tokens' => 2000,
                'temperature' => 0.7,
            ]);
            
            if ($response->failed()) {
                // dd("masuk sini 2", $response->body());
                return redirect()->back()->with('error', 'An error occurred while generating the flashcards. Please try again.');
                throw new \Exception("OpenAI API error: " . $response->body());
            }
            
            $message = $response->json('choices.0.message.content');
            
            // dd($message);
            $responseData = $response->json();
            $token_used = $responseData['usage']['total_tokens'] ?? 0;
            
            if (!$message) {
                throw new \Exception("Unexpected response structure from OpenAI.");
            }
            
            $activityLogId = $this->store_user_activity_log('flashcard', $token_used, $textContent, null);
            
            $flashcards = $this->parseFlashcard($message);

            // dd($flashcards);
            
            if (empty($flashcards)) {
                return redirect()->back()->with('error', 'An error occurred while generating the flashcards. Please try again.');
                // return back()->withErrors(['error' => 'Could not generate quiz questions. Please try a different topic.']);
            }

            // Store flashcards in session to prevent duplicate requests
            // session()->put($sessionKey, $flashcards);            
            
            return view('ai.flashcard.flashcard_generated', [
                'title' => 'Flashcards on ' . ucfirst($textContent),
                'flashcards' => $flashcards,
                'topic' => $textContent,
                'user_activity_log_id' => $activityLogId
            ]);
        } catch (\Exception $e) {
            \Log::error('Flashcard generation error: ' . $e->getMessage());
            
            if (str_contains($e->getMessage(), 'timeout')) {
                return redirect()->back()->with('error', 'An error occurred while generating the flashcards. Please try again.');
                // return back()->withErrors(['error' => 'The quiz generation timed out. Please try again or use a simpler topic.']);
            }
            
            return redirect()->back()->with('error', 'An error occurred while generating the flashcards. Please try again.');
            // return back()->withErrors(['error' => 'Failed to generate quiz. ' . $e->getMessage()]);
        }
    }

    /**
     * Parse the Flashcard response from OpenAI API
     * 
     * @param string $rawText The raw text response from OpenAI
     * @return array The parsed flashcards
     */
    private function parseFlashcard(string $rawText): array
    {
        try {
            // Extract JSON object containing "flashcards"
            if (preg_match('/\{\s*"flashcards"\s*:\s*\[.*?\]\s*\}/s', $rawText, $jsonMatch)) {
                $jsonText = $jsonMatch[0];

                // Clean up potential formatting issues (optional)
                $jsonText = str_replace("“", '"', $jsonText);
                $jsonText = str_replace("”", '"', $jsonText);
                $jsonText = preg_replace('/,\s*}/', '}', $jsonText); // remove trailing commas before object end
                $jsonText = preg_replace('/,\s*]/', ']', $jsonText); // remove trailing commas before array end

                $decoded = json_decode($jsonText, true);

                if (json_last_error() === JSON_ERROR_NONE && isset($decoded['flashcards'])) {
                    $flashcards = [];

                    foreach ($decoded['flashcards'] as $card) {
                        if (isset($card['frontside']) && isset($card['backside'])) {
                            $flashcards[] = [
                                'frontside' => trim($card['frontside']),
                                'backside' => trim($card['backside']),
                            ];
                        }
                    }

                    return $flashcards;
                }
            }

            return [];
        } catch (\Exception $e) {
            \Log::error('Error parsing flashcard response: ' . $e->getMessage());
            return [];
        }
    }

    public function show_ai_wsp_section()
    {
        return view('ai.word_search_puzzle.word_search_puzzle');
    }

    public function show_ai_wsp(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:500',
        ], [
            'text.required' => 'Please enter a topic for your quiz.',
            'text.max' => 'Topic text should not exceed 500 characters.',
        ]);

        try {
            $textContent = trim($request->input('text'));
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.key'),
                'Content-Type' => 'application/json',
            ])->timeout(15)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an educational assistant specialized in creating list of 10 words that will be used as word search puzzle base on the topic given by the user.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "
                        Generate a list of 10 words for word search puzzle based on the topic: $textContent

                        Make sure each word is unique and is related to the topic.

                        Provide the response in this structure: 
                        {
                            \"words\": [\"word1\", \"word2\", ...]
                        }

                        Ensure that the words are distributed evenly and not in a predictable pattern. The words MUST NOT HAVE SPACINGS. "
                    ]
                ],
                'max_tokens' => 1500,
                'temperature' => 0.7,
            ]);
            
            if ($response->failed()) {
                return redirect()->back()->with('error', 'An error occurred while generating the word search puzzle. Please try again.');
                throw new \Exception("OpenAI API error: " . $response->body());
            }

            // dd($response->json('choices.0.message.content'));
            
            $message = $response->json('choices.0.message.content');
            
            // dd($message);
            $responseData = $response->json();
            $token_used = $responseData['usage']['total_tokens'] ?? 0;

            if (!$message) {
                throw new \Exception("Unexpected response structure from OpenAI.");
            }

            $activityLogId = $this->store_user_activity_log('wsp', $token_used, $textContent, null);
            
            $words = $this->parseWsp($message);

            // dd($words);
            
            if (empty($words)) {
                return redirect()->back()->with('error', 'An error occurred while generating the word search puzzle. Please try again.');
                // return back()->withErrors(['error' => 'Could not generate quiz questions. Please try a different topic.']);
            }

            // Generate the word search grid
            $grid = $this->generateWordSearchGrid($words);

            // Store flashcards in session to prevent duplicate requests
            // session()->put($sessionKey, $flashcards);            
            
            return view('ai.word_search_puzzle.word_search_puzzle_generated', [
                'title' => 'Word Search Puzzle on ' . ucfirst($textContent),
                'words' => $words,
                'grid' => $grid,
                'topic' => $textContent,
                'user_activity_log_id' => $activityLogId
            ]);
        } catch (\Exception $e) {
            \Log::error('Word Search Puzzle generation error: ' . $e->getMessage());
            
            if (str_contains($e->getMessage(), 'timeout')) {
                return redirect()->back()->with('error', 'An error occurred while generating the word search puzzle. Please try again.');
                // return back()->withErrors(['error' => 'The quiz generation timed out. Please try again or use a simpler topic.']);
            }

            return redirect()->back()->with('error', 'An error occurred while generating the word search puzzle. Please try again.');
            // return back()->withErrors(['error' => 'Failed to generate quiz. ' . $e->getMessage()]);
        }
    }

    /**
     * Parse the Flashcard response from OpenAI API
     * 
     * @param string $rawText The raw text response from OpenAI
     * @return array The parsed flashcards
     */
    private function parseWsp(string $rawText): array
    {
        try {
            // Extract JSON object containing "words"
            if (preg_match('/\{\s*"words"\s*:\s*\[.*?\]\s*\}/s', $rawText, $jsonMatch)) {
                $jsonText = $jsonMatch[0];

                // Clean up potential formatting issues
                $jsonText = str_replace(["“", "”"], '"', $jsonText);
                $jsonText = preg_replace('/,\s*]/', ']', $jsonText); // remove trailing comma before closing ]

                $decoded = json_decode($jsonText, true);

                if (json_last_error() === JSON_ERROR_NONE && isset($decoded['words']) && is_array($decoded['words'])) {
                    // Trim each word and return
                    return array_map('trim', $decoded['words']);
                }
            }

            return [];
        } catch (\Exception $e) {
            \Log::error('Error parsing word search puzzle response: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Generate the word search grid
     */
    private function generateWordSearchGrid(array $words, int $size = 15): array
    {
        // Initialize empty grid
        $grid = array_fill(0, $size, array_fill(0, $size, ''));
        
        // Define possible directions [dx, dy]
        $directions = [
            [1, 0],   // Horizontal
            [0, 1],    // Vertical
            [1, 1],    // Diagonal down-right
            [1, -1],   // Diagonal up-right
            [-1, 0],   // Horizontal (backward)
            [0, -1],   // Vertical (upward)
            [-1, -1],  // Diagonal up-left
            [-1, 1]    // Diagonal down-left
        ];
        
        // Place each word in the grid
        foreach ($words as $word) {
            $word = strtoupper(trim($word));
            $wordLength = strlen($word);
            $placed = false;
            $attempts = 0;
            
            while (!$placed && $attempts < 100) {
                $direction = $directions[array_rand($directions)];
                $row = rand(0, $size - 1);
                $col = rand(0, $size - 1);
                
                // Check if word fits in this position/direction
                $endRow = $row + ($wordLength - 1) * $direction[1];
                $endCol = $col + ($wordLength - 1) * $direction[0];
                
                if ($endRow < 0 || $endRow >= $size || $endCol < 0 || $endCol >= $size) {
                    $attempts++;
                    continue;
                }
                
                // Check if cells are available
                $canPlace = true;
                for ($i = 0; $i < $wordLength; $i++) {
                    $checkRow = $row + $i * $direction[1];
                    $checkCol = $col + $i * $direction[0];
                    
                    $currentCell = $grid[$checkRow][$checkCol];
                    if ($currentCell !== '' && $currentCell !== $word[$i]) {
                        $canPlace = false;
                        break;
                    }
                }
                
                if ($canPlace) {
                    // Place the word
                    for ($i = 0; $i < $wordLength; $i++) {
                        $placeRow = $row + $i * $direction[1];
                        $placeCol = $col + $i * $direction[0];
                        $grid[$placeRow][$placeCol] = $word[$i];
                    }
                    $placed = true;
                }
                
                $attempts++;
            }
        }
        
        // Fill remaining empty cells with random letters
        $letters = range('A', 'Z');
        foreach ($grid as &$row) {
            foreach ($row as &$cell) {
                if ($cell === '') {
                    $cell = $letters[array_rand($letters)];
                }
            }
        }
        
        return $grid;
    }
}
