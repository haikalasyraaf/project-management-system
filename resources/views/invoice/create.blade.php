<x-app-layout>
    @section('title', __('Generate Invoice'))

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
                    <form id="invoice-form">
                        @csrf
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Project') }}</label>
                                    <select name="project_id" id="project_id" class="form-control select2">
                                        <option selected disabled>{{ __('Select project') }}</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}" data-budget={{ $project->projectCost() - $project->paidCost() }}>{{ $project->title }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger d-none error project_id_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text project_id_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="{{ __('Enter project description here') }}"></textarea>                                    
                                    <span class="text-danger d-none error description_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text description_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Invoice Date') }}</label>
                                    <input type="date" id="date" name="date" class="form-control" value="{{ old('date') }}">
                                    <span class="text-danger d-none error date_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text date_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Due Date') }}</label>
                                    <input type="date" id="due_date" name="due_date" class="form-control" value="{{ old('date') }}">
                                    <span class="text-danger d-none error due_date_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text due_date_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Amount') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text">RM</span>
                                        <input type="number" id="amount" name="amount" class="form-control" placeholder="0.00">
                                    </div>
                                    <span class="text-danger d-none error amount_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text amount_error_text"></small>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button id="saveButton" type="button" class="btn btn btn-success">
                                {{ __('Save') }}
                            </button>
                            <a href="{{ route('invoice.index') }}" class="btn btn btn-outline-secondary">
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
                var data = $('#invoice-form').serialize();

                $.ajax({
                    url: "{{ route('invoice.store') }}",
                    type: 'POST',
                    data: data,
                    success: function() {
                        location.href = '{{ route('invoice.index') }}';
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

            // Update the min value of end_date based on the selected start_date
            $("#date").on("change", function () {
                var startDate = $(this).val();
                $("#due_date").attr("min", startDate);
            });

            // Update the max value of start_date based on the selected end_date
            $("#due_date").on("change", function () {
                var endDate = $(this).val();
                $("#date").attr("max", endDate);
            });

            $('#amount').on('keyup', function() {
                var selectedProjectId = $('#project_id').val();

                if (!selectedProjectId) {
                    return; // If no project is selected, do nothing
                }

                var selectedOption = $('#project_id option:selected');
                var projectCost = parseFloat(selectedOption.data('budget'));
                var currentValue = parseFloat($(this).val());

                if (!isNaN(currentValue)) {
                    if (currentValue > projectCost) {
                        $(this).val(projectCost);
                    }
                }
            });
        </script>
    @endsection
</x-app-layout>
