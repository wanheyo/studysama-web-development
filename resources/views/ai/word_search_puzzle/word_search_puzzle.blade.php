@extends('layout.master')
@section('title', 'StudySama AI')
@section('css')

@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Word Search Puzzle</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone ph-star-four f-s-16"></i> StudySama AI
                            </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Word Search Puzzle</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <!-- Help start -->
        <div class="faq-header p-3">
            <h2 class="text-dark f-w-700">
                StudySama <span id="highlight-typed"></span>
            </h2>

            <p class="text-muted mt-2">
                AI-powered Word Search Puzzle generator. Enter a topic and let StudySama create a Word Search Puzzle for you.
            </p>

            <div class="app-form search-div mt-4">
                <form action="{{ route('ai.mcq_generated') }}" method="POST">
                @csrf
                    <div class="input-group mb-3">
                        <input type="text" id="text" class="form-control b-r-right" placeholder="Enter topic (e.g., Photosynthesis)" aria-label="Example text with button addon"
                                aria-describedby="button-addon1" name="text" required>
                        <button class="btn btn-primary b-r-left rounded-end" type="submit" id="button-addon1"><i class="ti ti-brain pe-1"></i> Generate Puzzle</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Help end -->

        <!-- Frequently Asked Questions start -->
        <div class="row faq-accordion">
            <div class="faq-heading mb-3">
                <h3><i class="ti ti-question-circle"></i> Frequently Asked Questions</h3>
            </div>
            <div class="col-lg-8 offset-lg-2 mb-3">
                <div class="accordion app-accordion accordion-primary" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="ti ti-question-circle pe-2"></i> what is FAQs
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                a list of questions and answers relating to a particular subject, especially one giving basic
                                information for users of a website.A frequently asked questions list is often used in articles,
                                websites, email lists, and online forums where common questions tend to recur, for example
                                through posts or queries by new users related to common knowledge gaps
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="ti ti-question-circle pe-2"></i> What is an FAQs page?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Frequently Asked Questions (FAQ) pages contain a list of commonly asked questions and answers on
                                a website about topics such as hours, shipping and handling, product information, and return
                                policies.

                                Sure there are chatbots, support lines, and customer reviews to help shoppers on their path to
                                purchase, but there's one forgotten customer service tactic that is cost-effective and
                                streamlined. That tactic is an FAQ page.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <i class="ti ti-question-circle pe-2"></i> Why you should make an FAQs page?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                An FAQ page is a time-saving customer service tactic that provides the most commonly asked
                                questions and answers for current or potential customers.
                                Before diving into how to make an FAQ page, you need to know why having one is so important.
                                There are so many reasons beyond improving the customer experience for perfecting your FAQ page.
                                Keep in mind the importance of an FAQ page when developing your own e-commerce website, so you
                                can make sure it increases sales and not the other way around.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <i class="ti ti-question-circle pe-2"></i> How to make an FAQ page?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                There are seven simple steps to make the perfect FAQ page for your business. The design of an
                                FAQ page is crucial for an easy-to-use customer experience. Follow these steps and your customer
                                success team will thank you.
                                <ul class="mt-3">
                                    <li>- Determine the questions</li>
                                    <li>- Categorize the questions</li>
                                    <li>- Highlight or link the most popular questions</li>
                                    <li>- Include a search bar</li>
                                    <li>- Align with your brand look and feel</li>
                                    <li>- Update regularly</li>
                                    <li>- Track and improve</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                <i class="ti ti-question-circle pe-2"></i> What are the most frequently asked questions?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                A good FAQ is general enough to address many issues. There are questions that just about every
                                company answers on their FAQ page, so if you're struggling to get started use these as your
                                starting point. If they're relevant to your company, of course.

                                <ul class="mt-3">
                                    <li>- What is the return policy?</li>
                                    <li>- What are the shipping options?</li>
                                    <li>- What do I do if I never received my order?</li>
                                    <li>- When will I receive my order?</li>
                                    <li>- How do I make sure I order the right size?</li>
                                    <li>- Where are you located?</li>
                                    <li>- Can I make changes to an order I already placed?</li>
                                    <li>- How do I get a new password?</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- Frequently Asked Questions end -->
    </div>

    <style>
        .swal2-toast {
            width: auto !important;
            max-width: 100% !important;
            padding: 0.625em !important;
        }
    </style>
@endsection

@section('script')

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Toast notifications
            @if(session('success'))
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: "{{ session('success') }}",
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        width: 'auto',
                    });
                }, 100);
            @endif
        
            @if(session('error'))
                setTimeout(() => {
                    Swal.fire({
                        icon: 'error',
                        title: "{{ session('error') }}",
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        width: 'auto',
                    });
                }, 100);
            @endif

        new Typed("#highlight-typed", {
            strings: ["siapa?","AI!", "siapa?", "saya!"],
            typeSpeed: 100,
            backSpeed: 50,
            backDelay: 1500,
            loop: true
        });
    });
</script>

<!--customizer-->
<div id="customizer"></div>

<!--typed js-->
<script src="{{ asset('assets/vendor/typed/typed.umd.js') }}"></script>

<!-- sweetalert js-->
<script src="{{asset('assets/vendor/sweetalert/sweetalert.js')}}"></script>

@endsection
