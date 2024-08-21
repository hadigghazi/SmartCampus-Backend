<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::get();
        return response()->json($contacts);
    }

    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create($request->validated());
        return response()->json($contact, 201);
    }

    public function show(Contact $contact)
    {
        return response()->json($contact);
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact->update($request->validated());
        return response()->json($contact);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $contact = Contact::withTrashed()->findOrFail($id);
        $contact->restore();
        return response()->json($contact);
    }

    public function forceDelete($id)
    {
        $contact = Contact::withTrashed()->findOrFail($id);
        $contact->forceDelete();
        return response()->json(null, 204);
    }
}
