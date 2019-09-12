@extends('layouts.app')

@section('content')
  <form id="form-update-contact" >

    @csrf
    @method('PUT')

    <div class="row">

      <div class="col-lg-4 col-md-6 col-sm-12 form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter name" maxlength="40" value="{{$contact->name}}">
      </div>

      <div class="col-lg-3 col-md-6 col-sm-12 form-group">
        <label for="phone">Phone Number</label>
        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" maxlength="15" value="{{$contact->phone}}">
      </div>

      <div class="col-lg-5 col-md-12 col-sm-12 form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{$contact->email}}">
      </div>
    </div>

    <div class="row">

      <div class="col-lg-3 col-md-4 col-sm-12 form-group">
        <label for="cep">Zip Code (CEP)</label>
      <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Enter zip code (only numbers)" aria-describedby="cepHelp" maxlength="8" value="{{$contact->zipcode}}">
        <small id="cepHelp" class="form-text text-muted">The other data will fill in automatically.</small>
      </div>

      <div class="col-lg-2 col-md-2 col-3 form-group">
        <label>State</label>
        <input type="text" class="form-control" id="state" name="state" readonly value="{{$contact->state}}">
      </div>

      <div class="col-lg-3 col-md-6 col-9 form-group">
        <label>City</label>
        <input type="text" class="form-control" id="city" name="city" readonly value="{{$contact->city}}">
      </div>

      <div class="col-lg-4 col-md-5 col-sm-12 form-group">
        <label>Neighbourhood</label>
        <input type="text" class="form-control" id="neighbourhood" name="neighbourhood" readonly value="{{$contact->neighbourhood}}">
      </div>

      <div class="col-lg-5 col-md-5 col-9 form-group">
        <label>Street</label>
        <input type="text" class="form-control" id="street" name="street" readonly value="{{$contact->street}}">
      </div>

      <div class="col-lg-2 col-md-2 col-3 form-group">
        <label>Number</label>
        <input type="text" class="form-control" id="number" name="number" maxlength="4" value="{{$contact->number}}">
      </div>

    </div>

    <div class="row justify-content-center">
      <button id="btn-update" type="submit" class="btn btn-outline-dark mt-3">Update Contact</button>
    </div>

  </form>

  <script type="application/javascript">
    $(document).ready(() => {

      $('#form-update-contact').validate({
        rules: {
          name: {
            required: true,
            maxlength: 40,
          },
          phone: {
            required: true,
            maxlength: 15,
          },
          email: {
            required: true,
            email: true,
            maxlength: 60,
          },
          zipcode: {
            required: true,
            digits: true,
            maxlength: 8,
          },
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
        submitHandler: () => { updateContact(); }
      });

      $('#zipcode').on('change keyup paste', function() {
        if (this.value.length === 8)
          getAddress();
      });

    });

    function updateContact() {

      $.ajaxSetup({
        headers: {
          'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
      });

      $('#btn-update')
        .html('Loading &nbsp;<i class="fa fa-refresh fa-spin"></i>')
        .prop('disabled', true);

      $.ajax({
        url: '/contacts/{{$contact->id}}',
        type: 'POST',
        data: $('#form-update-contact').serialize(),
        success: (data) => {

          $('#btn-update')
            .html('Update Contact')
            .prop('disabled', false);

          if (data.success === true) {
            swAlert('success', data.message);
            $('#form-update-contact .form-control').removeClass('is-valid');
          }

        },
        error: (data) => {
          const errors = data.responseJSON.errors;
          const validator = $('#form-update-contact').validate();
          validator.showErrors(errors);
        }
      });
    }

    function getAddress() {

      const zipcode = $('#zipcode').val();
      $('#zipcode').prop('disabled', true);

      $.ajax({
        url: `/zipcode/${zipcode}`,
        type: 'GET',
        success: (data) => {

          const formId = '#form-update-contact';

          if (data.length === 0) {

            const validator = $(formId).validate();
            validator.showErrors({
              'zipcode': 'The inserted zip code is invalid.'
            });

            $('#state, #city, #neighbourhood, #street').val('').removeClass('is-valid');

          } else {

            $('#state').val(data.uf.trim());
            $('#city').val(data.cidade.trim());
            $('#neighbourhood').val(data.bairro.trim());
            $('#street').val(data.logradouro.trim());

            $(formId).validate().element('#state');
            $(formId).validate().element('#city');
            $(formId).validate().element('#neighbourhood');
            $(formId).validate().element('#street');

          }

          $('#zipcode').prop('disabled', false);

        }
      });
    }
  </script>
@endsection
