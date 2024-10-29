@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Category</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Category</h4>
                <div class="card-header-action">

                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.category.update',$Category->id) }}" method="POST" >
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $Category->name }}">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option @selected($Category->status  === 1) value="1">Active</option>
                            <option @selected($Category->status  === 0) value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Show at Home</label>
                        <select name="show_at_home" class="form-control">
                            <option @selected($Category->show_at_home  === 1) value="1">Yes</option>
                            <option @selected($Category->show_at_home  === 0) value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection

