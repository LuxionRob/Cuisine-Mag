<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\ContactRequest;
use App\Models\Contact;
use App\Models\Location;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
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
    public function store(ContactRequest $request)
    {
        $validated = $request->validated();
        $coordinates = new Point(explode(',', $validated['location'])[1], explode(',', $validated['location'])[0]);
        $location = Location::create(['detail' => $validated['address'], 'coordinates' => $coordinates]);
        $contact = ['name' => $validated['name'], 'phone_number' => $validated['phone_number'], 'location_id' => $location->id, 'user_id' => Auth::id()];
        $contact = Contact::create($contact);
        $contact->save();

        return redirect(route('users.show', Auth::user()))->with('success', trans('contact.store.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return view('contacts.show')->with('contact', $contact);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit')->with('contact', $contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $validated = $request->validated();

        $contact->fill(array_merge($contact->getAttributes(), $validated));
        $contact->save();

        return redirect()->back()->with('success', trans('contact.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect(route('users.show', Auth::id()))->with('success', trans('contact.destroy.success'));
    }
}
