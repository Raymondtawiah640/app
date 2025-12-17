<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class contactController extends Controller
{
    public function submitContactForm(Request $request){
        $incomingFields = $request->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|max:150',
            'message' => 'required|min:10|max:1000'
        ]);

        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['message'] = strip_tags($incomingFields['message']);

        Contact::create($incomingFields);

        // Here you can handle the contact form submission,
        // such as saving to the database or sending an email.

        return redirect('/')->with('success', 'Your message has been sent successfully!');
    }

    public function displayContactMessage() {
        $contacts = Contact::all();
        return view('contact-message', ['contacts' => $contacts]);
    }
}
