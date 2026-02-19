<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;
        $data['site_id'] = app('site')->id;
        $data['language_id'] = app('site')->language->id;

        if (!empty($data['body'])) {
            $data['body'] = str_replace(
                'chatgpt.com',
                app('site')->domain,
                $data['body']
            );
        }

        return $data;
    }
}
