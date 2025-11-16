<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Illuminate\Support\Facades\Log;

class GoogleSheetService
{
    private Sheets $sheetsService;
    private string $spreadsheetId;
    private string $sheetName;

    public function __construct()
    {
        $credentialsPath = storage_path('app/google/credentials.json'); // absolute path
        $this->spreadsheetId = (string) config('google_sheets.spreadsheet_id', '');
        $this->sheetName = (string) config('google_sheets.sheet_name', 'Sheet1');

        if (empty($credentialsPath) || !file_exists($credentialsPath)) {
            throw new \RuntimeException('Google credentials.json not found at: ' . $credentialsPath);
        }
        if (empty($this->spreadsheetId)) {
            throw new \RuntimeException('Missing GOOGLE_SHEET_ID in environment.');
        }

        $client = new Client();
        $client->setAuthConfig($credentialsPath);
        $client->setScopes([Sheets::SPREADSHEETS]);

        $this->sheetsService = new Sheets($client);
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
        } catch (\Throwable $e) {
            Log::error('Google Sheets append error: ' . $e->getMessage());
            return false;
        }
    }
}


