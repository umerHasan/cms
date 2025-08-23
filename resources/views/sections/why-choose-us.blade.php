<div class="why-choose-section">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6">
                <h2 class="section-title">{{ $section->title ?? 'Why Choose Us' }}</h2>
                @if(!empty($section->body))
                    <p>{{ $section->body }}</p>
                @endif

                <div class="row my-5">
                    @forelse(($section->features ?? []) as $item)
                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    @if(!empty($item['icon']))
                                        <img src="{{ asset('storage/' . $item['icon']) }}" alt="{{ $item['title'] ?? 'Icon' }}" class="imf-fluid">
                                    @else
                                        <img src="{{ asset('assets/images/support.svg') }}" alt="Icon" class="imf-fluid">
                                    @endif
                                </div>
                                @if(!empty($item['title']))
                                    <h3>{{ $item['title'] }}</h3>
                                @endif
                                @if(!empty($item['description']))
                                    <p>{{ $item['description'] }}</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">No features added.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-5">
                <div class="img-wrap">
                    @if(!empty($section->image_path))
                        <img src="{{ asset('storage/' . $section->image_path) }}" alt="Why Choose Us" class="img-fluid">
                    @else
                        <img src="{{ asset('assets/images/why-choose-us-img.jpg') }}" alt="Why Choose Us" class="img-fluid">
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
