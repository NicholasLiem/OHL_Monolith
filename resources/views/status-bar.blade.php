<!-- Status Bar -->
<div class="status-bar fixed-top d-flex mx-4">
    @if(session('success'))
        <div class="alert alert-success px-4 my-2 w-auto">
            <strong>[Success] </strong>&nbsp;{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger px-4 my-2 w-auto">
             <strong>[Error] </strong>&nbsp;{{ session('error') }}
        </div>
    @endif
</div>

<style>
    .status-bar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
    }

    .alert {
        display: flex;
        padding: 3px;
        font-size: 12px;
    }

    .alert strong {
        font-weight: bold;
        margin-left: 3px;
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
