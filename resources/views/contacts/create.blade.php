@extends('layouts.app')

@section('content')
  <form id="form-create-contact" >
    @csrf

    <div class="row">

      <div class="col-lg-4 col-md-6 col-sm-12 form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter name">
      </div>

      <div class="col-lg-3 col-md-6 col-sm-12 form-group">
        <label for="phone">Phone Number</label>
        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number">
      </div>

      <div class="col-lg-5 col-md-12 col-sm-12 form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
      </div>
    </div>

    <div class="row">

      <div class="col-lg-3 col-md-4 col-sm-12 form-group">
        <label for="cep">Zip Code (CEP)</label>
        <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Enter zip code" aria-describedby="cepHelp">
        <small id="cepHelp" class="form-text text-muted">The other data will fill in automatically.</small>
      </div>

      <div class="col-lg-1 col-md-2 col-3 form-group">
        <label>State</label>
        <input type="text" class="form-control" id="state" name="state" readonly>
      </div>

      <div class="col-lg-3 col-md-6 col-9 form-group">
        <label>City</label>
        <input type="text" class="form-control" id="city" name="city" readonly>
      </div>

      <div class="col-lg-5 col-md-5 col-sm-12 form-group">
        <label>Neighbourhood</label>
        <input type="text" class="form-control" id="neighbourhood" name="neighbourhood" readonly>
      </div>

      <div class="col-lg-4 col-md-5 col-9 form-group">
        <label>Street</label>
        <input type="text" class="form-control" id="street" name="street" readonly>
      </div>

      <div class="col-lg-1 col-md-2 col-3 form-group">
        <label>Number</label>
        <input type="text" class="form-control" id="number" name="number" readonly>
      </div>

    </div>

    <div class="row justify-content-center">
      <button type="susbmit" class="btn btn-outline-dark mt-3">Create Contact</button>
    </div>

  </form>

  <script type="application/javascript">
    $(document).ready(() => {
      $('#form-create-contact').validate({
        rules: {
          name: 'required',
          phone: 'required',
          email: {
            required: true,
            email: true,
          },
          zipcode: 'required',
          state: {
            required: true,
            minlength: 2,
            maxlength: 2,
          },
          city: 'required',
          neighbourhood: 'required',
          street: 'required',
          number: {
            digits: true
          }
        },
        submitHandler: () => { createContact(); }
      })
    });

    function createContact() {

      return;

      $.ajaxSetup({
        headers: {
          'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
      });

      $.ajax({
        url: '/contacts',
        type: 'POST',
        data: $('#form-create-contact').serialize(),
        success: (data) => {
          console.log(data);
        },
        error: (data) => {
          const errors = data.responseJSON.errors;
          console.log(errors);
        }
      })
    }
  </script>
@endsection
