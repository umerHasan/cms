<div class="popular-product">
    <div class="container">
        <div class="row">
            @forelse($section->products as $i => $product)
                <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="product-item-sm d-flex">
                        <div class="thumbnail">
                            @if(!empty($product->image_path))
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="img-fluid">
                            @else
                                <img src="{{ asset('assets/images/product-'.(($i%3)+1).'.png') }}" alt="{{ $product->name }}" class="img-fluid">
                            @endif
                        </div>
                        <div class="pt-3">
                            <h3>{{ $product->name }}</h3>
                            @if(!is_null($product->price))
                                <p class="mb-1">${{ number_format($product->price, 2) }}</p>
                            @endif
                            @if(!empty($product->description))
                                <p>{{ \Illuminate\Support\Str::limit($product->description, 90) }}</p>
                            @endif
                            @if(!empty($product->detail_url))
                                <p><a href="{{ $product->detail_url }}">Read More</a></p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                @for($i=0; $i<3; $i++)
                    <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <div class="product-item-sm d-flex">
                            <div class="thumbnail"><img src="{{ asset('assets/images/product-'.($i+1).'.png') }}" alt="Image" class="img-fluid"></div>
                            <div class="pt-3">
                                <h3>Product Title</h3>
                                <p>Add products to this section in the CMS.</p>
                            </div>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>
    </div>
</div>
