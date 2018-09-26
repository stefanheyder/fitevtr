<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bergfest Games - @yield('title')</title>
        <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="app" class="container-fluid" background-color="white">
            @yield('content')
        </div>
        <footer>
        @auth
            <div class="btn-group col">
                <div class="btn-group">
                    <button 
                     data-toggle="collapse" 
                     data-target="#demo"
                     class="btn"
                     >
                     <i class="fa fa-cog"></i>
                    </button>
                </div>
                <div class="btn-group collapse" id="demo">
                    {{ 
                        Form::open([
                            'url' => route('logout'),
                            'method' => 'POST',
                        ]) 
                    }}
                    {{ Form::submit('Logout', ['class' => 'btn btn-warning']) }}
                    {{ Form::close() }}
                    <a href="{{route('competitor.create')}}" class="btn btn-success">
                        <i class="fa fa-user-plus"></i>
                    </a>
                </div>
            </div>
        @endauth
        </footer>
        <script>
            var timestamp = "{{ Illuminate\Support\Carbon::now() }}";
        </script>
        <script src="{{mix('js/app.js')}}"></script>
        @yield('extraJS')
        
    </body>
</html>
