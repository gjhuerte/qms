@extends('layouts.app')

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
<div class="container-fluid" style="padding: 10px;">
  <legend class="text-center"><h1>Counter List</h1></legend>
  <div class="row">
      <div class="col-md-12">
          <table class="table table-hover table-condensed" id="voucherTable" >
            <thead>
              <th>Counter</th>
              <th>Voucher ID</th>
              <th>Started Time</th>
              <th>Status</th>
            </thead>
            <tbody> </tbody>
          </table>
      </div>
  </div>
</div>
@endsection

@section('after_scripts')
 {{-- <script src="https://js.pusher.com/4.1/pusher.min.js"></script> --}}
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
        "dom": "<'row'<'col-sm-3'><'col-sm-6'<'toolbar'>><'col-sm-3'>>" +
                        "<'row'<'col-sm-12'>>" +
                        "<'row'<'col-sm-5'><'col-sm-7'>>",
        "processing": true, 
        ajax: "{{ url('queue/counter') }}",
        columns: [
            { data: "user.name" },
            { data: "id" },
            { data: function(callback){
              return  moment(callback.updated_at).fromNow()
            } },
            { data: "status" },
        ],
    });

    var socket = io('{{ Request::getHttpHost() }}:{{ env('SOCKET_PORT') }}');
    // var socket = io('http://192.168.10.10:3000');
    socket.on("attended-queue:App\\Events\\AttendedQueue", function(message){
        table.ajax.reload()
    });
  })  
</script>
@endsection
