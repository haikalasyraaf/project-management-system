<x-app-layout>
    @section('title', __('Edit User'))

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
                    <form id="user-form">
                        @csrf
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="mb-3">
                                <label for="" class="form-label-sm">{{ __('Name') }}</label>
                                <input type="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" placeholder="{{ __('Enter name here') }}">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label-sm">{{ __('Email Address') }}</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" placeholder="{{ __('Enter email address here') }}">
                            </div>
                        </div>

                        <div class="text-end">
                            <button id="saveButton" type="button" class="btn btn-success">
                                <i data-feather="save" class="me-2"></i>
                                {{ __('Save') }}
                            </button>
                            <a href="{{ route('user.index') }}" class="btn btn btn-outline-secondary">
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
                var data = $('#user-form').serialize();

                $.ajax({
                    url: "{{ route('user.update', $user->id) }}",
                    type: 'POST',
                    data: data,
                    success: function() {
                        location.href = '{{ route('user.index') }}';
                    }
                });
            })
        </script>
    @endsection
</x-app-layout>
