<!DOCTYPE html>
<html class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Text to Image</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-slate-100">
    <div class="flex gap-6 mx-auto max-w-3xl bg-white py-6 px-10 rounded-xl">
        <div>
            <h1 class="font-bold mb-4">Generate an Image</h1>
            <form action="/image" method="POST" accept-charset="utf-8">
                @csrf
                <textarea name="description" od="description" cols="30" rows="5" class="border border-gray-600 rounded p-2" placeholder="A beagel barking at a squirrel in a tree..."></textarea>
                <p class="mt-2">
                    <button type="submit" class="border border-black px-2 text-xs rounded hover:bg-blue-500 hover:text-white">Submit</button>
                </p>
            </form>
        </div>
        <div>
            @if(count($messages))
                <div class="space-y-6">
                    @foreach(array_chunk($messages, 2) as $chunk)
                        <div>
                            <p class="font-bold text-sm mb-3">{{ $chunk[0]['content'] }}</p>
                            <img src="{{ $chunk[1]['content'] }}" alt="" style="max-width:250px;">
                        </div>
                    @endforeach
                </div>
                {{-- <img src="{{ session('messages') }}" style="max-width:250px;" alt=""> --}}
            @else
                <p class="text-xs">No visualization yet.</p>
            @endif
        </div>
    </div>
</body>
</html>