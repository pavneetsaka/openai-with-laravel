<?php

namespace App\AI;

use Illuminate\Support\Facades\Http;
use OpenAI\Laravel\Facades\OpenAI;

class Assistant
{
    protected array $messages = [];
    protected string $model = "";

    public function __construct(array $messages = [])
    {
        $this->messages = $messages;
        $this->model = "gpt-3.5-turbo";
    }

    public function gptModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function systemMessage($message): static
    {
        $this->addMessage($message, "system");

        return $this;
    }

    public function send(string $message, bool $speech = false): ?string
    {
        $this->addMessage($message);

        /*$response = Http::withToken(config('services.openai.secret'))
                ->post('https://api.openai.com/v1/chat/completions',[
                    "model" => "gpt-3.5-turbo",
                    "messages" => $this->messages
                ])->json('choices.0.message.content');*/

        $request = [
            "model" => $this->model,
            "messages" => $this->messages
        ];
        if($this->model === "gpt-3.5-turbo-1106"){
            $request['response_format'] = ['type' => 'json_object'];
        }

        $response = OpenAI::chat()->create($request)->choices[0]->message->content;

        if($response){
            $this->addMessage($response, "assistant");
        }

        return $speech ? $this->speech($response) : $response;
    }

    public function speech(string $message): string
    {
        return OpenAI::audio()->speech([
            'model' => 'tts-1',
            'input' => $message,
            'voice' => 'alloy',
        ]);
    }

    public function reply(string $message): string
    {
        return $this->send($message);
    }

    public function visualize(string $message, array $options = []): string
    {
        $this->addMessage($message);

        $description = collect($this->messages)->where('role', 'user')->pluck('content')->implode(' ');

        $options = array_merge([
            'prompt' => $description,
            'model' => 'dall-e-3'
        ], $options);

        $imgUrl = OpenAI::images()->create($options)->data[0]->url;

        $this->addMessage($imgUrl, "assistant");

        return $imgUrl;
    }

    protected function addMessage(string $message, string $role = 'user'): self
    {
        $this->messages[] = [
            'role' => $role,
            'content' => $message
        ];

        return $this;
    }

    public function messages()
    {
        return $this->messages;
    }
}