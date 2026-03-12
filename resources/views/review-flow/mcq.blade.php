<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $branch->business->name }} - Experience</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex flex-col items-center justify-center p-4">
    <div class="max-w-md w-full">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Tell us more about your visit</h2>

        <form method="POST" action="{{ route('review.submit_mcq', $branch->slug) }}">
            @csrf
            <input type="hidden" name="session_token" value="{{ $session->session_token }}">

            <div class="space-y-4 mb-8">
                <p class="font-medium">What did you enjoy most?</p>
                @foreach(['Service', 'Quality', 'Value', 'Ambience'] as $option)
                    <label class="block p-4 border rounded-lg cursor-pointer hover:bg-blue-50">
                        <input type="radio" name="enjoy" value="{{ $option }}" class="mr-2">
                        {{ $option }}
                    </label>
                @endforeach
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-full font-bold">
                Next
            </button>
        </form>
    </div>
</body>
</html>
