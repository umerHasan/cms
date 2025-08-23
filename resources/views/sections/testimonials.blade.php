<div class="testimonial-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto text-center">
                <h2 class="section-title">{{ $section->title ?? 'Testimonials' }}</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="testimonial-slider-wrap text-center">

                    <div id="testimonial-nav">
                        <span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
                        <span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
                    </div>

                    <div class="testimonial-slider">
                        @forelse(($section->testimonials ?? []) as $item)
                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">
                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;{{ $item['quote'] ?? '' }}&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    @if(!empty($item['author_image']))
                                                        <img src="{{ asset('storage/' . $item['author_image']) }}" alt="{{ $item['author_name'] ?? 'Author' }}" class="img-fluid">
                                                    @else
                                                        <img src="{{ asset('assets/images/person-1.png') }}" alt="{{ $item['author_name'] ?? 'Author' }}" class="img-fluid">
                                                    @endif
                                                </div>
                                                @if(!empty($item['author_name']))
                                                    <h3 class="font-weight-bold">{{ $item['author_name'] }}</h3>
                                                @endif
                                                @if(!empty($item['author_title']))
                                                    <span class="position d-block mb-3">{{ $item['author_title'] }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">
                                        <p class="text-muted">No testimonials added.</p>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
