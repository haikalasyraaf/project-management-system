<x-app-layout>
    @section('title', __('Edit Expense'))

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
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="{{ __('Enter project description here') }}">{{ old('description', $expense->description) }}</textarea>                                    
                                </div>
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Date') }}</label>
                                    <input type="date" name="date" class="form-control" value="{{ old('date', $expense->date->format('Y-m-d')) }}">
                                </div>
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Expense Type') }}</label>
                                    <select name="type" class="form-control select2">
                                        <option selected disabled>{{ __('Select type') }}</option>
                                        <option value="travel" {{ old('type', $expense->type) == 'travel' ? 'selected' : '' }}>{{ __('Travel') }}</option>
                                        <option value="equipment" {{ old('type', $expense->type) == 'equipment' ? 'selected' : '' }}>{{ __('Equipment') }}</option>
                                        <option value="miscellaneous" {{ old('type', $expense->type) == 'miscellaneous' ? 'selected' : '' }}>{{ __('Miscellaneous') }}</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Amount') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text">RM</span>
                                        <input type="number" name="amount" class="form-control" placeholder="0.00" value="{{ old('amount', $expense->amount) }}">
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label form-label-sm mb-0">{{ __('Attachment') }}</label>
                                    <input type="file" name="attachment" class="form-control">
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
                var data = $('#project-form').serialize();

                $.ajax({
                    url: "{{ route('expense.update', [$project->id, $expense->id]) }}",
                    type: 'POST',
                    data: data,
                    success: function() {
                        location.href = '{{ route('expense.index', $project->id) }}';
                    }
                });
            })
        </script>
    @endsection
</x-app-layout>
