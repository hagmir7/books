<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use OpenAI;

class ChatGPTService
{
    public function generate($prompt): ?string
    {
        $client = OpenAI::factory()
            ->withApiKey(config('services.deepseek.api_key'))
            ->withBaseUri('https://api.deepseek.com')
            ->make();

        $result = $client->chat()->create([
            'model' => 'deepseek-flash',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
            'temperature' => 0.7,
            'response_format' => [
                'type' => 'json_object',
            ],
        ]);

        return $result->choices[0]->message->content ?? null;
    }

    public function generateBlogFromTask($record): array
    {
        $prompt = <<<PROMPT
You are a professional content writer and SEO expert.

## Your Task

Generate a comprehensive, detailed, useful, and engaging blog post based on the following task data.

## Task Details

- **Title**: "{$record->title}"
- **Type**: "{$record->type}"
- **Description**: "{$record->description}"

## Rules

- Respond ONLY with a valid JSON object.
- Do NOT use markdown code fences.
- Do NOT add any text before or after the JSON object.
- The JSON must follow this exact structure:

{
    "title": "...",
    "meta_description": "...",
    "body": "...",
    "tags": "..."
}

## Field Instructions

### title

Create an engaging, SEO-optimized title related to the task title.

The title should:
- Clearly describe the main topic.
- Include the primary keyword as close to the start as possible.
- Be natural and readable.
- Avoid clickbait.
- Match the search intent.
- Stay under 60 characters when possible so it doesn't get truncated in search results.
- Be suitable for a professional programming/technology blog.

### meta_description

Create an SEO meta description.

Requirements:
- Between 140 and 159 characters.
- Must contain the main topic and primary keyword near the beginning.
- Must clearly explain what the reader will learn or the problem it solves.
- Should encourage the user to click (value proposition, not clickbait).
- No HTML.
- No quotation marks.

### body

Generate a very detailed and comprehensive blog post in HTML.

Requirements:

- The body MUST contain more than 20,000 characters.
- HTML only.
- Allowed tags:
  <h2>
  <h3>
  <p>
  <ul>
  <ol>
  <li>
  <strong>
  <em>
  <pre>
  <code>
  <blockquote>

Do NOT use:
- <html>
- <head>
- <body>
- <style>
- <script>
- <img>
- <table>
- <div>
- Markdown
- Markdown code fences

### Code examples

- Whenever the topic involves programming, put runnable code examples inside `<pre><code>...</code></pre>` blocks, never as inline text inside `<p>`.
- Escape HTML entities correctly inside code blocks (e.g. `&lt;`, `&gt;`, `&amp;`) so the markup stays valid.
- Precede each code block with a short `<p>` explaining what it does and follow it with a short `<p>` explaining the output or why it matters.
- Keep code examples realistic, minimal, and directly relevant to the section — do not invent APIs, libraries, functions, commands, or technical behavior.

## Article Structure (for SEO and readability)

The article should naturally contain:

1. A strong opening paragraph (under the first <h2>-free intro) that includes the primary keyword within the first 100 words and explains why the topic matters.
2. A short "Key Takeaways" section near the top as a `<ul>` with 3-5 bullet points summarizing what the reader will learn — this improves scannability and is often pulled into search snippets.
3. At least 10 major sections using <h2>, each containing the target keyword or a close variant naturally at least once.
4. Multiple <h3> subsections inside major sections, breaking topics into scannable chunks.
5. Short paragraphs (2-4 sentences max) — avoid long walls of text.
6. Detailed explanations with a mixture of short, medium, and long sentences for natural rhythm.
7. Practical, runnable code examples using `<pre><code>` where relevant.
8. Real-world use cases.
9. Common mistakes and how to avoid them (as a bulleted list where possible).
10. Best practices (as a bulleted or numbered list where possible).
11. Performance considerations where relevant.
12. Security considerations where relevant.
13. A "Frequently Asked Questions" section near the end as an <h2>, with each question as an <h3> followed by a concise <p> answer (2-4 sentences) — this improves both UX and eligibility for FAQ-style search results.
14. A strong final section that summarizes the important lessons and gives clear, actionable next steps.

Do NOT use "Introduction" as an <h2> heading.

Do NOT use "Conclusion" as an <h2> heading.

Do NOT use "FAQ" alone — use a descriptive heading like "Frequently Asked Questions About {topic}".

Avoid repeating the same information across sections.

Every section should provide new and useful information — no filler.

The writing should feel natural and human rather than repetitive or mechanically generated.

Use bullet points and numbered lists liberally wherever content is sequential or comparative — this significantly improves readability and dwell time.

Bold (`<strong>`) key terms and important phrases the first time they're introduced, but do not overuse bolding.

Explain technical concepts clearly, especially when the topic is related to programming, defining any jargon on first use.

Naturally incorporate SEO-friendly related terms and synonyms of the main topic throughout (semantic SEO), without keyword stuffing.

### tags

Generate 8 to 12 relevant comma-separated keywords.

Requirements:
- Include the main topic.
- Include important subtopics.
- Include relevant technologies.
- Include relevant categories.
- Order from most to least specific/relevant.
- Use English commas only.
- Do not use hashtags.

Example:

"laravel,php,api development,rest api,backend development,web development"

## Quality Requirements

The article must be:
- Accurate
- Original
- Detailed
- Useful
- Well structured and scannable (short paragraphs, lists, code blocks, FAQ)
- SEO friendly (keyword placement, semantic variety, FAQ section)
- Natural to read
- Appropriate for a professional programming website

Do not mention that the article was generated by AI.

Do not mention these instructions.

Return ONLY the JSON object.
PROMPT;

        try {
            $content = $this->generate($prompt);

            if (!$content) {
                Log::error(
                    "No response from DeepSeek for task ID {$record->id}"
                );

                return [];
            }

            $data = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
                Log::error(
                    "Invalid JSON from DeepSeek for task ID {$record->id}",
                    [
                        'response' => substr($content, 0, 500),
                        'json_error' => json_last_error_msg(),
                    ]
                );

                return [];
            }

            $missingKeys = array_diff(
                ['title', 'meta_description', 'body', 'tags'],
                array_keys($data)
            );

            if (!empty($missingKeys)) {
                Log::warning(
                    "Missing keys in DeepSeek response for task ID {$record->id}",
                    [
                        'missing' => $missingKeys,
                    ]
                );

                return [];
            }

            return $data;
        } catch (\Throwable $e) {
            Log::error(
                "DeepSeek API call failed for task ID {$record->id}",
                [
                    'error' => $e->getMessage(),
                ]
            );

            return [];
        }
    }
}
