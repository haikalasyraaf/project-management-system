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
    <div class="row">
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="text-center py-3" style="border-top: 1px dashed black; border-bottom: 1px dashed black">
                        <h3 class="mb-0">INVOICE</h3>
                    </div>
                    <div class="my-3">
                        <p class="mb-0">Invoice Number: {{ $invoice->number }}</p>
                        <p class="mb-0">Invoice Date: {{ $invoice->date->format('Y-m-d') }}</p>
                        <p class="mb-0">Due Date: {{ $invoice->due_date->format('Y-m-d') }}</p>
                        <p class="mb-0">Status: {{ $invoice->status == 0 ? 'Unpaid' : 'Paid' }}</p>
                        <br>
                        <p class="mb-0">
                            Description: <br>
                            {!! $invoice->description ?? '-' !!}
                        </p>
                        <br>
                        <p class="mb-0">Invoice Amount: RM{{ $invoice->amount }}</p>
                    </div>

                    <div class="py-3" style="border-top: 1px dashed black; border-bottom: 1px dashed black">
                        <p class="mb-0">Term & Conditions:</p>
                        <p class="mb-0">
                            - Please make payment within due date <br>
                            - Payments are to be made in RM currency
                        </p>
                    </div>

                    <div class="text-center pt-3">
                        <small class="text-muted fst-italic">*** This is computer generated copy. No signature is required ***</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div>
                        @if ($invoice->status == 0)
                            <a href="{{ route('invoice.mark-as-paid', $invoice->id) }}" class="w-100 mb-2 btn btn-success">{{ __('Mark As Paid') }}</a>
                        @endif
                        <a href="{{ route('invoice.index') }}" class="w-100 mb-2 btn btn-secondary">{{ __('Back') }}</a>
                    </div>

                </div>
            </div>
        </div>
    </div>


    @section('script')

    @endsection
</x-app-layout>