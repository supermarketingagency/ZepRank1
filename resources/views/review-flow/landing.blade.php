<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate your experience - {{ $branch->business->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" rel="stylesheet">
    <style>
        body { font-family: 'Google Sans', sans-serif; }
        .star-btn { font-size: 56px; cursor: pointer; color: #DADCE0; transition: transform 200ms cubic-bezier(0.34, 1.56, 0.64, 1); }
        .star-btn:active { transform: scale(1.4); }
        .star-btn.active { color: #FBBC04; }
        @keyframes bounce { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.3); } }
        .bounce { animation: bounce 400ms ease; }
    </style>
</head>
<body class="bg-white min-h-screen flex flex-col items-center justify-center p-6 sm:p-0">
    <div class="max-w-sm w-full text-center">
        <!-- Google Style Logo -->
        <div class="mb-6">
            @if($branch->business->logo_path)
                <img src="{{ Storage::url($branch->business->logo_path) }}" alt="Logo" class="w-20 h-20 mx-auto rounded-full border-2 border-neutral-100 p-1 shadow-sm">
            @else
                <div class="w-20 h-20 mx-auto rounded-full bg-primary-600 text-white flex items-center justify-center text-3xl font-bold">
                    {{ substr($branch->business->name, 0, 1) }}
                </div>
            @endif
        </div>

        <h1 class="text-2xl font-medium text-neutral-900 mb-1">{{ $branch->business->name }}</h1>
        <p class="text-sm text-neutral-500 mb-10">{{ $branch->name }}</p>

        <div class="mb-12">
            <p class="text-xs font-bold text-neutral-500 uppercase tracking-widest mb-6">Rate your experience</p>
            <div class="flex justify-center gap-1" id="star-container">
                @for($i = 1; $i <= 5; $i++)
                    <span class="material-symbols-rounded star-btn" data-rating="{{ $i }}">star</span>
                @endfor
            </div>
            <p id="rating-label" class="mt-4 text-sm font-medium text-neutral-700 min-h-[20px]"></p>
        </div>

        <form id="rating-form" method="POST" action="{{ route('review.rate', $branch->slug) }}" class="hidden">
            @csrf
            <input type="hidden" name="rating" id="rating-input">
            <input type="hidden" name="session_token" value="{{ $session->session_token }}">
        </form>

        <p class="text-[10px] text-neutral-400 mt-20">Powered by <span class="font-bold">ZEPRANK</span></p>
    </div>

    <script>
        const labels = {
            1: "Terrible",
            2: "Poor",
            3: "Okay",
            4: "Great!",
            5: "Excellent!"
        };

        document.querySelectorAll('.star-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const rating = this.dataset.rating;
                document.getElementById('rating-input').value = rating;
                document.getElementById('rating-label').innerText = labels[rating];

                // Highlight stars
                document.querySelectorAll('.star-btn').forEach(s => {
                    if (parseInt(s.dataset.rating) <= parseInt(rating)) {
                        s.classList.add('active');
                        s.style.fontVariationSettings = "'FILL' 1";
                        if (s.dataset.rating == rating) s.classList.add('bounce');
                    } else {
                        s.classList.remove('active', 'bounce');
                        s.style.fontVariationSettings = "'FILL' 0";
                    }
                });

                // Submit after a small delay
                setTimeout(() => {
                    document.getElementById('rating-form').submit();
                }, 800);
            });
        });
    </script>
</body>
</html>
