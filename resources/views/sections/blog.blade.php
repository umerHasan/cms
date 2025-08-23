<div class="blog-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-6">
                <h2 class="section-title">{{ $section->title ?? 'Recent Blog' }}</h2>
            </div>
            <div class="col-md-6 text-start text-md-end">
                @if(!empty($section->view_all_text) && !empty($section->view_all_href))
                    <a href="{{ $section->view_all_href }}" class="more">{{ $section->view_all_text }}</a>
                @endif
            </div>
        </div>

        <div class="row">
            @forelse($section->posts as $i => $post)
                <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
                    <div class="post-entry">
                        <a href="{{ $post->detail_url ?? '#' }}" class="post-thumbnail">
                            @if(!empty($post->image_path))
                                <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="img-fluid">
                            @else
                                <img src="{{ asset('assets/images/post-'.(($i%3)+1).'.jpg') }}" alt="{{ $post->title }}" class="img-fluid">
                            @endif
                        </a>
                        <div class="post-content-entry">
                            <h3><a href="{{ $post->detail_url ?? '#' }}">{{ $post->title }}</a></h3>
                            <div class="meta">
                                <span>by <a href="#">{{ $post->author_name ?? 'Admin' }}</a></span>
                                @if($post->published_at)
                                    <span>on <a href="#">{{ $post->published_at->format('M d, Y') }}</a></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">No posts selected.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
