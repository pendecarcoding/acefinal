<?php

namespace App\Http\Controllers\ace;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

    class ContactController extends Controller
    {
        public function index()
        {
            $contacts = Contact::all();
            return view('backend.contact.index', compact('contacts'));
        }
        public function create()
        {
            return view('backend.contact.create');
        }

        public function store(Request $request)
        {
            $contact = new Contact();
            $contact->fill($request->all());
            $contact->save();

            return redirect()->route('contact.index')->with('success', 'Contact created successfully.');
        }

        public function destroy($id)
        {
            $contact = Contact::findOrFail($id);
            $contact->delete();

            return redirect()->route('contact.index')->with('success', 'Contact deleted successfully.');
        }

        public function edit($id)
        {
            $contact = Contact::findOrFail($id);
            return view('backend.contact.edit', compact('contact'));
        }

        public function update(Request $request, $id)
        {
            $contact = Contact::findOrFail($id);
            $contact->fill($request->all());
            $contact->save();

            return redirect()->route('contact.index')->with('success', 'Contact updated successfully.');
        }
    }
