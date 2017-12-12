@extends('layouts.app')

@section('after_styles')
<style>
    body{
        /*background-color: #e5e5e5;*/
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row align-self-center" style="margin-top:10px;">
        <div class="offset-sm-3 col-sm-6 border-0" style="background-color:white; padding: 20px;">
            <legend class="text-center" style="margin: 20px 0px;letter-spacing: 1px">
                <h2>Queue Management System</h2>
            </legend>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Generate</li>
              </ol>
            </nav>
            <div class="panel panel-default">
                <form method="post" action="{{ url('queue/generate') }}" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label>Full Name</label>

                            @if($errors->has('name'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                </span>
                            @endif

                            <input type="text"  value="{{ (old('name')) ? old('name') : '' }}" name="name" class="form-control" placeholder="Full Name" />

                        </div>
                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">

                            <label>Category</label>

                            @if($errors->has('category'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('category') }}</strong>
                                </span>
                            @endif
                            
                            <select name="category"  value="{{ (old('category')) ? old('category') : '' }}" class="form-control">
                                <option>Tagging</option>
                            </select>

                        </div>
                        <div class="form-group{{ $errors->has('purpose') ? ' has-error' : '' }}">
                            <label>Purpose</label>

                            @if($errors->has('purpose'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('purpose') }}</strong>
                                </span>
                            @endif
                            
                            <textarea class="form-control"  value="{{ (old('purpose')) ? old('purpose') : '' }}" name="purpose" rows="4" placeholder="Purpose"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Generate</button>
                        </div>
                        <p style="font-size: 12px">By clicking the generate button. You agreed to the terms and conditions of the organization. </p>
                    </div>
                </form>
            </div>

        </div>
	</div>
</div>
@endsection
