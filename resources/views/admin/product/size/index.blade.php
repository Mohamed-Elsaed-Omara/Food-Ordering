@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Products Variants ({{ $product->name }})</h1>
        </div>
        <div>
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary my-3">Go Back</a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Product Size</h4>

                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.product-size.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Size</label>
                                        <input type="text" name="size" class="form-control">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input type="text" name="price" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-body">
                        <table class="table table-borderd">
                            <thead>
                                <tr></tr>
                                <th>#</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($product->sizes as $size)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $size->size }}
                                        </td>
                                        <td>
                                            {{ currencyPosition($size->price) }}
                                        </td>
                                        <td>
                                            <a href='{{ route('admin.product-size.destroy', $size->id) }}'
                                                class='btn btn-danger mx-2 delete-item' title='delete'><i
                                                    class='fas fa-trash'></i></a>
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
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Product Options</h4>

                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.product-option.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input type="text" name="price" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-body">
                        <table class="table table-borderd">
                            <thead>
                                <tr></tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($product->options as $productOption)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $productOption->name }}
                                        </td>
                                        <td>
                                            {{ currencyPosition($productOption->price) }}
                                        </td>
                                        <td>
                                            <a href='{{ route('admin.product-option.destroy', $productOption->id) }}'
                                                class='btn btn-danger mx-2 delete-item' title='delete'><i
                                                    class='fas fa-trash'></i></a>
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
            </div>
        </div>

    </section>
@endsection
