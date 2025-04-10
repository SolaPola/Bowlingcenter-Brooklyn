<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    // Toon de lijst van scores
    public function index()
    {
        $scores = DB::table('score') // Changed from 'scores' to 'score'
            ->join('person', 'score.personId', '=', 'person.id')
            ->join('customer', 'score.id', '=', 'customer.scoreId')
            ->select('score.id', 'person.firstName', 'person.lastName', 'score.amount', 'customer.membershipType')
            ->get();

        return view('score.index', compact('scores'));
    }

    // Toon het formulier om een nieuwe score aan te maken
    public function create()
    {
        return view('score.create'); // Zorg dat de view bestaat in resources/views/score/create.blade.php
    }

    // Sla een nieuwe score op
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'amount' => 'required|integer|min:0',
            'membershipType' => 'required|string|max:50',
        ]);

        DB::statement('CALL InsertPersonScoreMembership(?, ?, ?, ?)', [
            $request->firstName,
            $request->lastName,
            $request->amount,
            $request->membershipType,
        ]);

        return redirect()->route('score.index')->with('success', 'Score successfully added!');
    }

    // Toon een specifieke score
    public function show($id)
    {
        // Logica om een specifieke score op te halen
        return view('score.show', compact('id')); // Zorg dat de view bestaat in resources/views/score/show.blade.php
    }

    // Toon het formulier om een score te bewerken
    public function edit($id)
    {
        // Logica om een specifieke score op te halen
        return view('score.edit', compact('id')); // Zorg dat de view bestaat in resources/views/score/edit.blade.php
    }

    // Werk een bestaande score bij
    public function update(Request $request, $id)
    {
        // Validatie en update-logica
        // Bijvoorbeeld: $score = Score::findOrFail($id); $score->update($request->all());
        return redirect()->route('score.index')->with('success', 'Score succesvol bijgewerkt!');
    }

    // Verwijder een score
    public function destroy($id)
    {
        // Logica om een score te verwijderen
        // Bijvoorbeeld: Score::destroy($id);
        return redirect()->route('score.index')->with('success', 'Score succesvol verwijderd!');
    }
}