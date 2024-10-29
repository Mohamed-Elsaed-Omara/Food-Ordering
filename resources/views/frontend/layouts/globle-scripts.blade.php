<script>
    // alert confirm delete

    $('body').on('click', '.delete-item', function(e) {
        e.preventDefault();

        // حفظ مرجع الزر لتتمكن من استخدامه بعد نجاح الحذف
        let $this = $(this);
        let url = $this.attr('href');
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'DELETE',
                    url: url,
                    data: {
                        _token: csrfToken // إضافة الـ CSRF token
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            toastr.success(response.message);

                            // حذف السطر (tr) الذي يحتوي على المنتج المحذوف
                            $this.closest('.parrent').remove();
                        } else if (response.status == 'error') {
                            toastr.error(response.message);
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        });
    });

    function loadProductModel(productId) {
        $.ajax({
            method: 'GET',
            url: '{{ route('load-product-model', ':productId') }}'.replace(':productId', productId),
            beforeSend: function() {
                $('.overlay-container').removeClass('d-none');
                $('.overlay').addClass('active');
            },
            success: function(response) {
                $('.load_product_model_body').html(response);
                $('#cartModal').modal('show');
            },
            error: function(error) {
                console.log(error)
            },
            complete: function() {
                $('.overlay').removeClass('active');
                $('.overlay-container').addClass('d-none');
            }
        });

    }

    function updateSidebarCart(callback = null) {

        $.ajax({
            method: 'GET',
            url: '{{ route('get-cart-products') }}',
            success: function(response) {
                $('.cart_list').html(response);
                let cartTotal = $('#cart_total').val();
                let cartCount = $('#cart_product_count').val();
                $('.sub_total').text("{{ currencyPosition(':cartTotal') }}".replace(':cartTotal',
                    cartTotal));
                $('.cart_count').text(cartCount);

                if (callback && typeof callback === 'function') {
                    callback();
                }
            },
            error: function(error) {
                console.log(error);

            }

        })
    }

    function removeProductFromSidebar($rowId) {
        $.ajax({
            method: 'GET',
            url: '{{ route('cart-product-remove', ':rowId') }}'.replace(':rowId', $rowId),
            beforeSend: function() {
                $('.overlay-container').removeClass('d-none');
                $('.overlay').addClass('active');
            },
            success: function(response) {
                if (response.status == 'success') {
                    updateSidebarCart(function() {
                        toastr.success(response.message);
                        $('.overlay').removeClass('active');
                        $('.overlay-container').addClass('d-none');
                    });
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = xhr.responseJSON.message;
                toastr.error(errorMessage);
            }
        });
    }
</script>
