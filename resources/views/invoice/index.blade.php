@section('title', __('Invoice Listing'))

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
                                <a href="{{ route('invoice.create') }}" class="btn btn-sm btn-primary">
                                    <i data-feather="plus" class="feather me-1"></i>
                                    {{ __('Generate Invoice') }}
                                </a>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Number') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th width="8%" class="text-center">{{ __('Status') }}</th>
                                        <th width="8%" class="text-center">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($invoices->count() > 0)
                                        @foreach ($invoices as $index => $invoice)
                                        <tr>
                                            <td class="align-middle">{{ $invoice->number }}</td>
                                            <td class="align-middle">RM{{ $invoice->amount }}</td>
                                            <td class="text-center align-middle">
                                                @if ($invoice->status == 0)
                                                    <span class="badge bg-danger">{{ __('UNPAID') }}</span>
                                                @else
                                                    <span class="badge bg-success">{{ __('PAID') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="dropdown mx-3">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ __('Action') }}
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('invoice.show', $invoice->id) }}">
                                                                <i data-feather="dollar-sign" class="feather me-2"></i> View Invoice
                                                            </a>
                                                        </li>
                                                        @if ($invoice->status == 0)
                                                            @if(auth()->user()->role->hasPermissionTo('review-invoice'))
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('invoice.mark-as-paid', $invoice->id) }}">
                                                                        <i data-feather="trending-up" class="feather me-2"></i> Mark As Paid
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endif
                                                        @if(auth()->user()->role->hasPermissionTo('delete-invoice'))
                                                            <li>
                                                                <a class="dropdown-item" id="delete-button-{{ $invoice->id }}" href="#">
                                                                    <i data-feather="trash" class="feather me-2"></i> Delete Invoice
                                                                </a>
                                                            </li>
                                                            <script>
                                                                $('#delete-button-{{ $invoice->id }}').on('click', function() {
                                                                    Swal.fire({
                                                                        title: 'Delete this invoice? ',
                                                                        text: "Please note, this action cannot be undone.",
                                                                        icon: "question",
                                                                        showCloseButton: true,
                                                                        showDenyButton: true,
                                                                        denyButtonText: 'Cancel',
                                                                        confirmButtonText: 'Delete'
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            $.ajax({
                                                                                url: "{{ route('invoice.destroy', [$invoice->id,]) }}",
                                                                                type: 'POST',
                                                                                data: {
                                                                                    _token: '{{ csrf_token() }}'
                                                                                },
                                                                                success: function() {
                                                                                    Swal.fire({
                                                                                        title: "Deleted!",
                                                                                        text: "This invoice has been deleted successfully.",
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
                                            <td colspan="5" class="text-center">No invoices available at the moment.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            {{ $invoices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')

    @endsection
</x-app-layout>