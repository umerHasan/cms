<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller {
    public function home()
    {
        return $this->show('home');
    }

    public function show(?string $path = null)
    {
        $path = trim($path ?? '', '/');

        $page = Page::where('full_path', $path)->first();

        abort_if(! $page || ! $page->is_published, 404);

        return view('page', compact('page'));
    }
}
