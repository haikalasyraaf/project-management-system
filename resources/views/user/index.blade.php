@section('title', __('User Listing'))

@section('breadcrumbs')
@if (!empty($breadcrumbs))
    @foreach ($breadcrumbs as $breadcrumb)
        @if (isset($breadcrumb['link']))
            <a href="{{ $breadcrumb['link'] }}" class="text-primary">{{ $breadcrumb['name'] }}</a>
        @else
            <span>{{ $breadcrumb['name'] }}</span>
        @endif

        @if (!$loop->last)
            <span class="px-2"><i data-feather="chevron-right"></i></span>
        @endif
    @endforeach
@endif
@endsection

<x-app-layout>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <div></div>
                            <div>
                                <a href="{{ route('user.create') }}" class="btn btn-primary">
                                    <i data-feather="plus" class="feather me-2"></i>
                                    {{ __('Add New Record') }}
                                </a>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('No') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Joined On') }}</th>
                                    <th width="5%" class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $users->firstItem() + $index }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <div class="dropdown mx-3">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ __('Action') }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('user.edit', $user->id) }}">
                                                        <i data-feather="edit" class="feather me-2"></i> Edit User
                                                    </a>
                                                </li>
                                                <li>
                                                    @if (Auth::user()->id != $user->id)
                                                        <a class="dropdown-item"
                                                            href="{{ route('user.destroy', $user->id) }}">
                                                            <i data-feather="trash" class="feather me-2"></i> Delete User
                                                        </a>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')

    @endsection
</x-app-layout>