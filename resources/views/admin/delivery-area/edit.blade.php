@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Delivery Area</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Delivery Area ({{ $deliveryArea->area_name }})</h4>
                <div class="card-header-action">

                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.delivery-area.update',$deliveryArea->id) }}" method="POST" >
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Area Name</label>
                        <input type="text" class="form-control" name="area_name" value="{{$deliveryArea->area_name  }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Minimum Delivery Time (in minutes)</label>
                                <input type="text" class="form-control" name="min_delivery_time" value="{{ $deliveryArea->min_delivery_time }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Maximum Delivry Time (in minutes)</label>
                                <input type="text" class="form-control" name="max_delivery_time" value="{{ $deliveryArea->max_delivery_time }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Delivry Fee</label>
                                <input type="text" class="form-control" name="delivery_fee" value="{{ $deliveryArea->delivery_fee }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option @selected($deliveryArea->status === 1) value="1">Yes</option>
                                    <option @selected($deliveryArea->status === 0) value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection

