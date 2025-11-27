<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobApplicationController extends Controller
{
    /**
     * Store a newly created job application.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the form data
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:500'],
            'current_salary' => ['nullable', 'string', 'max:100'],
            'expected_salary' => ['required', 'string', 'max:100'],
            'availability' => ['required', 'string'],
            'relocation' => ['required', 'string'],
            'linkedin' => ['nullable', 'url', 'max:500'],
            'github' => ['nullable', 'url', 'max:500'],
            'social_media' => ['nullable', 'url', 'max:500'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5MB max
            'portfolio_file' => ['nullable', 'file', 'mimes:pdf,zip,rar', 'max:10240'], // 10MB max
            'cover_letter' => ['nullable', 'string', 'max:5000'],
            'reason_applying' => ['required', 'string', 'min:10', 'max:2000'],
            'relevant_experience' => ['nullable', 'string', 'max:5000'],
        ]);

        try {
            // In a real application, you would:
            // 1. Store the uploaded files
            // 2. Save the application data to database
            // 3. Send notification emails
            // 4. Log the application
            
            // For now, just log the successful submission
            Log::info('Job application submitted', [
                'email' => $validated['email'],
                'name' => $validated['full_name'],
                'phone' => $validated['phone'],
            ]);

            // Redirect back with success message and modal trigger
            return redirect()
                ->back()
                ->with('application_success', true)
                ->with('status', 'Your job application has been submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Job application submission error', [
                'error' => $e->getMessage(),
                'email' => $request->input('email'),
            ]);

            return redirect()
                ->back()
                ->with('status', 'There was an error submitting your application. Please try again.')
                ->with('toast_type', 'error')
                ->withInput();
        }
    }
}

