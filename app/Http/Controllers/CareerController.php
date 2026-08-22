<?php

namespace App\Http\Controllers;

use App\Models\CareerApply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CareerController extends Controller
{
    public function apply(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'position' => ['required', 'string', 'max:255'],
            'experience' => ['nullable', 'string', 'max:50'],
            'availability' => ['nullable', 'string', 'max:50'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'cover_letter' => ['nullable', 'string', 'max:3000'],
        ]);

        $careerApply = new CareerApply;
        $careerApply->first_name = $validated['first_name'];
        $careerApply->last_name = $validated['last_name'];
        $careerApply->email = $validated['email'];
        $careerApply->phone = $validated['phone'];
        $careerApply->position = $validated['position'];
        $careerApply->experience = $validated['experience'] ?? null;
        $careerApply->availability = $validated['availability'] ?? null;
        if ($request->hasFile('resume')) {
            $careerApply->resume_path = $request->file('resume')->store('uploads/resumes', 'public');
        }
        $careerApply->cover_letter = $validated['cover_letter'] ?? null;
        $careerApply->save();

        // forward email to admin
        $forwardTo = config('mail.forward_to', null);
        if ($forwardTo) {
            try {
                Mail::send('emails.career-application', ['application' => $careerApply], function ($message) use ($careerApply, $forwardTo) {
                    $message->to($forwardTo);
                    $message->subject('New Job Application - '.$careerApply->position);
                });
            } catch (\Throwable $th) {
            }
        }

        return redirect()->back()->with('success', 'Your application has been submitted successfully!');
    }
}
