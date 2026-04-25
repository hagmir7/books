<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;

class ChatGPTService
{
    public function generate($prompt)
    {
        return Http::withHeaders([
            'x-rapidapi-host' => config('services.rapidapi.host'),
            'x-rapidapi-key' => config('services.rapidapi.key'),
        ])->get('https://free-chatgpt-api.p.rapidapi.com/chat-completion-one', [
            'prompt' => $prompt
        ])->json();
    }
}
