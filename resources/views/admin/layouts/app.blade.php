
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
    <script src="{{asset('js/jquery-3.5.1.min.js')}}"> </script>
    <script src="{{asset('js/app.js')}}"> </script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <meta name="csrf-token" content="{{ csrf-token() }}"> --}}
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/all.css')}}">
   
    <style>
        html, body {
                background-color: #fff;
                color: #222;
               
                height: 100vh;
                margin: 0;
            }

           
         

            

    </style>
    
        <title>BinAbba Logistics</title>
       
    </head>
    <body>
    @include('inc.navbar')
    <div class="container" id="app" style="min-height:85%">
        @include('inc.messages')
        @yield('content')
        
    </div>
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Bin-Abba</small>

         
          <i class="fa fa-fw fa-facebook "></i>
          <i class="fa fa-fw fa-twitter "></i>
        <i class="fa fa-facebook fa-2x m-2 bg-light  text-center social-item"></i>
      
        </div>
      </div>
    </footer>

     
      
    </body>
</html>
