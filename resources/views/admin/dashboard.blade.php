@extends('backend.layouts.app')

@section('title', 'Dashboard')

@push('styles')

@endpush


@section('content')

<div class="block-header">
    <h2>DASHBOARD</h2>
</div>

<!-- Widgets -->
<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink hover-expand-effect">
            <div class="icon">
                <i class="material-icons">playlist_add_check</i>
            </div>
            <div class="content">
                <div class="text">TOTAL PROPERTY</div>
                <div class="number count-to" data-from="0" data-to="{{ $propertycount }}" data-speed="15" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon">
                <i class="material-icons">help</i>
            </div>
            <div class="content">
                <div class="text">TOTAL POST</div>
                <div class="number count-to" data-from="0" data-to="{{ $postcount }}" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-light-green hover-expand-effect">
            <div class="icon">
                <i class="material-icons">forum</i>
            </div>
            <div class="content">
                <div class="text">TOTAL COMMENT</div>
                <div class="number count-to" data-from="0" data-to="{{ $commentcount }}" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-orange hover-expand-effect">
            <div class="icon">
                <i class="material-icons">person_add</i>
            </div>
            <div class="content">
                <div class="text">TOTAL USER</div>
                <div class="number count-to" data-from="0" data-to="{{ $usercount }}" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Widgets -->

<div class="row clearfix">
    <!-- RECENT PROPERTIES -->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="header">
                <h2>RECENT PROPERTIES</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>City</th>
                                <th><i class="material-icons small">star</i></th>
                                <th>Manager</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($properties as $key => $property)
                            <tr>
                                <td>{{ ++$key }}.</td>
                                <td>
                                    <span title="{{ $property->title }}">
                                        {{ str_limit($property->title, 10) }}
                                    </span>
                                </td>
                                <td><span>&#8360;</span>{{ $property->price }}</td>
                                <td>{{ $property->city }}</td>
                                <td>
                                    @if($property->featured == 1)
                                    <span class="label bg-green">F</span>
                                    @endif
                                </td>
                                <td>{{ strtok($property->user->name, " ")}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# RECENT PROPERTIES -->

    <!-- RECENT POSTS -->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="header">
                <h2>RECENT POSTS</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Title</th>
                                <th><i class="material-icons small">comment</i></th>
                                <th>Author</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $key => $post)
                            <tr>
                                <td>{{ ++$key }}.</td>
                                <td>
                                    <span title="{{ $post->title }}">
                                        {{ str_limit($post->title, 30) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="label bg-green">{{ $post->comments_count }}</span>
                                </td>
                                <td>{{ strtok($post->user->name, " ")}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# RECENT POSTS -->
</div>

<div class="row clearfix">
    <!-- USER LIST -->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="header">
                <h2>USER LIST</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                            <!-- <tr>
                                <td>{{ ++$key }}.</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>
                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>

                               
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="margin-top: 20px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr> -->
                            <tr>
                                <td>{{ ++$key }}.</td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $user->name }}" disabled id="name-{{ $user->id }}">
                                </td>
                                <td>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled id="email-{{ $user->id }}">
                                </td>
                                <td>{{ $user->role->name }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" onclick="editUser({{ $user->id }})">Edit</button>
                                    <button type="button" class="btn btn-success" onclick="saveUser({{ $user->id }})" style="display: none;">Save</button>
                                    <button type="button" class="btn btn-danger" onclick="deleteUser({{ $user->id }})">Delete</button>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# USER LIST -->

    <!-- RECENT COMMENTS -->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="header">
                <h2>RECENT COMMENTS</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Comment</th>
                                <th><i class="material-icons small">check</i></th>
                                <th>Author</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comments as $key => $comment)
                            <tr>
                                <td>{{ ++$key }}.</td>
                                <td>
                                    <span title="{{ $comment->body }}">
                                        {{ str_limit($comment->body, 10) }}
                                    </span>
                                </td>
                                <td>
                                    @if($comment->approved == 1)
                                    <span class="label bg-green">A</span>
                                    @else
                                    <span class="label bg-red">N</span>
                                    @endif
                                </td>
                                <td>{{ strtok($comment->users->name, " ")}}</td>
                                <td>{{ $comment->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# RECENT COMMENTS -->
</div>


@endsection

@push('scripts')

<!-- Jquery CountTo Plugin Js -->
<script src="{{ asset('backend/plugins/jquery-countto/jquery.countTo.js') }}"></script>

<!-- Sparkline Chart Plugin Js -->
<script src="{{ asset('backend/js/pages/index.js') }}"></script>
<script>
    function editUser(userId) {
        document.getElementById('name-' + userId).disabled = false;
        document.getElementById('email-' + userId).disabled = false;
        document.querySelector(`button[onclick="saveUser(${userId})"]`).style.display = 'inline-block'; // Show save button
        document.querySelector(`button[onclick="editUser(${userId})"]`).style.display = 'none'; // Hide edit button
    }

    function saveUser(userId) {
        const name = document.getElementById('name-' + userId).value;
        const email = document.getElementById('email-' + userId).value;

        // AJAX request to save data
        fetch(`//${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is included
                },
                body: JSON.stringify({
                    name,
                    email
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                document.getElementById('name-' + userId).disabled = true;
                document.getElementById('email-' + userId).disabled = true;
                document.querySelector(`button[onclick="saveUser(${userId})"]`).style.display = 'none'; // Hide save button
                document.querySelector(`button[onclick="editUser(${userId})"]`).style.display = 'inline-block'; // Show edit button
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    function deleteUser(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            fetch(`/route-to-delete/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is included
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Deleted:', data);
                    document.getElementById('row-' + userId).remove(); // Remove the row
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    }
</script>

@endpush