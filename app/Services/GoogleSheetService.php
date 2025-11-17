<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Illuminate\Support\Facades\Log;

// Ensure Google API Client is autoloaded
if (!class_exists('Google\Client')) {
    require_once __DIR__ . '/../../vendor/autoload.php';
}

class GoogleSheetService
{
    private Sheets $sheetsService;
    private string $spreadsheetId;
    private string $sheetName;

    public function __construct()
    {
        // GOOGLE_CREDENTIALS_JSON contains the JSON string directly, not a file path
        $credentialsJson = env('GOOGLE_CREDENTIALS_JSON');
        $credentials = $credentialsJson ? json_decode($credentialsJson, true) : null;
        
        $this->spreadsheetId = (string) config('google_sheets.spreadsheet_id', '');
        $this->sheetName = (string) config('google_sheets.sheet_name', 'Sheet1');

        // Validate credentials JSON
        if (empty($credentials) || !is_array($credentials)) {
            Log::error('Google Sheets credentials invalid or missing', [
                'has_json' => !empty($credentialsJson),
                'json_valid' => json_last_error() === JSON_ERROR_NONE,
                'json_error' => json_last_error_msg(),
            ]);
            throw new \RuntimeException('GOOGLE_CREDENTIALS_JSON is missing or invalid. Please check your environment configuration.');
        }
        
        // Validate required credential fields
        if (empty($credentials['client_email']) || empty($credentials['private_key'])) {
            Log::error('Google Sheets credentials missing required fields', [
                'has_client_email' => !empty($credentials['client_email']),
                'has_private_key' => !empty($credentials['private_key']),
            ]);
            throw new \RuntimeException('Google credentials are missing required fields (client_email or private_key).');
        }
        
        if (empty($this->spreadsheetId)) {
            Log::error('Google Sheets configuration missing', [
                'spreadsheet_id' => $this->spreadsheetId,
                'sheet_name' => $this->sheetName,
            ]);
            throw new \RuntimeException('Missing GOOGLE_SHEET_ID in environment.');
        }

        try {
            // Ensure autoload is loaded
            if (!class_exists('Google\Client')) {
                require_once base_path('vendor/autoload.php');
            }
            
            $client = new Client();
            $client->setAuthConfig($credentials);
            $client->setScopes([Sheets::SPREADSHEETS]);

            $this->sheetsService = new Sheets($client);
        } catch (\Throwable $e) {
            Log::error('Google Sheets client initialization error', [
                'error' => $e->getMessage(),
                'class' => get_class($e),
                'has_credentials' => !empty($credentials),
                'client_exists' => class_exists('Google\Client'),
                'sheets_exists' => class_exists('Google\Service\Sheets'),
            ]);
            throw new \RuntimeException('Failed to initialize Google Sheets client: ' . $e->getMessage());
        }
    }

    public function appendContact(array $data): bool
    {
        try {
            $values = [[
                $data['name'] ?? '',
                $data['email'] ?? '',
                $data['phone'] ?? '',
                $data['message'] ?? '',
                now()->toDateTimeString(),
            ]];

            $body = new ValueRange([
                'values' => $values,
            ]);

            $range = $this->sheetName;
            $params = ['valueInputOption' => 'RAW'];

            $this->sheetsService->spreadsheets_values->append(
                $this->spreadsheetId,
                $range,
                $body,
                $params
            );
            return true;
        } catch (\Google\Service\Exception $e) {
            // Google API specific errors
            $errorDetails = json_decode($e->getMessage(), true);
            $errorMessage = $e->getMessage();
            if (isset($errorDetails['error']['message'])) {
                $errorMessage = $errorDetails['error']['message'];
            }
            Log::error('Google Sheets API error: ' . $errorMessage, [
                'code' => $e->getCode(),
                'data' => $data,
                'spreadsheet_id' => $this->spreadsheetId,
                'sheet_name' => $this->sheetName,
            ]);
            return false;
        } catch (\Throwable $e) {
            Log::error('Google Sheets append error: ' . $e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                'data' => $data,
                'trace' => $e->getTraceAsString(),
            ]);
            return false;
        }
    }
}


