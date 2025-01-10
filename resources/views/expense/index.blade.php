@section('title', __('Expense Listing'))

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
                                @if(auth()->user()->role->hasPermissionTo('create-expense'))
                                    <a href="{{ route('expense.create', $project->id) }}" class="btn btn-sm btn-primary">
                                        <i data-feather="plus" class="feather me-1"></i>
                                        {{ __('Add Expense') }}
                                    </a>
                                @endif
                                <a href="{{ route('project.index') }}" class="btn btn-sm btn-secondary">
                                    <i data-feather="arrow-left" class="feather me-1"></i>
                                    {{ __('Back') }}
                                </a>
                            </div>
                        </div>
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <div></div>
                            <div>
                                <small>Budget Balance: RM{{ $project->remainingBudget() }}</small>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="3%" >{{ __('No') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th width="8%" class="text-center">{{ __('Status') }}</th>
                                        <th width="8%" class="text-center">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($expenses->count() > 0)
                                        @foreach ($expenses as $index => $expense)
                                        <tr>
                                            <td class="align-middle">{{ $expenses->firstItem() + $index }}.</td>
                                            <td class="align-middle">{{ $expense->date->format('d/m/Y') }}</td>
                                            <td class="align-middle">{{ $expense->description }}</td>
                                            <td class="align-middle">{{ ucfirst($expense->type) }}</td>
                                            <td class="align-middle">RM{{ $expense->amount }}</td>
                                            <td class="text-center align-middle">
                                                @if ($expense->review_status == 0)
                                                    <span class="badge bg-secondary">{{ __('PENDING REVIEW') }}</span>
                                                @elseif ($expense->review_status == 1)
                                                    <span class="badge bg-success">{{ __('APPROVED') }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ __('REJECTED') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="dropdown mx-3">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ __('Action') }}
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if ($expense->review_status == 0)
                                                            @if(auth()->user()->role->hasPermissionTo('review-expense'))
                                                                <li>
                                                                    <a class="dropdown-item" href="#" id="review-button-{{ $expense->id }}">
                                                                        <i data-feather="check-square" class="feather me-2"></i> Review Expense
                                                                    </a>
                                                                </li>                                                                
                                                            @endif
                                                            @if(auth()->user()->role->hasPermissionTo('edit-expense'))
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('expense.edit', [$project->id, $expense->id]) }}">
                                                                        <i data-feather="edit" class="feather me-2"></i> Edit Expense
                                                                    </a>
                                                                </li>                                                                
                                                            @endif
                                                            <script>
                                                                $('#review-button-{{ $expense->id }}').on('click', function() {
                                                                    Swal.fire({
                                                                        title: 'Confirm this expense? ',
                                                                        text: "Please note, this action cannot be undone.",
                                                                        icon: "question",
                                                                        showCloseButton: true,
                                                                        showDenyButton: true,
                                                                        denyButtonText: 'Reject',
                                                                        confirmButtonText: 'Approve'
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            $.ajax({
                                                                                url: "{{ route('expense.approve', [$project->id, $expense->id]) }}",
                                                                                type: 'POST',
                                                                                data: {
                                                                                    _token: '{{ csrf_token() }}'
                                                                                },
                                                                                success: function() {
                                                                                    Swal.fire({
                                                                                        title: "Approved!",
                                                                                        text: "This expense has been approved.",
                                                                                        icon: "success",
                                                                                        showConfirmButton: false,
                                                                                        timer: 2000
                                                                                    }).then(() => {
                                                                                        location.reload();
                                                                                    });
                                                                                }
                                                                            });
                                                                        } else if(result.isDenied) {
                                                                            $.ajax({
                                                                                url: "{{ route('expense.reject', [$project->id, $expense->id]) }}",
                                                                                type: 'POST',
                                                                                data: {
                                                                                    _token: '{{ csrf_token() }}'
                                                                                },
                                                                                success: function() {
                                                                                    Swal.fire({
                                                                                        title: "Rejected!",
                                                                                        text: "This expense has been rejected.",
                                                                                        icon: "error",
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
                                                        @if(auth()->user()->role->hasPermissionTo('delete-expense'))
                                                            <li>
                                                                <a class="dropdown-item" id="delete-button-{{ $expense->id }}" href="#">
                                                                    <i data-feather="trash" class="feather me-2"></i> Delete Expense
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <script>
                                                            $('#delete-button-{{ $expense->id }}').on('click', function() {
                                                                Swal.fire({
                                                                    title: 'Delete this expense? ',
                                                                    text: "Please note, this action cannot be undone.",
                                                                    icon: "question",
                                                                    showCloseButton: true,
                                                                    showDenyButton: true,
                                                                    denyButtonText: 'Cancel',
                                                                    confirmButtonText: 'Delete'
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        $.ajax({
                                                                            url: "{{ route('expense.destroy', [$project->id, $expense->id]) }}",
                                                                            type: 'POST',
                                                                            data: {
                                                                                _token: '{{ csrf_token() }}'
                                                                            },
                                                                            success: function() {
                                                                                Swal.fire({
                                                                                    title: "Deleted!",
                                                                                    text: "This expense has been deleted successfully.",
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
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No projects available at the moment.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            {{ $expenses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')

    @endsection
</x-app-layout>