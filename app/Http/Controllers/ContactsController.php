<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\User;

class ContactsController extends Controller
{

    /**
     *  Allow only authenticated users
     *
     *  @return void
     */
    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user_id = auth()->user()->id;
      $user = User::find($user_id);

      return view('contacts.index')->with('contacts', $user->contacts()->orderBy('name', 'asc')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'zipcode' => 'required',
        'state' => 'required',
        'city' => 'required',
        'neighbourhood' => 'required',
        'street' => 'required',
      ]);

      $contact = new Contact;
      $contact->name            = $request->input('name');
      $contact->phone           = $request->input('phone');
      $contact->email           = $request->input('email');
      $contact->zipcode         = $request->input('zipcode');
      $contact->state           = $request->input('state');
      $contact->city            = $request->input('city');
      $contact->neighbourhood   = $request->input('neighbourhood');
      $contact->street          = $request->input('street');
      $contact->number          = $request->input('number') ?? 0;
      $contact->user_id         = auth()->user()->id;

      $contact->save();

      $response = [
        "success" => true,
        "message" => "Contact created successfully."
      ];

      return Response()->json($response);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $contact = Contact::find($id);

      if (auth()->user()->id !== $contact->user_id)
        return redirect('/');

      return view('contacts.show')->with('contact', $contact);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $contact = Contact::find($id);

      if (auth()->user()->id !== $contact->user_id)
        return redirect('/');

      return view('contacts.edit')->with('contact', $contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      $this->validate($request, [
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'zipcode' => 'required',
        'state' => 'required',
        'city' => 'required',
        'neighbourhood' => 'required',
        'street' => 'required',
      ]);

      $contact = Contact::find($id);

      if (auth()->user()->id !== $contact->user_id)
        return Response()->json(['success' => false, 'message' => 'Access denied!']);

      $contact->name            = $request->input('name');
      $contact->phone           = $request->input('phone');
      $contact->email           = $request->input('email');
      $contact->zipcode         = $request->input('zipcode');
      $contact->state           = $request->input('state');
      $contact->city            = $request->input('city');
      $contact->neighbourhood   = $request->input('neighbourhood');
      $contact->street          = $request->input('street');
      $contact->number          = $request->input('number') ?? 0;

      $contact->save();

      $response = [
        "success" => true,
        "message" => "Contact updated successfully."
      ];

      return Response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $contact = Contact::find($id);

      if (auth()->user()->id !== $contact->user_id)
        return Response()->json(['success' => false, 'message' => 'Access denied!']);

      $contact->delete();

      $response = [
        "success" => true,
        "message" => "Contact deleted successfully."
      ];

      return Response()->json($response);
    }
}
