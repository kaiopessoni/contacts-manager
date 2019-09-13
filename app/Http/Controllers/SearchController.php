<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SearchController extends Controller
{
  /**
   * Fetch all contacts of the authenticated user
   *
   * @return array
   */
  public function autocomplete() {

    $user_id = auth()->user()->id;
    $user = User::find($user_id);

    $users = $user->contacts()
                  ->select('id', 'name')
                  ->orderBy('name', 'asc')
                  ->get();

    return Response()->json($users);

  }
}
