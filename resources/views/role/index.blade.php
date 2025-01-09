@section('title', __('Role Listing'))

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
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('No') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th width="60%">{{ __('Permission') }}</th>
                                    <th width="5%" class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $index => $role)
                                <tr>
                                    <td>{{ $roles->firstItem() + $index }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach ($role->permissions as $permission)
                                            <span class="badge bg-primary">{{ $permission->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $role->id }}">
                                            <i data-feather="edit" class="feather"></i>
                                        </button>
                                        @include('role.modal.edit', ['role' => $role])

                                        <script>
                                            $('#saveButton{{ $role->id }}').on('click', function() {
                                                var data = $('#role-form-{{ $role->id }}').serialize();
                                
                                                $.ajax({
                                                    url: "{{ route('role.update', $role->id) }}",
                                                    type: 'POST',
                                                    data: data,
                                                    success: function() {
                                                        location.href = '{{ route('role.index') }}';
                                                    }
                                                });
                                            })
                                        </script>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')

    @endsection
</x-app-layout>