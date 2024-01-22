@foreach ($permissions as $name => $value)
    <div class="row">
        <div class="col-md-12 ">
            <h5>{{ ucfirst($name) }}</h5>
        </div>
    </div>
    @foreach ($value as $subPermissionTitle => $permissionActions)
        <div class="permissionGroup">
            <div class="row my-3">
                <div class="col-md-6">
                    <h6 class="float-start">{{ ucfirst($subPermissionTitle) }}</h6>
                    <div class="float-end fw-bolder">
                        <a href="" class="jsSelectAllAllow">{{ trans('user::roles.allow all')}}</a> |
                        <a href="" class="jsSelectAllDeny">{{ trans('user::roles.deny all')}}</a> |
                        <a href="" class="jsSelectAllInherit">{{ trans('user::roles.inherit all')}}</a>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($permissionActions as $permissionAction => $permissionLabel)
                    <div class="col-md-12">
                        @include('permissions.partials.permission-part')
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endforeach

@include('permissions.partials.permissions-script')
