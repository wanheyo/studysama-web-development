<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\ResourceController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\TutorSlotController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function (Request $request) {
    return response()->json([
        'message' => 'Server is up and running',
    ], 200);
});

Route::group(['prefix' => 'studysama'], function () {

    // Auth
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
        Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
    });

    // User Controller
    Route::group(['prefix' => 'users'], function () {
        Route::post('store', [UserController::class, 'store']);
        Route::post('login', [UserController::class, 'login']);
        Route::middleware('auth:sanctum')->get('logout', [UserController::class, 'logout']);
        Route::middleware('auth:sanctum')->post('update', [UserController::class, 'update']);
        Route::middleware('auth:sanctum')->get('index_all', [UserController::class, 'index_all']);
        Route::middleware('auth:sanctum')->post('index_user', [UserController::class, 'index_user']);
        Route::middleware('auth:sanctum')->post('index_follow', [UserController::class, 'index_follow']);
        Route::middleware('auth:sanctum')->post('update_follow', [UserController::class, 'update_follow']);
        Route::middleware('auth:sanctum')->post('index_user_badge', [UserController::class, 'index_user_badge']);
    });

    // Course Controller
    Route::group(['prefix' => 'course'], function () {
        Route::middleware('auth:sanctum')->get('index_all', [CourseController::class, 'index_all']);
        Route::middleware('auth:sanctum')->post('index_course', [CourseController::class, 'index_course']);
        Route::middleware('auth:sanctum')->post('index_course_courseid', [CourseController::class, 'index_course_courseid']);
        Route::middleware('auth:sanctum')->post('index_user_course', [CourseController::class, 'index_user_course']);
        Route::middleware('auth:sanctum')->post('store', [CourseController::class, 'store']);
        Route::middleware('auth:sanctum')->post('update', [CourseController::class, 'update']);
        Route::middleware('auth:sanctum')->post('update_user_course', [CourseController::class, 'update_user_course']);
        Route::middleware('auth:sanctum')->post('index_review', [CourseController::class, 'index_review']);
        Route::middleware('auth:sanctum')->post('update_review', [CourseController::class, 'update_review']);
        Route::middleware('auth:sanctum')->post('index_user_course_join', [CourseController::class, 'index_user_course_join']);
    });

    // Lesson Controller
    Route::group(['prefix' => 'lesson'], function () {
        Route::middleware('auth:sanctum')->get('index_all', [LessonController::class, 'index_all']);
        Route::middleware('auth:sanctum')->post('index_lesson_course', [LessonController::class, 'index_lesson_course']);
        Route::middleware('auth:sanctum')->post('store', [LessonController::class, 'store']);
        Route::middleware('auth:sanctum')->post('update', [LessonController::class, 'update']);
    });

    // Resource Controller
    Route::group(['prefix' => 'resource'], function () {
        Route::middleware('auth:sanctum')->get('index_all', [ResourceController::class, 'index_all']);
        Route::middleware('auth:sanctum')->post('index_resource_lesson', [ResourceController::class, 'index_resource_lesson']);
        Route::middleware('auth:sanctum')->post('store', [ResourceController::class, 'store']);
        Route::middleware('auth:sanctum')->post('update', [ResourceController::class, 'update']);
    });

    // Comment Controller
    Route::group(['prefix' => 'comment'], function () {
        Route::middleware('auth:sanctum')->get('index_all', [CommentController::class, 'index_all']);
        Route::middleware('auth:sanctum')->post('index_comment_resource', [CommentController::class, 'index_comment_resource']);
        Route::middleware('auth:sanctum')->post('store', [CommentController::class, 'store']);
        Route::middleware('auth:sanctum')->post('update', [CommentController::class, 'update']);
    });

    // TutorSlot Controller
    Route::group(['prefix' => 'tutorslot'], function () {
        Route::middleware('auth:sanctum')->get('index_all', [TutorSlotController::class, 'index_all']);
        Route::middleware('auth:sanctum')->post('index_tutorslot_course', [TutorSlotController::class, 'index_tutorslot_course']);
        Route::middleware('auth:sanctum')->post('store', [TutorSlotController::class, 'store']);
        Route::middleware('auth:sanctum')->post('update', [TutorSlotController::class, 'update']);
    });

});
