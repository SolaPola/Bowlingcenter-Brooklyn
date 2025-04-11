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
            // Controleer of de geselecteerde baan hekjes heeft
            $baan = DB::table('baan')->where('Id', $request->input('baanId'))->first();
            if (!$baan->heeftHek) {
                return redirect()->back()->with('error', 'Deze baan is ongeschikt voor kinderen omdat deze geen hekjes heeft.');
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
