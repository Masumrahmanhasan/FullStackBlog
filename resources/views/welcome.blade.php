<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Full stack blog</title>

        <link rel="stylesheet" href="{{ asset('css/all.css') }}">
         
        <script>
           
            (function () {
                window.Laravel = {
                    csrfToken: '{{ csrf_token() }}'
                };
            })();
          
        </script>
      
    </head>
    <body>
         <div id="app">
             @if(Auth::check())
                <mainapp :user="{{Auth::user()}}"></mainapp>
            @else
                <mainapp :user="false"></mainapp>
            @endif
         </div>
    </body>
    <script src="{{ asset('js/app.js') }}"></script>

</html>