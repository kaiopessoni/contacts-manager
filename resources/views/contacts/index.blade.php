@extends('layouts.app')

@section('content')

  @csrf

  @if (count($contacts) > 0)

    <ul id="contact-list" class="list-group">
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
    <p>Não há nenhum contato cadastrado!</p>
  @endif

  <script type="application/javascript">
    $(document).ready(() => {
      $('.btn-delete').click(function() {
        deleteContact(this);
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
        data: '_mssethod=DELETE',
        success: (data) => {

          if (data.success === true) {
            swAlert('success', data.message);
            $(`#item-${id}`).fadeToggle().remove();
          }

        },
        error: (data) => {
          swAlert('error', data.message);
        }
      });

    }
  </script>
@endsection
