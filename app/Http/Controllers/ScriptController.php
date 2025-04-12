<?php

namespace App\Http\Controllers;

use App\Enums\AvailableScripts;
use Illuminate\Http\Request;

class ScriptController extends Controller
{
    public function runPythonScript(Request $request)
    {
        // Validate the request
        $request->validate([
            'distributor' => ['required', 'string', 'in:' . implode(',', AvailableScripts::values())],
        ]);

        // Get the enum value from the request
        $enum = $request->input('distributor');

        // Determine the script path based on the enum value
        switch ($enum) {
            case AvailableScripts::Propneu->value:
                $scriptPath = base_path('scripts/process_prices_07ZR.py');
                break;
            case AvailableScripts::Adtyre->value:
                $scriptPath = base_path('scripts/process_prices_07ZR.py');
                break;
            default:
                return response()->json(['error' => 'Invalid enum value / Not implemented yet'], 400);
        }

        // Execute the Python script
        $output = shell_exec("python " . escapeshellarg($scriptPath));

        // Return the output as a JSON response
        return response()->json(['output' => $output]);
    }
}
