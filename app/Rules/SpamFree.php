<?php

namespace App\Rules;

use Closure;
use App\AI\Assistant;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Contracts\Validation\ValidationRule;

class SpamFree implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $assistant = new Assistant();

        $response = $assistant->gptModel('gpt-3.5-turbo-1106')
            ->systemMessage('Your are a forum moderator who always responds using JSON.')
            ->send(<<<EOT
                Please detect the following text and determine if it is spam.

                {$value}

                Expected response example:

                {"is_spam" :true|false}
                EOT);

        /*$response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo-1106',
            'messages' => [
                ['role' => 'system', 'content' => 'Your are a forum moderator who always responds using JSON.'],
                [
                    'role' => 'user',
                    // 'content' => "Please detect the following text and determine if it is spam.\n\n".$attributes['body']
                    //EOT means heredoc from PHP
                    'content' => <<<EOT
                        Please detect the following text and determine if it is spam.

                        {$attributes['body']}

                        Expected response example:

                        {"is_spam" :true|false}
                        EOT
                ]
            ],
            'response_format' => ['type' => 'json_object']
        ])->choices[0]->message->content;*/

        $response = json_decode($response);

        if($response->is_spam){
            fail("Spam was detected.");
        }
    }
}
