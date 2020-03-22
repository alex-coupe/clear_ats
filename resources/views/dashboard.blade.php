@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <script>
                window.reactInit = {
                    user: <?php echo Auth::user(); ?>
                };
            </script>
            
            <div id="app"></div>
            <script src="{{ asset('js/app.js') }}"></script>         
        </div>
    </div>
</div>

@endsection
