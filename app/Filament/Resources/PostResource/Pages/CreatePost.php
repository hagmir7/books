<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Parsedown;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;



    protected function mutateFormDataBeforeCreate(array $data): array
    {


        if($data['markdown']){
            $parsedown = new Parsedown();
            $data['body'] = $parsedown->text($data['body']);
        }
        $data['user_id'] = auth()->user()->id;
        return $data;
    }
}
