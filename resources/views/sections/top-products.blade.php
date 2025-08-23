<div class="product-section">
    <div class="container">
        <div class="row">

            <!-- Left column: heading/body + button -->
            <div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
                <h2 class="mb-4 section-title">{{ $section->title }}</h2>
                @if(!empty($section->body))
                    <p class="mb-4">{{ $section->body }}</p>
                @endif
                @if(!empty($section->button_text) && $section->button_url)
                    <p><a href="{{ $section->button_url }}" class="btn">{{ $section->button_text }}</a></p>
                @endif
            </div>

            <!-- Products grid -->
            @forelse($section->products as $product)
                <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                    <div class="product-item">
                        @if(!empty($product->image_path))
                            <img src="{{ asset('storage/' . $product->image_path) }}" class="img-fluid product-thumbnail">
                        @endif
                        <h3 class="product-title">{{ $product->name }}</h3>
                        @if(!is_null($product->price))
                            <strong class="product-price">${{ number_format($product->price, 2) }}</strong>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12 col-md-9">
                    <p class="text-muted">No products selected.</p>
                </div>
            @endforelse

        </div>
    </div>
    
</div>
