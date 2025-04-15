@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Score</h1>
    <form action="{{ route('score.update', $score->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="player_name">Player Name</label>
            <input type="text" name="player_name" id="player_name" class="form-control" value="{{ old('player_name', $score->player_name) }}" required>
        </div>

        <div class="form-group">
            <label for="score">Score</label>
            <input type="number" name="score" id="score" class="form-control" value="{{ old('score', $score->score) }}" required>
        </div>

        <div class="form-group">
            <label for="game_date">Game Date</label>
            <input type="date" name="game_date" id="game_date" class="form-control" value="{{ old('game_date', $score->game_date) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Score</button>
        <a href="{{ route('score.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection