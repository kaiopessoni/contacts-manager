@extends('layouts.app')

@section('content')

  @csrf

  @if (count($contacts) > 0)

    <div class="row mb-5">
      <div class="col-lg-6 offset-lg-3">
        <div class="input-group">
          <input type="text" id="search" class="typeahead form-control" name="search" placeholder="Search a contact" autocomplete="off">
          <div class="input-group-append">
            <button id="goto" class="btn btn-outline-dark" type="button">Go to selected contact</button>
          </div>
        </div>
      </div>
    </div>

    <ul id="contact-list" class="list-group mb-5 shadow-sm">
      @php
        $old_letter = '';
        $show_category = true;
      @endphp

      @foreach ($contacts as $contact)
        @php
          $first_letter = strtoupper($contact->name[0]);
          if ($old_letter != $first_letter) {
            $show_category = true;
            $old_letter = $first_letter;
          }
        @endphp

        @if ($show_category)
          @php $show_category = false; @endphp
          <li class="list-group-item list-group-item-action" aria-disabled="true">
            <div class="avatar" style="grid-area: avatar">{{$first_letter}}</div>
          </li>
        @endif

        <li id="item-{{$contact->id}}" class="list-group-item list-group-item-action" aria-disabled="true">
          <div class="avatar" style="grid-area: avatar">{{$first_letter}}</div>
          <span class="name" style="grid-area: name">
            <a href="/contacts/{{$contact->id}}" title="Click to see the details">{{$contact->name}}</a>
          </span>
          <a href="/contacts/{{$contact->id}}/edit" class="btn btn-outline-dark" title="Edit" style="grid-area: edit">
            <i class="fa fa-pencil"></i>
          </a>
        <button type="button" class="btn btn-outline-danger btn-delete" title="Delete" style="grid-area: delete" data-id="{{$contact->id}}">
            <i class="fa fa-trash"></i>
          </button>
        </li>

      @endforeach
    </ul>

  @else
    <div class="text-center mt-5">
      <h2 class="mb-3">You don't have any contact yet =(</h2>
      <h5>Click <a href="/contacts/create">here</a> to create one!</h5>
    </div>
  @endif

  <script type="application/javascript">
    $(document).ready(() => {
      $('.btn-delete').click(function() {
        deleteContact(this);
      });

      let autocompletePath = '{{route('autocomplete')}}';

      $.get(autocompletePath, (data) => {
        $('#search').typeahead({
          source: data
        });
      });

      $('#search').change(function() {
        var current = $(this).typeahead('getActive');
        $('#goto').data('href', `/contacts/${current.id}`);
      });

      $('#goto').click(function() {
        let href = $(this).data('href');
        if (href) window.location.href = $(this).data('href');
      });

    });

    async function deleteContact(el) {

      const id = $(el).data('id');

      let res = await swConfirm('Are you sure you want to delete this contact?', { dangerMode: true });
      if (res === null) return;

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/contacts/${id}?_method=DELETE`,
        type: 'POST',
        success: (data) => {

          if (data.success === true) {
            swAlert('success', data.message);
            $(`#item-${id}`).fadeToggle().remove();
          } else
            swAlert('error', data.message);

        }
      });

    }
  </script>
@endsection
