<x-app-layout>
    @if (auth()->user()->hasRole('Admin'))
        <div class="row mb-3">
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="text-center rounded-5 p-2" style="border: 1px solid black; width:45px">
                                <i data-feather="server" style="width: 20px !important"></i>
                            </div>
                            <div class="flex-fill text-end">
                                <p class="h4 mb-0">{{ $projects->count() }}</p>
                                <p class="mb-0">Projects</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="text-center rounded-5 p-2" style="border: 1px solid black; width:45px">
                                <i data-feather="x-square" style="width: 20px !important"></i>
                            </div>
                            <div class="flex-fill text-end">
                                <p class="h4 mb-0">{{ $invoices->where('status', 0)->count() }}</p>
                                <p class="mb-0">Unpaid Invoices</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="text-center rounded-5 p-2" style="border: 1px solid black; width:45px">
                                <i data-feather="check-square" style="width: 20px !important"></i>
                            </div>
                            <div class="flex-fill text-end">
                                <p class="h4 mb-0">{{ $invoices->where('status', 1)->count() }}</p>
                                <p class="mb-0">Paid Invoices</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="text-center rounded-5 p-2" style="border: 1px solid black; width:45px">
                                <i data-feather="trending-up" style="width: 20px !important"></i>
                            </div>
                            <div class="flex-fill text-end">
                                <p class="h4 mb-0">{{ $expenses->count() }}</p>
                                <p class="mb-0">Expenses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h4>{{ __('Overdue Invoices') }}</h4>
                        </div>
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice Number</th>
                                    <th>Due On</th>
                                    <th>Amount</th>
                                    <th>Generated By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices->where('due_date', '<', today()) as $overdueInvoice)
                                    <tr>
                                        <td>{{ $overdueInvoice->number }}</td>
                                        <td>{{ $overdueInvoice->due_date->format('d/m/Y') }}</td>
                                        <td>{{ $overdueInvoice->amount }}</td>
                                        <td>
                                            {{ $overdueInvoice->createdBy->name }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">{{ __('No overdue invoice detected') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
    @else
        @php
            $assignedProjects = auth()->user()->projects()->paginate(10);
        @endphp
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="text-center rounded-5 p-2" style="border: 1px solid black; width:45px">
                                <i data-feather="server" style="width: 20px !important"></i>
                            </div>
                            <div class="flex-fill text-end">
                                <p class="h4 mb-0">{{ $assignedProjects->count() }}</p>
                                <p class="mb-0">{{ __('Projects') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h4>{{ __('Involved Project ') . auth()->user()->name }}</h4>
                        </div>
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="3%" >{{ __('No') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Project Timeline') }}</th>
                                    <th width="8%" class="text-center">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($assignedProjects as $index => $project)
                                    <tr>
                                        <td class="align-middle">{{ $assignedProjects->firstItem() + $index }}.</td>
                                        <td class="align-middle">{{ $project->title }}</td>
                                        <td class="align-middle">{{ $project->start_date->format('d/m/Y') }} - {{ $project->end_date->format('d/m/Y') }}</td>
                                        <td class="text-center align-middle">
                                            @if ($project->status == 0)
                                                <span class="badge bg-secondary">{{ __('PENDING') }}</span>
                                            @elseif ($project->status == 1)
                                                <span class="badge bg-warning">{{ __('ONGOING') }}</span>
                                            @else
                                                <span class="badge bg-success">{{ __('COMPLETED') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('No projects available at the moment') }}.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $assignedProjects->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
