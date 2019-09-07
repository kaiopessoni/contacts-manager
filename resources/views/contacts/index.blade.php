@extends('layouts.app')

@section('content')

  @if (count($contacts) > 0)

    <ul id="contact-list" class="list-group">
      @php
        $old_letter = '';
        $show_category = true;
      @endphp

      @foreach ($contacts as $contact)
        @php
          $first_letter = strtoupper($contact->nome[0]);
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

        <li class="list-group-item list-group-item-action" aria-disabled="true">
          <div class="avatar" style="grid-area: avatar">{{$first_letter}}</div>
          <span class="name" style="grid-area: name">
            <a href="/contacts/{{$contact->id}}">{{$contact->nome}}</a>
          </span>
          <button type="button" class="btn btn-outline-dark" title="Edit" style="grid-area: edit">
            <i class="fa fa-pencil"></i>
          </button>
          <button type="button" class="btn btn-outline-danger" title="Delete" style="grid-area: delete">
            <i class="fa fa-trash"></i>
          </button>
        </li>

      @endforeach
    </ul>

  @else
    <p>Não há nenhum contato cadastrado!</p>
  @endif
@endsection
