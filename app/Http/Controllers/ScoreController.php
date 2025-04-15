<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function index()
    {
        $scoreOverview = DB::select('CALL GetScoreOverview()');
        return view('score.index', ['scoreOverview' => $scoreOverview]);
    }

    public function show($id)
    {
        // Call the stored procedure to get the specific row
        $score = DB::select('CALL ReadScores(?)', [$id]);

        // Ensure the result is not empty
        if (empty($score)) {
            abort(404, 'Score not found');
        }

        // Pass the first result to the view
        return view('score.show', ['score' => $score[0]]);
    }

    public function edit($id)
    {
        // Fetch the specific score using a stored procedure
        $score = DB::select('CALL EditScore(?)', [$id]);

        // Ensure the result is not empty
        if (empty($score)) {
            abort(404, 'Score not found');
        }

        // Pass the score to the edit view
        return view('score.edit', ['score' => $score[0]]);
    }
}
