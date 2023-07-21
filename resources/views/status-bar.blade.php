<!-- Status Bar -->
<div class="status-bar fixed-bottom d-flex justify-content-center">
    @if(session('success'))
        <div class="alert alert-success text-center my-2 w-50">
            <strong>[Success] </strong>&nbsp;{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center my-2 w-50">
             <strong>[Error] </strong>&nbsp;{{ session('error') }}
        </div>
    @endif
</div>

<style>
    .status-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
    }

    .alert {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .alert strong {
        font-weight: bold;
        margin-left: 5px;
    }

    .icon {
        font-size: 24px;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>
