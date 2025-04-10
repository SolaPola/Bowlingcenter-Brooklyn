<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Court;
use App\Models\Timeslot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class ReservationController extends Controller
{
    /**
     * Display a listing of the reservations.
     */
    public function index()
    {
        try {
            $reservations = Reservation::with(['customer', 'court', 'timeslot'])->get();
            return view('reservation.index', compact('reservations'));
        } catch (Exception $e) {
            Log::error('Error in reservation index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het ophalen van de reserveringen.');
        }
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create()
    {
        try {
            $courts = Court::where('isActive', true)->get();
            $timeslots = Timeslot::where('isActive', true)->get();
            
            return view('reservation.create', compact('courts', 'timeslots'));
        } catch (Exception $e) {
            Log::error('Error in create form: ' . $e->getMessage());
            return redirect()->route('reservations.index')
                           ->with('error', 'Er is een fout opgetreden bij het laden van het formulier.');
        }
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'courtId' => 'required|exists:court,id',
                'timeslotId' => 'required|exists:timeslot,id',
                'date' => 'required|date|after_or_equal:today',
                'numberOfPeople' => 'required|integer|min:1',
                'minutes' => 'required|integer|min:30',
                'note' => 'nullable|string|max:255',
            ]);

            DB::beginTransaction();

            $reservation = new Reservation();
            $reservation->customerId = Auth::id();
            $reservation->courtId = $validated['courtId'];
            $reservation->timeslotId = $validated['timeslotId'];
            $reservation->date = $validated['date'];
            $reservation->numberOfPeople = $validated['numberOfPeople'];
            $reservation->minutes = $validated['minutes'];
            $reservation->note = $validated['note'];
            $reservation->status = 'pending';
            $reservation->isActive = true;
            $reservation->createdAt = now();
            $reservation->updatedAt = now();
            $reservation->save();

            DB::commit();
            
            Log::info('New reservation created with ID: ' . $reservation->id);
            return redirect()->route('reservations.show', $reservation->id)
                            ->with('success', 'Reservation created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error storing reservation: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Er is een fout opgetreden bij het opslaan van de reservering.');
        }
    }

    /**
     * Display the specified reservation.
     */
    public function show($id)
    {
        try {
            $reservation = Reservation::with(['customer', 'court', 'timeslot', 'orders'])->findOrFail($id);
            return view('reservation.show', compact('reservation'));
        } catch (Exception $e) {
            Log::error('Error showing reservation details: ' . $e->getMessage());
            return redirect()->route('reservations.index')
                           ->with('error', 'Er is een fout opgetreden bij het tonen van de reservering.');
        }
    }

    /**
     * Show the form for editing the specified reservation.
     */
    public function edit($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $courts = Court::where('isActive', true)->get();
            $timeslots = Timeslot::where('isActive', true)->get();
            
            return view('reservation.edit', compact('reservation', 'courts', 'timeslots'));
        } catch (Exception $e) {
            Log::error('Error in edit form: ' . $e->getMessage());
            return redirect()->route('reservations.index')
                           ->with('error', 'Er is een fout opgetreden bij het laden van het formulier.');
        }
    }

    /**
     * Update the specified reservation in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'courtId' => 'required|exists:court,id',
                'timeslotId' => 'required|exists:timeslot,id',
                'date' => 'required|date',
                'numberOfPeople' => 'required|integer|min:1',
                'minutes' => 'required|integer|min:30',
                'status' => 'required|string',
                'note' => 'nullable|string|max:255',
            ]);

            DB::beginTransaction();

            $reservation = Reservation::findOrFail($id);
            $reservation->courtId = $validated['courtId'];
            $reservation->timeslotId = $validated['timeslotId'];
            $reservation->date = $validated['date'];
            $reservation->numberOfPeople = $validated['numberOfPeople'];
            $reservation->minutes = $validated['minutes'];
            $reservation->status = $validated['status'];
            $reservation->note = $validated['note'];
            $reservation->updatedAt = now();
            $reservation->save();

            DB::commit();
            
            Log::info('Reservation updated with ID: ' . $id);
            return redirect()->route('reservations.show', $reservation->id)
                            ->with('success', 'Reservation updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating reservation: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Er is een fout opgetreden bij het bijwerken van de reservering.');
        }
    }

    /**
     * Remove the specified reservation from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $reservation = Reservation::findOrFail($id);
            $reservation->isActive = false;
            $reservation->updatedAt = now();
            $reservation->save();
            
            DB::commit();
            
            Log::info('Reservation deactivated with ID: ' . $id);
            return redirect()->route('reservations.index')
                            ->with('success', 'Reservation deactivated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deactivating reservation: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Er is een fout opgetreden bij het deactiveren van de reservering.');
        }
    }
}
