@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session()->has('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif
