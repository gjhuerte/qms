@extends('layouts.app')
 
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Send message</div>
                    <form action="{{ url('sendmessage') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="text" id="message" class="form-control" name="message" >
                        <input type="submit" id="submit" class="btn btn-sm btn-primary" value="send">
                    </form>
                    <div id="messages" ></div>
                </div>
            </div>
        </div>
    </div>
 
@endsection

@section('after_scripts')
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
    <script>
        var socket = io();

        $('#submit').on('click',function(){
            console.log("data submitted:" + $("#message").val())
            socket.emit('chat.message',$('#message').val())
        })

        socket.on('sample',function(data){
            console.log("whit:" + data)
        })

        socket.on('message', function (data) {
            console.log('received')
            console.log("data:" + data)
            $( "#messages" ).append( "<p>"+data+"</p>" );
        });
    </script>
@endsection