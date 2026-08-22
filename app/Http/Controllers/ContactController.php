<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        $setting = Setting::first();
        $services = Service::orderBy('position')->orderBy('title')->get();

        return view('front.pages.contact', compact('setting', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'postcode' => ['required', 'string', 'max:12'],
            'location' => ['nullable', 'in:Auckland,Hamilton,Palmerston North,Christchurch'],
            'space_type' => ['required', 'in:home,business,stay,other'],
            'service' => ['required', 'string', 'max:255'],
            'frequency' => ['nullable', 'string', 'max:100'],
            'preferred_timing' => ['required', 'string', 'max:100'],
            'urgency' => ['nullable', 'in:flexible,soon,urgent'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'consent' => ['accepted'],
        ]);

        $details = [
            'Postcode: '.$validated['postcode'],
            'Region: '.($validated['location'] ?? 'Not specified'),
            'Space: '.ucfirst($validated['space_type']),
            'Frequency: '.($validated['frequency'] ?? 'Not specified'),
            'Preferred timing: '.$validated['preferred_timing'],
            'Urgency: '.ucfirst($validated['urgency'] ?? 'Flexible'),
        ];

        if (! empty($validated['notes'])) {
            $details[] = 'Notes: '.$validated['notes'];
        }

        $ContactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'service' => $validated['service'],
            'message' => implode(PHP_EOL, $details),
        ]);

        // forward email to admin
        $forwardTo = config('mail.forward_to', null);
        if ($forwardTo) {
            try {
                Mail::send('emails.contact-form', ['contact' => $ContactMessage], function ($message) use ($ContactMessage, $forwardTo) {
                    $message->to($forwardTo);
                    $subject = 'New Contact Form Submission - '.$ContactMessage->service;
                    if (config('app.env') === 'local') {
                        $subject .= ' [TEST]';
                    }
                    $message->subject($subject);
                });
            } catch (\Throwable $th) {
                Log::error('Error sending contact form email: '.$th->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
