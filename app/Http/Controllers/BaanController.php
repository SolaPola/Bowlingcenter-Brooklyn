<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaanController extends Controller
{
    public function edit($id)
    {
        // Fetch reservation details
        $reservering = DB::select('CALL GetReserveringDetails(?)', [$id])[0] ?? null;

        if (!$reservering) {
            return redirect()->route('reservering.wijzigen')->with('error', 'Reservering niet gevonden.');
        }

        // Fetch available courts
        $banen = DB::select('CALL sp_check_court_availability(?, ?)', [$reservering->Reserveringsdatum, $reservering->timeslotId]);

        return view('baan.edit', compact('reservering', 'banen', 'id'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'baanId' => 'required|integer',
            'status' => 'required|string|max:50',
        ]);

        DB::statement('CALL sp_update_reservation(?, ?, NULL, NULL, NULL, ?, NULL, NULL)', [
            $id,
            $validated['baanId'],
            $validated['status'],
        ]);

        return redirect()->route('reservering.wijzigen')->with('success', 'Reservering succesvol bijgewerkt.');
    }
}
