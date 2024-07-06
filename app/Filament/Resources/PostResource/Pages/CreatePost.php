<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Site;
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
        $domain = str_replace('www.', '', request()->getHost());
        $site = Site::where('domain', $domain)->firstOrFail();
        $data['site_id'] = $site->id;
        return $data;
    }
}
