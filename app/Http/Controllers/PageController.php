<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(?string $path = null)
    {
        $path = trim($path ?? '', '/');

        // Handle homepage: either full_path='' (root) or a dedicated "home" record
        if ($path === '') {
            $page = Page::query()->whereNull('parent_id')->where('slug','')->first()
                 ?? Page::query()->where('full_path','home')->first();
        } else {
            $page = Page::query()
                ->with(['sections.sectionable' => function ($morph) {
                    // eager-load nested relations where useful
                    $morph->with(['products' => fn($q) => $q->where('is_active', true)]);
                }])
                ->where('full_path', $path)
                ->first();
        }

        abort_if(! $page || ! $page->is_published, 404);

        return view('page', compact('page'));
    }
}
