@extends('frontend.layouts.master')

@section('content')

    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('/frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>menu Details</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">home</a></li>
                        <li><a href="#">menu Details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--=============================
        MENU DETAILS START
    ==============================-->
    <section class="fp__menu_details mt_115 xs_mt_85 mb_95 xs_mb_65">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-9 wow fadeInUp" data-wow-duration="1s">
                    <div class="exzoom hidden" id="exzoom">
                        <div class="exzoom_img_box fp__menu_details_images">
                            <ul class='exzoom_img_ul'>
                                @foreach ($product->images as $image)

                                <li><img class="zoom ing-fluid w-100" src="{{ asset($image->image) }}" alt="product"></li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="exzoom_nav"></div>
                        <p class="exzoom_btn">
                            <a href="javascript:void(0);" class="exzoom_prev_btn"> <i class="far fa-chevron-left"></i>
                            </a>
                            <a href="javascript:void(0);" class="exzoom_next_btn"> <i class="far fa-chevron-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_details_text">
                        <h2>{{ $product->name }}</h2>
                        <p class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                            <span>(201)</span>
                        </p>
                        <h3 class="price">
                            @if ($product->offer_price > 0)
                            <input type="hidden" name="base_price" value="{{ $product->offer_price }}">
                                {{ currencyPosition($product->offer_price) }}
                                <del>{{ currencyPosition($product->price) }}</del>
                            @else
                            <input type="hidden" name="base_price" value="{{ $product->offer_price }}">
                                {{ currencyPosition($product->price) }}
                            @endif
                        </h3>
                        <p class="short_description">{!! $product->short_description !!}</p>
                        <form action="{{ route('add-to-cart') }}" method="POST" id="v-add-to-cart">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="base_price"
                            value="{{ $product->offer_price > 0 ? $product->offer_price : $product->price }}" class="base_price">
                            @if ($product->sizes()->exists())
                            <div class="details_size">
                                <h5>select size</h5>
                                @foreach ($product->sizes as $size)

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="size" id="{{ $size->size }}" data-price="{{ $size->price }}" value="{{ $size->id }}">
                                    <label class="form-check-label" for="{{ $size->size }}">
                                        {{ $size->size }} <span>+ {{ currencyPosition($size->price) }}</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            @if ($product->options()->exists())
                            <div class="details_extra_item">
                                <h5>select option <span>(optional)</span></h5>
                                @foreach ($product->options as $option)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-price="{{ $option->price }}" name="option[]" value="{{ $option->id }}" id="{{ $option->id }}">
                                    <label class="form-check-label" for="{{ $option->id }}">
                                        {{ $option->name }}
                                        <span>+ {{ currencyPosition($option->price) }}</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            <div class="details_quentity">
                                <h5>select quentity</h5>
                                <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                                    <div class="quentity_btn">
                                        <button class="btn btn-danger decrement"><i class="fal fa-minus"></i></button>
                                        <input type="text" name="quentity" id="quentity" value="1" readonly>
                                        <button class="btn btn-success increment"><i class="fal fa-plus"></i></button>
                                    </div>
                                    @if ($product->offer_price > 0)
                                        <h3 id="total_price">{{ currencyPosition($product->offer_price) }}</h3>
                                    @else
                                        <h3 id="total_price">{{ currencyPosition($product->price) }}</h3>
                                    @endif
                                </div>
                            </div>
                        <ul class="details_button_area d-flex flex-wrap">
                            @if ($product->quantity === 0)
                            <li><button type="button" class="common_btn bg-danger">out of stock</button></li>
                            @else
                            <li><button type="submit" class="common_btn v-add-to-cart" >add to cart</button></li>
                            @endif
                            <li><a class="wishlist" href="#"><i class="far fa-heart"></i></a></li>
                        </ul>
                    </div>
                </form>
                </div>
                <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_description_area mt_100 xs_mt_70">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab" tabindex="0">
                                <div class="menu_det_description">
                                    {{ $product->short_description }}
                                    {!! $product->long_description !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab" tabindex="0">
                                <div class="fp__review_area">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h4>04 reviews</h4>
                                            <div class="fp__comment pt-0 mt_20">
                                                <div class="fp__single_comment m-0 border-0">
                                                    <img src="images/comment_img_1.png" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3>Michel Holder <span>29 oct 2022 </span></h3>
                                                        <span class="rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fad fa-star-half-alt"></i>
                                                            <i class="fal fa-star"></i>
                                                            <b>(120)</b>
                                                        </span>
                                                        <p>Sure there isn't anything embarrassing hiidden in the
                                                            middles of text. All erators on the Internet
                                                            tend to repeat predefined chunks</p>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/chef_1.jpg" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3>salina khan <span>29 oct 2022 </span></h3>
                                                        <span class="rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fad fa-star-half-alt"></i>
                                                            <i class="fal fa-star"></i>
                                                            <b>(120)</b>
                                                        </span>
                                                        <p>Sure there isn't anything embarrassing hiidden in the
                                                            middles of text. All erators on the Internet
                                                            tend to repeat predefined chunks</p>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/comment_img_2.png" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3>Mouna Sthesia <span>29 oct 2022 </span></h3>
                                                        <span class="rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fad fa-star-half-alt"></i>
                                                            <i class="fal fa-star"></i>
                                                            <b>(120)</b>
                                                        </span>
                                                        <p>Sure there isn't anything embarrassing hiidden in the
                                                            middles of text. All erators on the Internet
                                                            tend to repeat predefined chunks</p>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/chef_3.jpg" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3>marjan janifar <span>29 oct 2022 </span></h3>
                                                        <span class="rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fad fa-star-half-alt"></i>
                                                            <i class="fal fa-star"></i>
                                                            <b>(120)</b>
                                                        </span>
                                                        <p>Sure there isn't anything embarrassing hiidden in the
                                                            middles of text. All erators on the Internet
                                                            tend to repeat predefined chunks</p>
                                                    </div>
                                                </div>
                                                <a href="#" class="load_more">load More</a>
                                            </div>

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="fp__post_review">
                                                <h4>write a Review</h4>
                                                <form>
                                                    <p class="rating">
                                                        <span>select your rating : </span>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <input type="text" placeholder="Name">
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <input type="email" placeholder="Email">
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <textarea rows="3"
                                                                placeholder="Write your review"></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <button class="common_btn" type="submit">submit
                                                                review</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($relatedProducts->count() > 0)
            <div class="fp__related_menu mt_90 xs_mt_60">
                <h2>related item</h2>
                <div class="row related_product_slider">
                    @foreach ($relatedProducts as $product)
                    <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__menu_item">
                            <div class="fp__menu_item_img">
                                <img src="{{ asset($product->thumb_image) }}" alt="menu" class="img-fluid w-100">
                                <a class="category" href="#">chicken</a>
                            </div>
                            <div class="fp__menu_item_text">
                                <p class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                    <span>74</span>
                                </p>
                                <a class="title" href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                @if ($product->offer_price > 0)
                                <h5 class="price">{{ currencyPosition($product->offer_price) }}
                                    <del>{{ currencyPosition($product->price) }}</del>
                                </h5>
                                @else
                                    {{ currencyPosition($product->price) }}
                                @endif

                                <ul class="d-flex flex-wrap justify-content-center">
                                    <li><a href="javascript:;" onclick="loadProductModel('{{ $product->id }}')"><i class="fas fa-shopping-basket"></i></a></li>
                                    <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                    <li><a href="#"><i class="far fa-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
    @include('frontend.home.components.cart_popup')
@endsection
@push('scripts')

<script>
    $(document).ready(function(){
        const $basePriceInput = $('input[name="base_price"]');
        const $sizeInput = $('input[name="size"]');
        const $optionInput = $('input[name="option[]"]');
        const $totalPrice = $('#total_price');
        const $quentity = $('#quentity');

        $('.increment').on('click',function(e){
            e.preventDefault();
            let quentity = $('#quentity');
            let currentQuentity = Number(quentity.val());
            quentity.val(currentQuentity + 1);

            updateTotalPrice();
        });

        $('.decrement').on('click',function(e){
            e.preventDefault();
            let quentity = $('#quentity');
            let currentQuentity = Number(quentity.val());
            if(currentQuentity > 1){
                quentity.val(currentQuentity - 1);

                updateTotalPrice();
            }
        })

        $sizeInput.add($optionInput).on('change', updateTotalPrice);

        function updateTotalPrice(){
            let basePrice = Number($basePriceInput.val()) || 0;
            let sizePrice = Number($sizeInput.filter(':checked').data('price')) || 0;

            let optionPrice = 0;
            $optionInput.filter(':checked').each(function(){
                optionPrice += Number($(this).data('price')) || 0;
            });

            let totalPrice = (basePrice + sizePrice + optionPrice) * Number($quentity.val());
            $totalPrice.text( "{{ currencyPosition(':totalPrice') }}".replace(':totalPrice', totalPrice));

        }

        $('#v-add-to-cart').on('submit',function(e){
            e.preventDefault();

            let url = $(this).attr('action');
            let formData = new FormData(this);

            if($sizeInput.length > 0){
                if($sizeInput.filter(':checked').val() === undefined){
                    toastr.error('Please select a size');
                    return false;
                }
            }

            $.ajax({
                method: 'POST',
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function(){
                    $('.v-add-to-cart').html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span>Loading...');
                },
                success: function(response){
                    if (response.status == 'success') {
                        updateSidebarCart();
                        toastr.success(response.message);
                    }
                },
                error: function(xhr,status,error){
                    let errorMessage = xhr.responseJSON.message;
                    toastr.error(errorMessage);
                },
                complete: function() {
                    $('.v-add-to-cart').text('Add to cart');
                }
            })
        })


    })
</script>
@endpush
