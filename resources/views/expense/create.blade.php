<x-app-layout>
    @section('title', __('Create Expense'))

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

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form id="expense-form" enctype="multipart/form-data">
                        @csrf
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="{{ __('Enter project description here') }}"></textarea>                                    
                                    <span class="text-danger d-none error description_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text description_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Date') }}</label>
                                    <input type="date" name="date" class="form-control" value="{{ old('start_date') }}">
                                    <span class="text-danger d-none error date_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text date_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Expense Type') }}</label>
                                    <select name="type" class="form-control select2">
                                        <option selected disabled>{{ __('Select type') }}</option>
                                        <option value="travel">{{ __('Travel') }}</option>
                                        <option value="equipment">{{ __('Equipment') }}</option>
                                        <option value="miscellaneous">{{ __('Miscellaneous') }}</option>
                                    </select>
                                    <span class="text-danger d-none error type_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text type_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Amount') }} <small>(Balance Budget: RM{{ $project->remainingBudget() }})</small></label>
                                    <div class="input-group">
                                        <span class="input-group-text">RM</span>
                                        <input type="number" id="amount" name="amount" class="form-control" placeholder="0.00">
                                    </div>
                                    <small class="text-warning exceed-warning d-none"><i data-feather="alert-triangle" class="mx-2"></i>Amount entered exceeding the budget <br></small>
                                    <span class="text-danger d-none error amount_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text amount_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Attachment') }}</label>
                                    <input type="file" name="attachment" class="form-control">
                                    <span class="text-danger d-none error attachment_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text attachment_error_text"></small>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button id="saveButton" type="button" class="btn btn btn-success">
                                {{ __('Save') }}
                            </button>
                            <a href="{{ route('expense.index', $project->id) }}" class="btn btn btn-outline-secondary">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            $('#saveButton').on('click', function() {
                var data = new FormData($('#expense-form')[0]);

                $.ajax({
                    url: "{{ route('expense.store', $project->id) }}",
                    type: 'POST',
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function() {
                        location.href = '{{ route('expense.index', $project->id) }}';
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status == 422) {
                            $(".error").addClass('d-none');
                            $(".error_text").text('');
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $("." + key + "_error").removeClass('d-none');
                                $("." + key + "_error_text").text(value[0]);
                            });
                        }
                    }
                });
            });

            $('#amount').on('keyup', function() {
                var maxValue = '{{ $project->remainingBudget() }}';
                var currentValue = parseFloat($(this).val());

                if (!isNaN(currentValue) && currentValue > 0) {
                    $('.exceed-warning').toggleClass('d-none', currentValue <= maxValue);
                } else {
                    $('.exceed-warning').addClass('d-none');
                }
            });
        </script>
    @endsection
</x-app-layout>
