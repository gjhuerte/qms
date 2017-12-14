@extends('layouts.report')
@section('title',"Voucher")
@section('content')
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

  <ul class="list-group">
    <li class="list-group-item d-flex justify-content-between align-items-center">
      Queue No:
      <span class="badge badge-primary badge-pill">{{ $voucher->id }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      Name: {{ $voucher->customer_name }}
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      Category: {{ $voucher->category }}
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">     
      <div class="card card-inverse card-outline-primary card-danger">
        <div class="card-header">
          Purpose
        </div>
        <div class="card-block text-center" style="margin: 10px 0px; ">
          <blockquote class="card-blockquote">
            <p>{{ $voucher->purpose }}</p>
          </blockquote>
        </div>
      </div>
    </li>
    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Attended By</h5>
      </div>
      <p class="mb-6 text-muted text-center">Signature</p>
      <hr style="margin: 0; padding: 0;" />
      <p class="text-center text-muted">Name (Capitalized)</p>
    </a>
  </ul>

  <div class="col-sm-12 text-center note-sm">
    This is a property of Polytechnic University of the Philippines. <br />This form will only be valid until <strong> {{ Carbon\Carbon::parse($voucher->validity)->toFormattedDateString() }} </strong>. <br />Absence during call time will nullified the queue.
  </div>

  <hr style="border-top: 2px dotted;" />
@endsection
