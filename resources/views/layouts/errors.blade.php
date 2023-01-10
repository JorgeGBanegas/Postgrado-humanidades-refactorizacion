<div style="display: flex; justify-content: center;">
    <div style="position: absolute;" class="bs-toast toast fade show bg-danger " role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class='bx bx-bell me-2'></i>
            <div class="me-auto fw-semibold">Ah ocurrido un error</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        @foreach($errors->all() as $error)
        <div class="toast-body">
            {{ $error }}
        </div>

        @endforeach
    </div>
</div>