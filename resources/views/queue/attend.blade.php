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
    <form method="post" action="{{ url("queue/attend?id=$voucher->id") }}" class="form-horizontal">
        {{ csrf_field() }}
        <div class="panel-body">

            <div class="form-group">
                <label>Name</label>
                
                <textarea class="form-control" name="name" rows="1" placeholder="Full Name" readonly style="background-color:white;">{{ $voucher->customer_name }}</textarea>
            </div>

            <div class="form-group">
                <label>Purpose</label>
                
                <textarea class="form-control" name="purpose" rows="4" placeholder="Purpose" readonly style="background-color:white;">{{ $voucher->purpose }}</textarea>
            </div>

            <div class="form-group{{ $errors->has('purpose') ? ' has-error' : '' }}">
                <label>Remarks</label>

                @if($errors->has('purpose'))
                    <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('purpose') }}</strong>
                    </span>
                @endif
                
                <textarea class="form-control"  value="{{ (old('purpose')) ? old('purpose') : '' }}" name="purpose" rows="4" placeholder="Purpose"></textarea>
            </div>
            <div class="form-group pull-right">
                <button type="submit" class="btn btn-primary">Attended</button>
                <a class="btn btn-default" href="{{ url("queue/cancel?id=$voucher->id") }}">Cancel</a>
            </div>
        </div>
    </form>
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
