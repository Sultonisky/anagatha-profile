<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    // GoogleSheetService will be resolved lazily to handle configuration errors gracefully

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Honeypot field - real users should leave this empty
        if (!empty($request->input('company'))) {
            Log::warning('Contact form honeypot triggered', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            return back()
                ->with('status', 'We received your message.')
                ->with('toast_type', 'success');
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'min:2', 'max:60'],
            'last_name' => ['required', 'string', 'min:2', 'max:60'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        // Combine first_name and last_name into name
        $data = [
            'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? '',
            'message' => $validated['message'],
        ];

        // Submit directly to Google Sheets via Service Account
        try {
            // Resolve service lazily to catch constructor exceptions
            $googleSheetService = app(GoogleSheetService::class);
            $submitted = $googleSheetService->appendContact($data);
            $statusMessage = $submitted
                ? 'Thank you, your message has been received and successfully logged to our system.'
                : 'We received your message, but there was an issue logging it to our system. Our team will follow up manually.';
            $toastType = $submitted ? 'success' : 'error';
        } catch (\RuntimeException $e) {
            // Handle configuration errors (missing credentials or env vars)
            Log::error('Google Sheets configuration error: ' . $e->getMessage(), [
                'data' => $data,
            ]);
            $statusMessage = 'We received your message, but there was a configuration issue. Our team will follow up manually.';
            $toastType = 'error';
        } catch (\Throwable $e) {
            // Handle any other errors
            Log::error('Google Sheets error: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString(),
            ]);
            $statusMessage = 'We received your message, but there was an issue logging it to our system. Our team will follow up manually.';
            $toastType = 'error';
        }

        return back()
            ->with('status', $statusMessage)
            ->with('toast_type', $toastType);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Optional: implement if needed
    }
}
