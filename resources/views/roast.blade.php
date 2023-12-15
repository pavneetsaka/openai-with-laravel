<!DOCTYPE html>
<html class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Text to Speech</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full grid place-items-center p-6">
    <div class="w-full lg:max-w-md">
        @if(session('file'))
        <div>
            <h1 class="text-center font-semibold mb-3 text-3xl">{{ session('flash') }}</h1>
            <a href="{{ asset(session('file')) }}" download class="block rounded w-full text-center bg-gray-200 p-2 hover:bg-blue-400 hover:text-white">Download Audio</a>
        </div>
        @else
        <form action="/roast" method="POST" accept-charset="utf-8">
            @csrf
            <div class="flex gap-2  justify-center">
                <input type="text" name="topic" value="" placeholder="What whould you like me to roast?" class="rounded p-2 border border-gray-200 w-full">
                <button type="submit" class="rounded bg-gray-200 p-2 hover:bg-blue-400 hover:text-white">Roast</button>
            </div>
        </form>
        @endif
    </div>
</body>
</html>