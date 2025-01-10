<x-app-layout>
    @section('title', __('Create Project'))

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
                    <form id="project-form">
                        @csrf
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Title') }}</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title', $project->title) }}" placeholder="{{ __('Enter project title here') }}">                                    
                                    <span class="text-danger d-none error title_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text title_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="{{ __('Enter project description here') }}">{{ old('description', $project->description) }}</textarea>                                    
                                    <span class="text-danger d-none error description_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text description_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Start Date') }}</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}">
                                    <span class="text-danger d-none error start_date_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text start_date_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('End Date') }}</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date', $project->end_date->format('Y-m-d')) }}">
                                    <span class="text-danger d-none error end_date_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text end_date_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Assign User') }}</label>
                                    <select name="assign_user[]" class="w-100 form-control select2" multiple>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ in_array($user->id, $project->users()->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger d-none error assign_user_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text assign_user_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Budget') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">RM</span>
                                        <input type="number" name="budget" class="form-control" step="0.01" value="{{ old('budget', $project->budget) }}" placeholder="0.00">
                                    </div>
                                    <span class="text-danger d-none error budget_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text budget_error_text"></small>
                                    </span>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Status') }}</label>
                                    <select name="status" class="form-control">
                                        <option disabled selected>{{ __('Select status') }}</option>
                                        <option value="0" {{ old('status', $project->status) == 0 ? 'selected' : '' }}>Pending</option>
                                        <option value="1" {{ old('status', $project->status) == 1 ? 'selected' : '' }}>Ongoing</option>
                                        <option value="2" {{ old('status', $project->status) == 2 ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    <span class="text-danger d-none error status_error">
                                        <i data-feather='alert-circle' class="mx-2"></i><small class="error_text status_error_text"></small>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button id="saveButton" type="button" class="btn btn btn-success">
                                {{ __('Save') }}
                            </button>
                            <a href="{{ route('project.index') }}" class="btn btn btn-outline-secondary">
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
                var data = $('#project-form').serialize();

                $.ajax({
                    url: "{{ route('project.update', $project->id) }}",
                    type: 'POST',
                    data: data,
                    success: function() {
                        location.href = '{{ route('project.index') }}';
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
            })

            $(document).ready(function () {
                inputStartEndDate();
            });

            function inputStartEndDate() {
                // Update the min value of end_date based on the selected start_date
                $("#start_date").on("change", function () {
                    var startDate = $(this).val();
                    $("#end_date").attr("min", startDate);
                });

                // Update the max value of start_date based on the selected end_date
                $("#end_date").on("change", function () {
                    var endDate = $(this).val();
                    $("#start_date").attr("max", endDate);
                });
            }
        </script>
    @endsection
</x-app-layout>
