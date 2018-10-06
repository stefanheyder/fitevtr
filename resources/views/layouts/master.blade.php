<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Thüringer Liften gegen Krebs</title>
        <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="app" class="container-fluid" background-color="white">
            @yield('content')
        </div>
        <script>
            var timestamp = "{{ Illuminate\Support\Carbon::now() }}";
        </script>
        <script src="{{mix('js/app.js')}}"></script>
        @yield('extraJS')
        
    </body>
</html>
