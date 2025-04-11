<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BaanController extends Controller
{
    public function edit($id)
    {
        // Haal de gegevens van de specifieke reservering op
        $reservering = DB::table('reservering')->where('BaanId', $id)->first();

        // Controleer of de reservering bestaat
        if (!$reservering) {
            return redirect()->route('reservering.wijzigen')->with('error', 'Reservering niet gevonden.');
        }

        // Haal alle banen op voor de keuzelijst
        $banen = DB::table('baan')->get();

        return view('baan.edit', compact('id', 'reservering', 'banen'));
    }

    public function update(Request $request, $id)
    {
        // Valideer de invoer
        $request->validate([
            'baanId' => 'required|integer|exists:baan,Id',
        ]);

        // Haal de reservering op
        $reservering = DB::table('reservering')->where('BaanId', $id)->first();

        // Controleer of er kinderen zijn in de reservering
        if ($reservering->AantalKinderen > 0) {
            // Zorg ervoor dat alleen BaanId 7 of 8 geselecteerd kan worden
            if (!in_array($request->input('baanId'), [7, 8])) {
                return redirect()->back()->with('error', 'Deze baan is ongeschikt voor kinderen. Alleen banen met hekjes (7 of 8) zijn toegestaan.');
            }
        }

        // Update de reservering met het nieuwe baannummer
        DB::table('reservering')
            ->where('BaanId', $id)
            ->update(['BaanId' => $request->input('baanId')]);

        // Redirect terug naar de wijzigen-pagina met een succesmelding
        return redirect()->route('reservering.wijzigen')->with('success', 'Het baannummer is gewijzigd.');
    }
}
