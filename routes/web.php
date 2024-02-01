<?php

use App\AI\Assistant;
use App\Rules\SpamFree;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    /*$chat = new Chat();

    $poem = $chat->systemMessage("You are a poetic assistant, skilled in explaining complex programming concepts with creative flair.")->send('Compose a poem that explains the concept of recursion in programming.');

    $sillyPoem = $chat->reply('Good, now make it nuch, much silly');

    return view('welcome', [
        'poem' => $sillyPoem
    ]);*/

    /*Text to speech*/
    /*return view('text-to-img', [
        'messages' => session('messages', [])
    ]);*/
});

/*Text to speech*/
Route::get('/text-to-speech', function(){
    return view('roast');
});
Route::post('/roast', function(){
    $attributes = request()->validate([
        'topic' => 'required|min:2|max:50'
    ]);

    $chat = new Assistant();
    $prompt = "Please roast {$attributes['topic']} in sarcastic tone.";
    $mp3 = $chat->send(
        message: $prompt,
        speech: true
    );

    $folder = '/roasts';
    $directory = public_path().$folder;
    if (!is_dir($directory)) {
        mkdir($directory);
    }

    $file = md5($mp3).".mp3";
    file_put_contents($directory."/".$file, $mp3);

    return redirect('/')->with([
        'file' => $folder.'/'.$file,
        'flash' => 'Boom. Roasted.'
    ]);
});

/*Text to Image*/
Route::get('text-to-img', function(){
    return view('text-to-img', [
        'messages' => session('messages', [])
    ]);
});
Route::post('/image', function(){
    $attributes = request()->validate([
        'description' => 'required|min:3|string'
    ]);

    $assistant = new Assistant(session('messages', []));

    $url = $assistant->visualize($attributes['description']);

    session('messages', $assistant->messages());

    return redirect('/');
});

/*AI to detect comment span*/
Route::get('comment', function(){
    return view('comment-box');
});
Route::post('/post-comment', function(){
    $attributes = request()->validate([
        'body' => [
            'required',
            'string',
            new SpamFree()
        ]
    ]);



    return $response->is_spam ? 'THIS IS SPAM' : 'VALID POST';
});