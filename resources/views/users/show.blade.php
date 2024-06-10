@extends('layouts.app')

@section('content')
    <div class="main py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h5">{{ __('Users') }}</h2>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Create New User</a>
        </div>

        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border-gray-200">{{ __('UserName') }}</th>
                        <th class="border-gray-200">{{ __('Email') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="fw-normal">{{ $user->username }}</span></td>
                        <td><span class="fw-normal">{{ $user->email }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
