@if (Session::has('success'))
        <div class="alert alert-dismissible fade show py-2 border-0 border-start border-4 border-success mb-0">
        <div class="d-flex align-items-center">
            <div class="fs-3 text-success"><ion-icon name="checkmark-circle-sharp"></ion-icon>
            </div>
            <div class="ms-3">
                <div class="text-success">  {{ Session::get('success') }}</div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-dismissible fade show py-2 border-0 border-start border-4 border-danger">
        <div class="d-flex align-items-center">
            <div class="fs-3 text-danger"><ion-icon name="close-circle-sharp"></ion-icon>
            </div>
            <div class="ms-3">
                <div class="text-danger">{{ Session::get('error') }}</div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('warning'))
    <div class="alert alert-dismissible fade show py-2 border-0 border-start border-4 border-warning">
        <div class="d-flex align-items-center">
            <div class="fs-3 text-warning"><ion-icon name="warning-sharp"></ion-icon>
            </div>
            <div class="ms-3">
                <div class="text-warning">{{ Session::get('warning') }}</div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

@endif
