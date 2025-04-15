<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ScoreController extends Controller
{
    // Toon de lijst van scores
    public function index()
    {
        $scores = DB::select('CALL GetScoreOverview()');

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
        // Use Eloquent to fetch the record
        $score = Score::findOrFail($id);
        
        return view('score.show', compact('score'));
    }

    // Toon het formulier om een score te bewerken
    public function edit($id)
    {
        $score = DB::select('SELECT id, amount FROM score WHERE id = ?', [$id]);
        
        // The DB::select returns an array of objects, so we need to get the first one
        $score = $score[0] ?? null;
        
        if (!$score) {
            // Handle the case when score is not found
            return redirect()->route('score.index')->with('error', 'Score not found');
        }
        
        return view('score.edit', compact('score'));
    }

    // Werk een bestaande score bij
    public function update(Request $request, $id)
    {
        $request->validate([
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'amount' => 'required|integer|min:0',
            'membershipType' => 'required|string|max:50',
        ]);

        try {
            // Haal de huidige gegevens op
            $currentData = DB::table('score')
                ->join('customer', 'score.id', '=', 'customer.scoreId')
                ->join('person', 'customer.personId', '=', 'person.id')
                ->select('person.id as personId', 'score.id as scoreId', 'person.firstName', 'person.lastName', 'score.amount', 'customer.membershipType')
                ->where('score.id', $id)
                ->first();

            if (!$currentData) {
                return redirect()->route('score.index')->with('error', 'Score not found');
            }

            // Update alleen de velden die zijn gewijzigd
            DB::statement('CALL EditPersonScoreMembership(?, ?, ?, ?, ?, ?)', [
                $currentData->personId,
                $request->firstName !== $currentData->firstName ? $request->firstName : $currentData->firstName,
                $request->lastName !== $currentData->lastName ? $request->lastName : $currentData->lastName,
                $currentData->scoreId,
                $request->amount !== $currentData->amount ? $request->amount : $currentData->amount,
                $request->membershipType !== $currentData->membershipType ? $request->membershipType : $currentData->membershipType,
            ]);

            return redirect()->route('score.index')->with('success', 'Score successfully updated!');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error updating score: ' . $e->getMessage());
            return redirect()->route('score.index')->with('error', 'An error occurred while updating the score: ' . $e->getMessage());
        }
    }

    // Verwijder een score
    public function destroy($id)
    {
        try {
            // Haal de customerId op die gekoppeld is aan de scoreId
            $customer = DB::table('customer')->where('scoreId', $id)->first();

            if ($customer) {
                // Verwijder gerelateerde gegevens uit de reservation-tabel
                DB::table('reservation')->where('customerId', $customer->id)->delete();

                // Verwijder uit de customer-tabel
                DB::table('customer')->where('id', $customer->id)->delete();
                
                // Verwijder uit de person-tabel
                DB::table('person')->where('id', $customer->personId)->delete();
            }

            // Verwijder uit de score-tabel
            DB::table('score')->where('id', $id)->delete();

            return redirect()->route('score.index')->with('success', 'Score successfully deleted!');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error deleting score: ' . $e->getMessage());
            return redirect()->route('score.index')->with('error', 'An error occurred while deleting the score: ' . $e->getMessage());
        }
    }
};
