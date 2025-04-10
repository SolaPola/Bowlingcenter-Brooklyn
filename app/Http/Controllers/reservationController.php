<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Court;
use App\Models\Timeslot;

class ReservationController extends Controller
{

    /**
     * Display a listing of the reservations.
     */
    public function index()
    {
        $reservations = Reservation::with(['customer', 'court', 'timeslot'])->get();
        return view('reservation.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create()
    {
        $courts = Court::where('isActive', true)->get();
        $timeslots = Timeslot::where('isActive', true)->get();
        
        return view('reservation.create', compact('courts', 'timeslots'));
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'courtId' => 'required|exists:court,id',
            'timeslotId' => 'required|exists:timeslot,id',
            'date' => 'required|date|after_or_equal:today',
            'numberOfPeople' => 'required|integer|min:1',
            'minutes' => 'required|integer|min:30',
            'note' => 'nullable|string|max:255',
        ]);

        $reservation = new Reservation();
        $reservation->customerId = Auth::id();
        $reservation->courtId = $request->courtId;
        $reservation->timeslotId = $request->timeslotId;
        $reservation->date = $request->date;
        $reservation->numberOfPeople = $request->numberOfPeople;
        $reservation->minutes = $request->minutes;
        $reservation->note = $request->note;
        $reservation->status = 'pending';
        $reservation->isActive = true;
        $reservation->createdAt = now();
        $reservation->updatedAt = now();
        $reservation->save();

        return redirect()->route('reservation.show', $reservation->id)
                        ->with('success', 'Reservation created successfully.');
    }

    /**
     * Display the specified reservation.
     */
    public function show($id)
    {
        $reservation = Reservation::with(['customer', 'court', 'timeslot', 'orders'])->findOrFail($id);
        return view('reservation.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified reservation.
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $courts = Court::where('isActive', true)->get();
        $timeslots = Timeslot::where('isActive', true)->get();
        
        return view('reservation.edit', compact('reservation', 'courts', 'timeslots'));
    }

    /**
     * Update the specified reservation in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'courtId' => 'required|exists:court,id',
            'timeslotId' => 'required|exists:timeslot,id',
            'date' => 'required|date',
            'numberOfPeople' => 'required|integer|min:1',
            'minutes' => 'required|integer|min:30',
            'status' => 'required|string',
            'note' => 'nullable|string|max:255',
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->courtId = $request->courtId;
        $reservation->timeslotId = $request->timeslotId;
        $reservation->date = $request->date;
        $reservation->numberOfPeople = $request->numberOfPeople;
        $reservation->minutes = $request->minutes;
        $reservation->status = $request->status;
        $reservation->note = $request->note;
        $reservation->updatedAt = now();
        $reservation->save();

        return redirect()->route('reservation.show', $reservation->id)
                        ->with('success', 'Reservation updated successfully.');
    }

    /**
     * Remove the specified reservation from storage.
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->isActive = false;
        $reservation->updatedAt = now();
        $reservation->save();

        return redirect()->route('reservation.index')
                        ->with('success', 'Reservation deactivated successfully.');
    }
}
