<div class="we-help-section">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <div class="imgs-grid">
                    <div class="grid grid-1">
                        @if(!empty($section->grid_image_1))
                            <img src="{{ asset('storage/' . $section->grid_image_1) }}" alt="Image 1">
                        @else
                            <img src="{{ asset('assets/images/img-grid-1.jpg') }}" alt="Image 1">
                        @endif
                    </div>
                    <div class="grid grid-2">
                        @if(!empty($section->grid_image_2))
                            <img src="{{ asset('storage/' . $section->grid_image_2) }}" alt="Image 2">
                        @else
                            <img src="{{ asset('assets/images/img-grid-2.jpg') }}" alt="Image 2">
                        @endif
                    </div>
                    <div class="grid grid-3">
                        @if(!empty($section->grid_image_3))
                            <img src="{{ asset('storage/' . $section->grid_image_3) }}" alt="Image 3">
                        @else
                            <img src="{{ asset('assets/images/img-grid-3.jpg') }}" alt="Image 3">
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-5 ps-lg-5">
                <h2 class="section-title mb-4">{{ $section->title ?? 'We Help You Make Modern Interior Design' }}</h2>
                @if(!empty($section->body))
                    <p>{{ $section->body }}</p>
                @endif

                @php($items = $section->list_items ?? [])
                @if(!empty($items))
                    <ul class="list-unstyled custom-list my-4">
                        @foreach($items as $it)
                            @if(!empty($it['text']))
                                <li>{{ $it['text'] }}</li>
                            @endif
                        @endforeach
                    </ul>
                @endif

                @if(!empty($section->button_text) && $section->button_url)
                    <p><a href="{{ $section->button_url }}" class="btn">{{ $section->button_text }}</a></p>
                @endif
            </div>
        </div>
    </div>
</div>
