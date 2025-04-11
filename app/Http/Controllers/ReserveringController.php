<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReserveringController extends Controller
{
    public function index()
    {
        // Haal gegevens op via de stored procedure
        $reserveringen = DB::select('CALL GetReserveringOverzicht()');

        // Zorg ervoor dat $reserveringen altijd een array is
        $reserveringen = $reserveringen ?? [];

        // Geef de gegevens door aan de view
        return view('reservering.index', compact('reserveringen'));
    }
}
