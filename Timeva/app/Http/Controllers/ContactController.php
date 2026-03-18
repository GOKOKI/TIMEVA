<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'prenom'  => 'required|string|max:100',
            'nom'     => 'required|string|max:100',
            'email'   => 'required|email|max:255',
            'sujet'   => 'required|string|max:100',
            'message' => 'required|string|min:10|max:2000',
        ]);

        // Envoi de l'email à l'adresse de contact TIMEVA
        Mail::raw(
            "Nouveau message de contact TIMEVA\n\n" .
            "De : {$validated['prenom']} {$validated['nom']} <{$validated['email']}>\n" .
            "Sujet : {$validated['sujet']}\n\n" .
            "Message :\n{$validated['message']}",
            function ($mail) use ($validated) {
                $mail->to('contact@timeva.com')
                     ->replyTo($validated['email'], $validated['prenom'] . ' ' . $validated['nom'])
                     ->subject('[TIMEVA Contact] ' . ucfirst($validated['sujet']));
            }
        );

        return redirect()->route('contact')->with('success', true);
    }
}
