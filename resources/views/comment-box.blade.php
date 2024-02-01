<!DOCTYPE html>
<html class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Check for Spam comments</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-slate-100 max-w-xl mx-auto">
    <form action="/post-comment" method="post" accept-charset="utf-8">
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Create Reply</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">This comment will be displayed publicly, so be careful what you submit.</p>
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="col-span-full">
                        <label for="body" class="block text-sm font-medium leading-6 text-gray-900">Body</label>
                        <div class="mt-2">
                            <textarea id="body" name="body" rows="3" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-600"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">Submit</button>
        </div>

        @if($errors->any())
            <ul class="mt-2">
                @foreach($errors->all() as $error)
                <li class="text-sm text-red-500">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </form>
    {{-- <div class="flex gap-6 mx-auto max-w-3xl bg-white py-6 px-10 rounded-xl">
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
                <?php /*<img src="{{ session('messages') }}" style="max-width:250px;" alt="">*/ ?>
            @else
                <p class="text-xs">No visualization yet.</p>
            @endif
        </div>
    </div> --}}
</body>
</html>