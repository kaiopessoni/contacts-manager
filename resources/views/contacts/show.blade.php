@extends('layouts.app')

@section('content')

  <div id="contact-info" class="card shadow">
    <div class="card-header"><h3 class="mb-0 text-center">{{$contact->name}}</h3></div>
    <div class="card-body p-5">

      <div class="row align-items-center mb-4">
        <div class="col-lg-2 col-5">
          <i class="fa fa-phone"></i> <span class="attribute">Phone:</span>
        </div>
        <div class="col-lg-4 col-7 info-value text-muted">{{$contact->phone}}</div>

        <div class="col-lg-2 col-5">
          <i class="fa fa-envelope-o"></i> <span class="attribute">Email:</span>
        </div>
        <div class="col-lg-4 col-7 info-value text-muted">{{$contact->email}}</div>
      </div>

      <div class="row align-items-center mb-4">
        <div class="col-lg-2 col-5">
          <i class="fa fa-file-text-o"></i> <span class="attribute">Zip Code:</span>
        </div>
        <div class="col-lg-4 col-7 info-value text-muted">{{$contact->zipcode}}</div>

        <div class="col-lg-2 col-5">
          <i class="fa fa-globe"></i> <span class="attribute">State:</span>
        </div>
        <div class="col-lg-4 col-7 info-value text-muted">{{$contact->state}}</div>
      </div>

      <div class="row align-items-center mb-4">
        <div class="col-lg-2 col-5">
          <i class="fa fa-map-o"></i> <span class="attribute">City:</span>
        </div>
        <div class="col-lg-4 col-7 info-value text-muted">{{$contact->city}}</div>

        <div class="col-lg-2 col-5">
          <i class="fa fa-building-o"></i> <span class="attribute">Neighbourhood:</span>
        </div>
        <div class="col-lg-4 col-7 info-value text-muted">{{$contact->neighbourhood}}</div>
      </div>

      <div class="row align-items-center mb-4">
        <div class="col-lg-2 col-5">
          <i class="fa fa-flag-o"></i> <span class="attribute">Street:</span>
        </div>
        <div class="col-lg-4 col-7 info-value text-muted">{{$contact->street}}</div>

        <div class="col-lg-2 col-5">
          <i class="fa fa-home"></i> <span class="attribute">Number:</span>
        </div>
        <div class="col-lg-4 col-7 info-value text-muted">{{$contact->number}}</div>
      </div>

    </div>
  </div>

@endsection
