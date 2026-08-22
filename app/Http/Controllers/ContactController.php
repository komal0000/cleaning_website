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
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'service' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
            'consent' => ['accepted'],
            'postcode' => ['nullable', 'string', 'max:12'],
            'location' => ['nullable', 'string', 'max:100'],
            'space_type' => ['nullable', 'string', 'max:50'],
        ]);

        $details = [];

        if (! empty($validated['message'])) {
            $details[] = $validated['message'];
        }

        $context = array_filter([
            filled($validated['postcode'] ?? null) ? 'Postcode: '.$validated['postcode'] : null,
            filled($validated['location'] ?? null) ? 'Region: '.$validated['location'] : null,
            filled($validated['space_type'] ?? null) ? 'Space: '.$validated['space_type'] : null,
        ]);

        if ($context !== []) {
            $details[] = implode(PHP_EOL, $context);
        }

        $ContactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'service' => $validated['service'],
            'message' => $details === [] ? null : implode(PHP_EOL.PHP_EOL, $details),
        ]);

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
