<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReserveringController extends Controller
{
    public function index(Request $request)
    {
        $datum = $request->get('datum', date('Y-m-d'));

        // Pass the datum parameter to the stored procedure
        $reserveringen = DB::select('CALL GetReserveringOverzicht(?)', [$datum]);

        return view('reservering.index', compact('reserveringen', 'datum'));
    }

    public function wijzigen(Request $request)
    {
        $status = $request->get('status', '');

        $query = 'CALL GetReserveringOverzicht()';
        $reserveringen = DB::select($query);

        if ($status) {
            $reserveringen = array_filter($reserveringen, function ($reservering) use ($status) {
                return strtolower($reservering->Status) === strtolower($status);
            });
        }

        return view('reservering.wijzigen', compact('reserveringen', 'status'));
    }


    public function updateBaan(Request $request, $id)
    {
        $validated = $request->validate([
            'courtId' => 'required|integer',
            'status' => 'required|string|max:50',
        ]);

        DB::statement('CALL sp_update_reservation(?, ?, NULL, NULL, NULL, ?, NULL, NULL)', [
            $id,
            $validated['courtId'],
            $validated['status'],
        ]);

        return redirect()->route('reservering.wijzigen')->with('success', 'Reservering succesvol bijgewerkt.');
    }
}
