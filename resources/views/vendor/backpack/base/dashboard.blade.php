@extends('backpack::layout')

@section('after_styles')
<style>
  th, td {
    word-spacing: nowrap;
  }
</style>
@endsection

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="box" style="padding: 10px;">
  <div class="box-default">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover table-condensed" id="voucherTable" >
              <thead>
                <th class="col-sm-1">ID</th>
                <th class="col-sm-1">Purpose</th>
                <th class="col-sm-1">Created At</th>
                <th class="col-sm-1">Status</th>
                <th class="col-sm-1 no-sort">Action</th>
              </thead>
              <tbody> </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
@endsection

@section('after_scripts')
 <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
 {{-- <script src="socket.io/socket.io.js"></script> --}}
 {{-- <script src="js/app.js"></script> --}}
<script src="{{ asset('js/socket.io.js') }}"></script>
<script>
  $(document).ready(function(){
    table = $('#voucherTable').DataTable({
        language: {
                searchPlaceholder: "Search..."
        },
        columnDefs:[
            { targets: 'no-sort', orderable: false },
        ],
        "dom": "<'row'<'col-sm-3'l><'col-sm-6'<'toolbar'>><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        ajax: "{{ url('admin/dashboard') }}",
        columns: [
            { data: "id" },
            { data: "purpose" },
            { data: function(callback){
              return  moment(callback.created_at).fromNow()
            } },
            { data: "status" },
            { data: function(callback){

              call = `<button data-id="`+callback.id+`" class="call btn btn-warning btn-sm"><i class="fa fa-phone" aria-hidden="true"></i> Call</button>`
              attend = ` <a href="{{ url("queue/attend?id=") }}`+ callback.id + `" class="btn btn-primary btn-sm"> <i class="fa fa-rss" aria-hidden="true"></i> Attend to</a>`
              return call + attend;
            } },
        ],
    });

    var socket = io('{{ Request::getHttpHost() }}:{{ env('SOCKET_PORT') }}');
    // var socket = io('http://192.168.10.10:3000');
    socket.on("queue-channel:App\\Events\\CreateQueue", function(message){
        table.ajax.reload()
    });

    $('#voucherTable').on('click','.call',function(){
      id = $(this).data('id')
      $.ajax({
        type: "POST",
        url: '{{ url('queue/call') }}',
        dataType: 'json',
        data: {
          'id' : id
        },
        success: function(){
          new PNotify({
            title: "Operation successful",
            text: "Information Posted.",
            type: "success"
          });
        },
        error: function(){
          new PNotify({
            title: "Operation Encountered a problem",
            text: "The process run into an error",
            type: "error"
          });
        }
      })
    })
  })  
</script>
@endsection
