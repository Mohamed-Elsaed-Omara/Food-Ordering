<div class="tab-pane fade" id="v-pills-address" role="tabpanel" aria-labelledby="v-pills-address-tab">
    <div class="fp_dashboard_body address_body">
        <h3>address <a class="dash_add_new_address"><i class="far fa-plus"></i> add new
            </a>
        </h3>



        <div class="fp_dashboard_address show_edit_address">
            <div class="fp_dashboard_existing_address">
                <div class="row">
                    @foreach ($addresses as $address)
                        <div class="col-md-6 parrent">
                            <div class="fp__checkout_single_address">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <span class="icon"><i
                                                class="fas {{ $address->type === 'home' ? 'fa-home' : 'fa-car-building' }} "></i>
                                            {{ $address->type === 'home' ? 'home' : 'office' }}
                                        </span>
                                        <span class="address">{{ $address->address }},
                                            {{ $address->deliveryArea?->area_name }}</span>
                                    </label>
                                </div>
                                <ul>

                                    <li>
                                        <a  class="dash_edit_btn show_edit_section" data-class="edit_section_{{ $address->id }}"><i class="far fa-edit"></i>
                                        </a>
                                    </li>
                                    <li><a class="dash_del_icon delete-item" href="{{ route('address.destroy', $address->id) }}"><i class="fas fa-trash-alt"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
            <div class="fp_dashboard_new_address ">
                <form action="{{ route('address.create') }}" method="POST" id="address_form_create">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <h4>add new address</h4>
                        </div>
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
                        <div class="col-12">
                            <button type="button" class="common_btn cancel_new_address">cancel</button>
                            <button type="submit" class="common_btn">save
                                address</button>
                        </div>
                    </div>
                </form>
            </div>
            @include('frontend.dashboard.section.edit-address')
        </div>
    </div>
</div>
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
                                "{{ route('dashboard') }}"; // Adjust the route as necessary
                            }, 3000); // Adjust the time if needed (4 seconds in this case)
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

            $('.show_edit_section').on('click', function() {
                let addressClass = $(this).data('class');
                $('.fp_dashboard_edit_address').removeClass('d-block');
                $('.fp_dashboard_edit_address').removeClass('d-none');

                $('.fp_dashboard_existing_address').addClass('d-none');
                $('.'+addressClass).addClass('d-block');
            })


            $('.cancel_edit_address').on('click', function() {
                $('.fp_dashboard_edit_address').addClass('d-none');
                $('.fp_dashboard_existing_address').removeClass('d-none');
            });


        });


    </script>
@endpush
