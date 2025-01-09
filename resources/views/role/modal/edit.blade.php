<div class="modal fade" id="exampleModal{{ $role->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Role Permission</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                <form id="role-form-{{ $role->id }}">
                    @csrf
                    <input type="hidden" name="role_id" value="{{ $role->id }}">
                    <table class="w-100">
                        @foreach($permissions as $module => $modulePermissions)
                            <tr class="align-top">
                                <td class="pe-3">{{ ucfirst($module) }}</td>
                                <td class="px-3">
                                    @foreach($modulePermissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                                id="permission_{{ $permission->id }}" 
                                                {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                            @if(!$loop->last)
                                <tr><td colspan="2"><hr/></td></tr>
                            @endif
                        @endforeach
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button id="saveButton{{ $role->id }}" type="button" class="btn btn-sm btn-success">{{ __('Update') }}</button>
            </div>
        </div>
    </div>
</div>