<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReserveringController extends Controller
{
    public function index(Request $request)
    {
        $datum = $request->input('datum') ?? date('Y-m-d'); // Gebruik de huidige datum als standaard

        // Haal gegevens op via de stored procedure
        $query = 'CALL GetReserveringOverzicht()';
        $reserveringen = DB::select($query);

        // Filter resultaten op datum als een datum is opgegeven
        if ($datum) {
            $reserveringen = array_filter($reserveringen, function ($reservering) use ($datum) {
                return $reservering->Datum <= $datum;
            });

            // Sorteer de resultaten aflopend op datum
            usort($reserveringen, function ($a, $b) {
                return strcmp($b->Datum, $a->Datum);
            });
        }

        // Geef de gegevens door aan de view
        return view('reservering.index', compact('reserveringen', 'datum'));
    }
}
