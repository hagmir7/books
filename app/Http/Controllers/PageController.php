<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Page $page){
        $title = $page->title;
        return view("pages.show", compact('page', 'title'));
    }
}
