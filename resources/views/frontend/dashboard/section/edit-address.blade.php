@foreach ($addresses as $address)
    <div class="fp_dashboard_edit_address edit_section_{{ $address->id }}">
        <form action="{{ route('address.update', $address->id) }}" method="POST" id="address_form_update">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12">
                    <h4>Edit Address</h4>
                </div>
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="fp__check_single_form">
                        <select class="nice-select" name="update_delivery_area_id">
                            <option disabled value="">Select Area</option>
                            @foreach ($deliveryAreas as $deliveryArea)
                                <option @selected($address->delivery_area_id == $deliveryArea->id) value="{{ $deliveryArea->id }}">{{ $deliveryArea->area_name }}</option>
                            @endforeach
                        </select>
                        <div style="color: red" id="update_delivery_area_id_error" class="error-message"></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-12 col-xl-6">
                    <div class="fp__check_single_form">
                        <input type="text" placeholder="First Name" name="update_first_name" value="{{ $address->first_name }}">
                        <div style="color: red" id="update_first_name_error" class="error-message"></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-12 col-xl-6">
                    <div class="fp__check_single_form">
                        <input type="text" placeholder="Last Name" name="update_last_name" value="{{ $address->last_name }}">
                    </div>
                </div>
                <div class="col-md-6 col-lg-12 col-xl-6">
                    <div class="fp__check_single_form">
                        <input type="text" placeholder="Phone" name="update_phone" value="{{ $address->phone }}">
                        <div style="color: red" id="update_phone_error" class="error-message"></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-12 col-xl-6">
                    <div class="fp__check_single_form">
                        <input type="text" placeholder="Email" name="update_email" value="{{ $address->email }}">
                        <div style="color: red" id="update_email_error" class="error-message"></div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="fp__check_single_form">
                        <textarea cols="3" rows="4" placeholder="Address" name="update_address">{{ $address->address }}</textarea>
                        <div style="color: red" id="update_address_error" class="error-message"></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="fp__check_single_form check_area">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="home" id="flexRadioDefault1" name="update_type" @checked($address->type == 'home')>
                            <label class="form-check-label" for="flexRadioDefault1">Home</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="office" id="flexRadioDefault2" name="update_type" @checked($address->type == 'office')>
                            <label class="form-check-label" for="flexRadioDefault2">Office</label>
                        </div>
                        <div style="color: red" id="update_type_error" class="error-message"></div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="button" class="common_btn cancel_edit_address">Cancel</button>
                    <button type="submit" class="common_btn">Update Address</button>
                </div>
            </div>
        </form>
    </div>
@endforeach

@push('scripts')
<script>
    $(document).ready(function() {
        $('#address_form_update').submit(function(e) {
                e.preventDefault();

                var formData = new FormData($(this)[0]);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.message) {

                            $('#address_form_update')[0].reset();
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
    });
</script>
@endpush
