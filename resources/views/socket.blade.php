@extends('layouts.app')
 
@section('content')
 
    <div class="container">
        <div class="row">
            <div id="connection"></div>
            <div class="col-lg-8 col-lg-offset-2" >
              <div id="messages-info" ></div>
            </div>
        </div>
    </div>

@endsection

@section('after_scripts')
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
    <script>
        var socket = io.connect('http://localhost:8890');

        console.log('started connection...')
        console.log(socket)
        socket.on('message_received', function (data) {
            console.log('triqqered');
            console.log(data);
            $( "#messages-info" ).append( "<p>"+data+"</p>" );
        });
    </script>
@endsection


