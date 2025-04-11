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
        $score = DB::select('CALL GetScoreById(?)', [$id]);
    
        // Ensure the result is not empty
        if (empty($score)) {
            abort(404, 'Score not found');
        }
    
        // Pass the first result to the view
        return view('score.show', ['score' => $score[0]]);
    }
}
