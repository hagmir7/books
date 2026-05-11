<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use OpenAI;

class ChatGPTService
{
    public function generate($prompt): ?string
    {
        $client = OpenAI::client(config('services.openai.api_key'));

        $result = $client->chat()->create([
            'model'           => 'gpt-4o',
            'messages'        => [
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature'     => 0.7,
            'response_format' => ['type' => 'json_object'],
        ]);

        return $result->choices[0]->message->content ?? null;
    }

    public function generateBlogFromTask($record): array
    {
        $prompt = <<<PROMPT
You are a professional content writer and SEO expert.

## Your Task
Generate a comprehensive, detailed, and engaging blog post based on the following task data.

## Task Details
- **Title**: "{$record->title}"
- **Type**: "{$record->type}"
- **Description**: "{$record->description}"

## Rules
- Respond ONLY with a valid JSON object. No text before or after.
- Do NOT use markdown like ```json or ```.
- The JSON must follow this exact structure:

{
  "title": "...",
  "meta_description": "...",
  "body": "...",
  "tags": "..."
}

## Field Instructions

### title
An engaging, SEO-optimized title for the blog post related to the task title.

### meta_description
A short SEO meta description.
- Length: between 140 and 159 characters exactly.
- Must include the main topic and be compelling.
- No HTML tags.

### body
A very long, detailed, comprehensive blog post in HTML format.
- **Length**: MORE THAN 30,000 characters (this is a strict requirement — the longer the better).
- **Format**: HTML only using <h2>, <h3>, <p>, <ul>, <li>, <strong>, <em> tags. No other tags.
- **Style**: Write in a rich, literary, engaging style. Vary sentence lengths. Use vivid language.
- **Structure**:
  - Introduction: context and importance of the topic
  - At least 10 major sections with <h2> headings
  - Each section must have multiple <h3> sub-sections with detailed paragraphs
  - Practical tips, examples, and insights throughout
  - A strong concluding section
- **Forbidden**: Do not use "Introduction" or "Conclusion" as headings. Do not repeat the same idea in multiple paragraphs.

### tags
8 to 12 comma-separated keywords related to the blog post.
- Include: the topic, relevant subtopics, categories.
- Separated by English comma (,).
- Example: "productivity,task management,blog title,..."
PROMPT;

        try {
            $content = $this->generate($prompt);

            if (!$content) {
                Log::error("No response from OpenAI for task ID {$record->id}");
                return [];
            }

            $data = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
                Log::error("Invalid JSON from OpenAI for task ID {$record->id}", [
                    'response'   => substr($content, 0, 500),
                    'json_error' => json_last_error_msg(),
                ]);
                return [];
            }

            $missingKeys = array_diff(['title', 'meta_description', 'body', 'tags'], array_keys($data));
            if (!empty($missingKeys)) {
                Log::warning("Missing keys in OpenAI response for task ID {$record->id}", [
                    'missing' => $missingKeys,
                ]);
                return [];
            }

            return $data;
        } catch (\Exception $e) {
            Log::error("OpenAI API call failed for task ID {$record->id}", [
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }
}
