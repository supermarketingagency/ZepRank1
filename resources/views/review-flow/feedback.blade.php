<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $branch->business->name }} - Feedback</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 min-h-screen flex flex-col items-center justify-center p-4">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-sm border border-orange-100">
        <h2 class="text-xl font-bold text-gray-900 mb-2 text-center">Share your feedback privately</h2>
        <p class="text-gray-600 mb-8 text-center text-sm">Your feedback goes directly to our team and is never posted publicly.</p>

        <form method="POST" action="#">
            @csrf
            <div class="space-y-4 mb-6">
                <p class="font-medium text-sm">What could we improve?</p>
                <textarea class="w-full border-gray-200 rounded-xl p-4 focus:ring-orange-500 focus:border-orange-500" rows="4" placeholder="Your experience..."></textarea>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-full font-bold">
                Submit Feedback
            </button>
        </form>
    </div>
</body>
</html>
