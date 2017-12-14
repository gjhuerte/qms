<!doctype html>
<html lang="en">
  <head>
    <title>{{ isset($title) ? $title : config('app.name') }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/pnotify/pnotify.custom.min.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    @yield('after_styles')
  </head>
  <body>
    @yield('content')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>  
    <script src="{{ asset('js/moment.min.js') }}"></script> 

    <script src="{{ asset('vendor/backpack/pnotify/pnotify.custom.min.js') }}"></script>
    <script src="{{ asset('js/initial.min.js') }}"></script>

    {{-- Bootstrap Notifications using Prologue Alerts --}}
    <script type="text/javascript">
      jQuery(document).ready(function($) {

        $('.initial-profile-64').initial({ height: 64, width: 64,   });

        $('.initial-profile-128').initial({ height: 128, width: 128,  }); 

        $('.initial-profile-32').initial({ height: 32, width: 32,   });  

        PNotify.prototype.options.styling = "bootstrap3";
        PNotify.prototype.options.styling = "fontawesome";

        @foreach (Alert::getMessages() as $type => $messages)
            @foreach ($messages as $message)

                $(function(){
                  new PNotify({
                    // title: 'Regular Notice',
                    text: "{{ $message }}",
                    type: "{{ $type }}",
                    icon: false
                  });
                });

            @endforeach
        @endforeach
      });
    </script>

    @yield('after_scripts')
  </body>
</html>