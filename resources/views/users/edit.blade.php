@extends('layouts.app')

@section('content')
<div class="main py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h5">{{ __('User Edit') }}</h2>
        <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">Back</a>
    </div>

    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <div class ="card-body">
            <form action ="{{ route('users.update',$user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class ="form-group p-2">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name', $user->name) }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class ="form-group p-2">
                    <label for="email">Email</label>
                    <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email', $user->email) }}">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class ="form-group p-2">
                    <button class ="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Include necessary Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection

