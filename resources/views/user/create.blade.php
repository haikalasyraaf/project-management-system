<x-app-layout>
    @section('title', __('Create User'))

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
                                <input type="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="{{ __('Enter name here') }}">
                                <span class="text-danger d-none error name_error">
                                    <i data-feather='alert-circle' class="mx-2"></i><small class="error_text name_error_text"></small>
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label-sm">{{ __('Email Address') }}</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="{{ __('Enter email address here') }}">
                                <span class="text-danger d-none error email_error">
                                    <i data-feather='alert-circle' class="mx-2"></i><small class="error_text email_error_text"></small>
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label-sm">{{ __('Role') }}</label>
                                <select name="role_id" class="form-control">
                                    <option selected disabled>Select role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>                                        
                                    @endforeach
                                </select>
                                <span class="text-danger d-none error role_id_error">
                                    <i data-feather='alert-circle' class="mx-2"></i><small class="error_text role_id_error_text"></small>
                                </span>
                            </div>
                        </div>

                        <div class="text-end">
                            <button id="saveButton" type="button" class="btn btn btn-success">
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
                    url: "{{ route('user.store') }}",
                    type: 'POST',
                    data: data,
                    success: function() {
                        location.href = '{{ route('user.index') }}';
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
        </script>
    @endsection
</x-app-layout>
