@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Delivery Area</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Delivery Area</h4>
                <div class="card-header-action">

                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.delivery-area.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Area Name</label>
                        <input type="text" class="form-control" name="area_name" value="{{ old('area_name') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Minimum Delivery Time (in minutes)</label>
                                <input type="text" class="form-control" name="min_delivery_time" value="{{ old('min_delivery_time') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Maximum Delivry Time (in minutes)</label>
                                <input type="text" class="form-control" name="max_delivery_time" value="{{ old('max_delivery_time') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Delivry Fee</label>
                                <input type="text" class="form-control" name="delivery_fee" value="{{ old('delivery_fee') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
@endsection

