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
                        <th class="border-gray-200">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><span class="fw-normal">{{ $user->username }}</span></td>
                            <td><span class="fw-normal">{{ $user->email }}</span></td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div
                class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "paging": true,        // Enable pagination
                "lengthChange": true,  // Enable the option to show 10/25 entries
                "searching": true,     // Enable search
                "info": true,         // Show table information
                "order": [],           // Disable initial sorting
                "language": {
                    "paginate": {
                        "next": "{{ __('Next') }}",
                        "previous": "{{ __('Previous') }}"
                    },
                    "lengthMenu": "{{ __('Show') }} _MENU_ {{ __('entries') }}",
                    "search": "{{ __('Search') }}:"
                }
            });
        });
    </script>
@endsection
