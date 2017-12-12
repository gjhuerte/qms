@extends('backpack::layout')

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
              <tbody>
              @if(count($vouchers) > 0)
                @foreach($vouchers as $voucher)

                  <tr>
                    <td>{{ $voucher->id }}</td>
                    <td>{{ $voucher->purpose }}</td>
                    <td>{{ Carbon\Carbon::parse($voucher->created_at)->diffForHumans() }}</td>
                    <td>{{ $voucher->status }}</td>
                    <td>
                      <a href="{{ url("queue/attend?id=$voucher->id") }}" class="btn btn-primary btn-sm">Attend to</a>
                    </td>
                  </tr>

                @endforeach
              @endif
              </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
@endsection

@section('after_scripts')
<script>
  $(document).ready(function(){
    $('#voucherTable').DataTable();
  })  
</script>
@endsection
