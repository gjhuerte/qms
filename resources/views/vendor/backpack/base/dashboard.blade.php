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
                <th>ID</th>
                <th>Purpose</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Action</th>
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
              return `<a href="{{ url("queue/attend?id=") }}`+ callback.id + `" class="btn btn-primary btn-sm">Attend to</a>`;
            } },
        ],
    });

    var socket = io('{{ Request::getHttpHost() }}:{{ env('SOCKET_PORT') }}');
    // var socket = io('http://192.168.10.10:3000');
    socket.on("queue-channel:App\\Events\\CreateQueue", function(message){
        table.ajax.reload()
    });
  })  
</script>
@endsection
