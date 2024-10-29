@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Products Gallery ({{ $product->name }})</h1>
        </div>
        <div>
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary my-3">Go Back</a>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>All images</h4>

            </div>
            <div class="card-body">
                <div class="col-md-8">
                    <form action="{{ route('admin.product-gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" name="image" class="form-control">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-body">
                <table class="table table-borderd">
                    <thead>
                        <tr></tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($gallerys as $gallery)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset($gallery->image) }}" width="100" alt="">
                            </td>
                            <td>
                                <a href='{{ route('admin.product-gallery.destroy', $gallery->id) }}' class='btn btn-danger mx-2 delete-item' title='delete' ><i class='fas fa-trash'></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">
                                <div class="alert alert-warning text-center">No data Found!</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
