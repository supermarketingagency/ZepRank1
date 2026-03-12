<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $branch->business->name }} - Review Drafts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex flex-col items-center justify-center p-4">
    <div class="max-w-md w-full">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Choose your review</h2>
        <p class="text-gray-600 mb-8">We've drafted a few options based on your experience. Tap one to copy and post to Google.</p>

        <div class="space-y-4 mb-8">
            @foreach($drafts as $draft)
                <div class="p-4 border rounded-lg cursor-pointer hover:border-blue-500 transition draft-card" onclick="selectDraft(this, '{{ addslashes($draft->content) }}')">
                    {{ $draft->content }}
                </div>
            @endforeach
        </div>

        <button id="post-btn" disabled onclick="redirectToGoogle()" class="w-full bg-gray-400 text-white py-4 rounded-full font-bold transition">
            Copy & Post to Google
        </button>
    </div>

    <script>
        let selectedText = '';
        function selectDraft(el, text) {
            document.querySelectorAll('.draft-card').forEach(c => c.classList.remove('border-blue-500', 'bg-blue-50'));
            el.classList.add('border-blue-500', 'bg-blue-50');
            selectedText = text;
            const btn = document.getElementById('post-btn');
            btn.disabled = false;
            btn.classList.remove('bg-gray-400');
            btn.classList.add('bg-blue-600');
        }

        function redirectToGoogle() {
            navigator.clipboard.writeText(selectedText).then(() => {
                window.location.href = "{{ route('review.redirect', ['slug' => $branch->slug, 'token' => $session->session_token]) }}";
            });
        }
    </script>
</body>
</html>
