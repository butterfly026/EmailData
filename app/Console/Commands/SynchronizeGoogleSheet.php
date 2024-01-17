<?php

namespace App\Console\Commands;

use App\Models\Marketings;
use Exception;
use Google_Client;
use Google_Service_Sheets;
use Illuminate\Console\Command;
use Revolution\Google\Sheets\Facades\Sheets;

class SynchronizeGoogleSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SynchronizeGoogleSheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SynchronizeGoogleSheet';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Google_Client();
        $client->setApplicationName('emaildata');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $authFile = base_path('gcredentials.json');
        $client->setAuthConfig($authFile);

        $sheetsService = new Google_Service_Sheets($client);
        $spreadsheetId = config('google.spreadsheet_id'); // You can use config('google.spreadsheet_id') if configured in your .env
        $sheetName = 'DONT TOUCH';

        // Define the range you want to retrieve data from (e.g., A1:B10)
        $response = $sheetsService->spreadsheets_values->get($spreadsheetId, $sheetName);

        // Get the values from the response
        $values = $response->getValues();

        // Process and use the values
        $tmpData = [];
        if (!empty($values)) {
            Marketings::truncate();
            foreach ($values as $row) {
                // Process each row of data
                // $row is an array containing the cell values
                if($row[0] == 'Email' && $row[7] == 'City') continue;
                array_push($tmpData, [
                    'email' => $row[0],
                    'first_name' => $row[1],
                    'last_name' => $row[2],
                    'title' => $row[3],
                    'company' => $row[4],
                    'domain' => $row[5],
                    'linkedin_url' => $row[6],
                    'city' => $row[7],
                    'state' => $row[8],
                    'country' => $row[9],
                    'industry' => $row[10],
                ]);                
                if(count($tmpData) >= 200) {
                    Marketings::insert($tmpData);
                    $tmpData = [];
                }
            }
            if(count($tmpData) > 0) {
                Marketings::insert($tmpData);
                $tmpData = [];
            }
        } else {
            // No data found in the specified sheet
        }
        return Command::SUCCESS;
    }
}
