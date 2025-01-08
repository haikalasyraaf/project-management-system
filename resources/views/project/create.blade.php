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
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="{{ __('Enter project title here') }}">                                    
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="{{ __('Enter project description here') }}"></textarea>                                    
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Start Date') }}</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('End Date') }}</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Assign User') }}</label>
                                    <select name="assign_user[]" class="w-100 form-control select2" multiple>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Budget') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text">RM</span>
                                        <input type="number" name="budget" class="form-control" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Status') }}</label>
                                    <select name="status" class="form-control">
                                        <option disabled selected>{{ __('Select status') }}</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Ongoing</option>
                                        <option value="2">Completed</option>
                                    </select>
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
                    url: "{{ route('project.store') }}",
                    type: 'POST',
                    data: data,
                    success: function() {
                        location.href = '{{ route('project.index') }}';
                    }
                });
            })
        </script>
    @endsection
</x-app-layout>
