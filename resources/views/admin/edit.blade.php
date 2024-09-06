@extends('backend.layouts.app')

@section('title', 'Edit User')

@push('styles')
    <!-- Add any additional stylesheets here if necessary -->
@endpush

@section('content')


    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>EDIT USER</h2>
                </div>
                <div class="body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="name" class="form-control" value="{{$user->name}}" required>
                                <label class="form-label">Name</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="email" name="email" class="form-control" value="{{$user->email}}" required>
                                <label class="form-label">Email</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-indigo btn-lg m-t-15 waves-effect">
                            <i class="material-icons">update</i>
                            <span>Update</span>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- Add any additional scripts here if necessary -->
@endpush
