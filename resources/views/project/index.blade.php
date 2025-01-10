@section('title', __('Project Listing'))

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
                                <a href="{{ route('project.create') }}" class="btn btn-sm btn-primary">
                                    <i data-feather="plus" class="feather me-1"></i>
                                    {{ __('Add Project') }}
                                </a>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="3%" >{{ __('No') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Project Timeline') }}</th>
                                        <th>{{ __('Budget') }}</th>
                                        <th width="8%" class="text-center">{{ __('Status') }}</th>
                                        <th width="8%" class="text-center">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($projects->count() > 0)
                                        @foreach ($projects as $index => $project)
                                        <tr>
                                            <td class="align-middle">{{ $projects->firstItem() + $index }}.</td>
                                            <td class="align-middle">{{ $project->title }}</td>
                                            <td class="align-middle">{{ $project->start_date->format('d/m/Y') }} - {{ $project->end_date->format('d/m/Y') }}</td>
                                            <td>
                                                RM{{ number_format($project->budget, 2) }}
                                            </td>
                                            <td class="text-center align-middle">
                                                @if ($project->status == 0)
                                                    <span class="badge bg-secondary">{{ __('PENDING') }}</span>
                                                @elseif ($project->status == 1)
                                                    <span class="badge bg-warning">{{ __('ONGOING') }}</span>
                                                @else
                                                    <span class="badge bg-success">{{ __('COMPLETED') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="dropdown mx-3">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ __('Action') }}
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if(auth()->user()->role->hasPermissionTo('view-expense'))
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('expense.index', $project->id) }}">
                                                                    <i data-feather="dollar-sign" class="feather me-2"></i> View Expenses
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @if(auth()->user()->role->hasPermissionTo('edit-project'))
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('project.edit', $project->id) }}">
                                                                    <i data-feather="edit" class="feather me-2"></i> Edit Project
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @if(auth()->user()->role->hasPermissionTo('delete-project'))
                                                            <li>
                                                                <a class="dropdown-item" id="delete-button-{{ $project->id }}" href="#">
                                                                    <i data-feather="trash" class="feather me-2"></i> Delete Project
                                                                </a>
                                                            </li>
                                                            <script>
                                                                $('#delete-button-{{ $project->id }}').on('click', function() {
                                                                    Swal.fire({
                                                                        title: 'Delete this project? ',
                                                                        text: "Please note, this action cannot be undone.",
                                                                        icon: "question",
                                                                        showCloseButton: true,
                                                                        showDenyButton: true,
                                                                        denyButtonText: 'Cancel',
                                                                        confirmButtonText: 'Delete'
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            $.ajax({
                                                                                url: "{{ route('project.destroy', [$project->id,]) }}",
                                                                                type: 'POST',
                                                                                data: {
                                                                                    _token: '{{ csrf_token() }}'
                                                                                },
                                                                                success: function() {
                                                                                    Swal.fire({
                                                                                        title: "Deleted!",
                                                                                        text: "This project has been deleted successfully.",
                                                                                        icon: "success",
                                                                                        showConfirmButton: false,
                                                                                        timer: 2000
                                                                                    }).then(() => {
                                                                                        location.reload();
                                                                                    });
                                                                                }
                                                                            });
                                                                        }
                                                                    });
                                                                });
                                                            </script>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">No projects available at the moment.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            {{ $projects->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')

    @endsection
</x-app-layout>