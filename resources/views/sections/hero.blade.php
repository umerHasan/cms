
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>{{ $section->title }}</h1>
                    <p class="mb-4">{{ $section->description }}</p>
                    <p><a href="{{ $section->primary_url }}" class="btn btn-secondary me-2">{{ $section->primary_button_text }}</a><a href="{{ $section->secondary_url }}" class="btn btn-white-outline">{{ $section->secondary_button_text }}</a></p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-img-wrap">
                    <img src="{{ asset('storage/' . $section->image_path) }}" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>