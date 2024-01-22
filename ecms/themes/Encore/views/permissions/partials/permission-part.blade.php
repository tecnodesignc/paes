<div class="row permission mb-3">
    <div class="col-sm-3 text-md-end">
        <label class="fw-bolder control-label">{{ trans($permissionLabel) }}</label>
    </div>
    <div class="col-sm-9">
        <?php if (isset($model)): ?>
            <?php $current = current_permission_value($model, $subPermissionTitle, $permissionAction); ?>
        <?php endif; ?>
        <div class="form-check form-check-inline mx-3">
            <input class="form-check-input jsAllow" type="radio" value="1"
                   id="{{ $subPermissionTitle. '.' . $permissionAction }}_allow"
                   name="permissions[{{ $subPermissionTitle. '.' . $permissionAction }}]"
                {{ isset($current) && $current === 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $subPermissionTitle. '.' . $permissionAction }}_allow">
                {{ trans('user::roles.allow') }}
            </label>
        </div>
        <div class="form-check form-check-inline mx-3">
            <input class="form-check-input jsDeny" type="radio" value="-1"
                   id="{{ $subPermissionTitle. '.' . $permissionAction }}_deny"
                   name="permissions[{{ $subPermissionTitle. '.' . $permissionAction }}]"
                {{ isset($current) && $current === -1 ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $subPermissionTitle. '.' . $permissionAction }}_deny">
                {{ trans('user::roles.deny') }}
            </label>
        </div>
        <div class="form-check form-check-inline mx-3">
            <input class="form-check-input jsInherit" type="radio" value="0"
                   id="{{ $subPermissionTitle. '.' . $permissionAction }}_inherit"
                   name="permissions[{{ $subPermissionTitle. '.' . $permissionAction }}]"
                {{ isset($current) && $current === 0 ? 'checked' : '' }} {{ isset($current) === false ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $subPermissionTitle. '.' . $permissionAction }}_inherit">
                {{ trans('user::roles.inherit') }}
            </label>
        </div>

    </div>
</div>
