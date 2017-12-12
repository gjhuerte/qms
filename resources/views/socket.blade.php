@extends('layouts.app')
 
@section('content')
 
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2" >
              <div id="messages" ></div>
            </div>
        </div>
    </div>

@endsection

@section('after_scripts')
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
    <script>
        // var socket = io.connect('http://localhost:8890');
        var socket = io();
        socket.on('message', function (data) {
            $( "#messages" ).append( "<p>"+data+"</p>" );
          });
    </script>
@endsection


