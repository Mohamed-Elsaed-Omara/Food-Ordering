@extends('frontend.layouts.master')
@section('content')
<!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>checkout</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">home</a></li>
                        <li><a href="javascript:void(0)">checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        CHECK OUT PAGE START
    ==============================-->
    <section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__checkout_form">
                        <div class="fp__check_form">
                            <h5>select address <a href="#" data-bs-toggle="modal" data-bs-target="#address_modal"><i
                                        class="far fa-plus"></i> add address</a></h5>

                            <div class="fp__address_modal">
                                <div class="modal fade" id="address_modal" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="address_modalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="address_modalLabel">add new address
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="fp_dashboard_new_address d-block">
                                                <form action="{{ route('address.create') }}" method="POST" id="address_form_create">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                                            <div class="fp__check_single_form">
                                                                <select class="nice-select" name="delivery_area_id">
                                                                    <option @readonly(true) value="">select Area</option>
                                                                    @foreach ($deliveryAreas as $deliveryArea)
                                                                        <option value="{{ $deliveryArea->id }}">{{ $deliveryArea->area_name }}</option>
                                                                    @endforeach

                                                                </select>
                                                                <div style="color: red" id="delivery_area_id_error" class="error-message">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="fp__check_single_form">
                                                                <input type="text" placeholder="First Name" name="first_name">
                                                                <div style="color: red" id="first_name_error" class="error-message">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="fp__check_single_form">
                                                                <input type="text" placeholder="Last Name" name="last_name">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="fp__check_single_form">
                                                                <input type="text" placeholder="Phone" name="phone">
                                                                <div style="color: red" id="phone_error" class="error-message">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="fp__check_single_form">
                                                                <input type="text" placeholder="Email" name="email">
                                                                <div style="color: red" id="email_error" class="error-message">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                                            <div class="fp__check_single_form">
                                                                <textarea cols="3" rows="4" placeholder="Address" name="address"></textarea>
                                                                <div style="color: red" id="address_error" class="error-message">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="fp__check_single_form check_area">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" value="home" id="flexRadioDefault1"
                                                                        name="type">
                                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                                        home
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" value="office" id="flexRadioDefault2"
                                                                        name="type">
                                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                                        office
                                                                    </label>
                                                                </div>
                                                                <div style="color: red" id="type_error" class="error-message">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="" style="display: flex; justify-content: space-between">
                                                            <button type="button" class="common_btn cancel_new_address">cancel</button>
                                                            <button type="submit" class="common_btn">save
                                                                address</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @foreach ($addresses as $address)
                                <div class="col-md-6">
                                    <div class="fp__checkout_single_address">
                                        <div class="form-check">
                                            <input class="form-check-input v_address" value="{{ $address->id }}" type="radio" name="flexRadioDefault"
                                                id="home">
                                            <label class="form-check-label" for="home">
                                                <span class="icon"><i class="fas {{ $address->type === 'home' ? 'fa-home' : 'fa-car-building' }}"></i> {{ $address->type === 'home' ? 'home' : 'office' }}</span>
                                                <span class="address">{{ $address->address }}, {{ $address->deliveryArea?->area_name }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                @endforeach

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div id="sticky_sidebar" class="fp__cart_list_footer_button">
                        <h6>total cart</h6>
                        <p>subtotal: <span>{{ currencyPosition(calculateTotal()) }}</span></p>
                        <p>delivery: <span id="delivery_fee">$00.00</span></p>
                        <p>discount: <span>
                            @if (session()->has('coupon'))
                                {{ currencyPosition(session()->get('coupon')['discount']) }}
                            @else
                                {{ currencyPosition(0) }}
                            @endif
                        </span></p>
                        <p class="total"><span>total:</span> <span id="grand_total">{{ currencyPosition(grandCartTotal()) }}</span></p>
                        <a class="common_btn" href=" #" id="process_to_payment" >Proccess To Payment</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        CHECK OUT PAGE END
    ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {


            $('#address_form_create').submit(function(e) {
                e.preventDefault();

                var formData = new FormData($(this)[0]);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    method: 'POST',
                    url: '{{ route("address.create") }}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.message) {

                            $('#address_form_create')[0].reset();
                            $('.error-message').text('');

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-start',
                                showConfirmButton: false,
                                timer: 4000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal
                                        .stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                            // Redirect to the index page after success
                            setTimeout(function() {
                                window.location.href =
                                "{{ route('checkout') }}"; // Adjust the route as necessary
                            }, 2000); // Adjust the time if needed (4 seconds in this case)
                        }
                    },
                    error: function(error) {
                        $('.error-message').text('');

                        if (error.responseJSON.errors) {
                            var errors = error.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                var errorMessage = messages.join(', ');
                                $('#' + field + '_error').text(errorMessage);
                            });
                        }
                    }
                });
            });

            $('.v_address').prop('checked', false);
            $('.v_address').on('click', function() {
                let addressId = $(this).val();
                let deliveryFee = $('#delivery_fee');
                let grandTotal = $('#grand_total');

                $.ajax({
                    method: 'GET',
                    url: '{{ route("checkout.delivery-cal", ':id') }}'.replace(':id',addressId),
                    beforeSend:function(){
                        $('.overlay-container').removeClass('d-none');
                        $('.overlay').addClass('active');
                    },
                    success: function(response){
                        deliveryFee.text("{{ currencyPosition(':amount') }}".replace(':amount',response.delivery_fee.toFixed(2)));
                        grandTotal.text("{{ currencyPosition(':amount') }}".replace(':amount',response.grand_total.toFixed(2)));
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        $('.overlay').removeClass('active');
                        $('.overlay-container').addClass('d-none');
                    }

                })
            })

            $('#process_to_payment').on('click', function(e) {
                e.preventDefault();
                let address = $('.v_address:checked');

                if(address.length === 0){
                    toastr.error('Please Select Address');
                    return false;
                }

                $.ajax({
                    method: 'POST',
                    url: '{{ route("checkout.redirect") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        id : address.val()
                    },beforeSend:function(){
                        $('.overlay-container').removeClass('d-none');
                        $('.overlay').addClass('active');
                    },
                    success: function(response){
                        window.location.href = response.redirect;
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        $('.overlay').removeClass('active');
                        $('.overlay-container').addClass('d-none');
                    }
                })
            })

        })
    </script>
@endpush
