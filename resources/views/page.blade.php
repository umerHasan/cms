@extends('layouts.app')

@section('content')
    @foreach($page->sections as $section)
        @php($s = $section->sectionable)
        @includeIf('sections.' . $section->view_file, ['section' => $s, 'page' => $page])
    @endforeach
@endsection
