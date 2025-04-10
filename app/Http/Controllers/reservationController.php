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
use Illuminate\Pagination\LengthAwarePaginator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the reservations.
     */
    public function index(Request $request)
    {
        try {
            // Get all reservations from stored procedure
            $allReservations = DB::select('CALL sp_get_all_reservations()');
            
            // Get current page from request query
            $currentPage = $request->input('page', 1);
            
            // Number of items per page
            $perPage = 10;
            
            // Slice the collection to get the items for the current page
            $currentPageItems = array_slice($allReservations, ($currentPage - 1) * $perPage, $perPage);
            
            // Create our paginator and pass it to the view
            $reservations = new LengthAwarePaginator(
                $currentPageItems,
                count($allReservations),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            
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
            return redirect()->route('reservation.index')
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

            $customerId = Auth::id(); // Assuming this is the customer ID
            $status = 'pending';
            $note = $validated['note'] ?? null;

            $result = DB::select('CALL sp_create_reservation(?, ?, ?, ?, ?, ?, ?, ?)', [
                $customerId,
                $validated['courtId'],
                $validated['timeslotId'],
                $validated['date'],
                $validated['minutes'],
                $status,
                $validated['numberOfPeople'],
                $note
            ]);
            
            if ($result[0]->reservation_id > 0) {
                Log::info('New reservation created with ID: ' . $result[0]->reservation_id);
                return redirect()->route('reservation.show', $result[0]->reservation_id)
                                ->with('success', 'Reservation created successfully.');
            } else {
                return redirect()->back()
                               ->withInput()
                               ->with('error', $result[0]->message);
            }
        } catch (Exception $e) {
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
            $reservationData = DB::select('CALL sp_get_reservation_by_id(?)', [$id]);
            
            if (!$reservationData) {
                return redirect()->route('reservation.index')
                               ->with('error', 'Reservering niet gevonden.');
            }
            
            $reservation = $reservationData[0];
            
            // Get related orders
            $orders = DB::table('order')
                        ->where('reservationId', $id)
                        ->where('isActive', 1)
                        ->get();
                        
            return view('reservation.show', compact('reservation', 'orders'));
        } catch (Exception $e) {
            Log::error('Error showing reservation details: ' . $e->getMessage());
            return redirect()->route('reservation.index')
                           ->with('error', 'Er is een fout opgetreden bij het tonen van de reservering.');
        }
    }

    /**
     * Show the form for editing the specified reservation.
     */
    public function edit($id)
    {
        try {
            $reservationData = DB::select('CALL sp_get_reservation_by_id(?)', [$id]);
            
            if (!$reservationData) {
                return redirect()->route('reservation.index')
                               ->with('error', 'Reservering niet gevonden.');
            }
            
            $reservation = $reservationData[0];
            $courts = Court::where('isActive', true)->get();
            $timeslots = Timeslot::where('isActive', true)->get();
            
            return view('reservation.edit', compact('reservation', 'courts', 'timeslots'));
        } catch (Exception $e) {
            Log::error('Error in edit form: ' . $e->getMessage());
            return redirect()->route('reservation.index')
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

            $note = $validated['note'] ?? null;

            $result = DB::select('CALL sp_update_reservation(?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $validated['courtId'],
                $validated['timeslotId'],
                $validated['date'],
                $validated['minutes'],
                $validated['status'],
                $validated['numberOfPeople'],
                $note
            ]);
            
            if ($result[0]->reservation_id > 0) {
                Log::info('Reservation updated with ID: ' . $id);
                return redirect()->route('reservation.show', $id)
                                ->with('success', 'Reservation updated successfully.');
            } else {
                return redirect()->back()
                               ->withInput()
                               ->with('error', $result[0]->message);
            }
        } catch (Exception $e) {
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
            $result = DB::select('CALL sp_cancel_reservation(?)', [$id]);
            
            Log::info('Reservation canceled with ID: ' . $id);
            return redirect()->route('reservation.index')
                            ->with('success', 'Reservation canceled successfully.');
        } catch (Exception $e) {
            Log::error('Error canceling reservation: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Er is een fout opgetreden bij het annuleren van de reservering.');
        }
    }
    
    /**
     * Check availability of courts for a specific date and timeslot.
     */
    public function checkAvailability(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => 'required|date',
                'timeslotId' => 'required|exists:timeslot,id',
            ]);
            
            $availability = DB::select('CALL sp_check_court_availability(?, ?)', [
                $validated['date'],
                $validated['timeslotId']
            ]);
            
            return response()->json([
                'success' => true,
                'data' => $availability
            ]);
        } catch (Exception $e) {
            Log::error('Error checking availability: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error checking availability',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get reservations by date.
     */
    public function getByDate(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => 'required|date',
            ]);
            
            $reservations = DB::select('CALL sp_get_reservations_by_date(?)', [$validated['date']]);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $reservations
                ]);
            }
            
            return view('reservation.by-date', compact('reservations', 'date'));
        } catch (Exception $e) {
            Log::error('Error fetching reservations by date: ' . $e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error fetching reservations',
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                           ->with('error', 'Er is een fout opgetreden bij het ophalen van de reserveringen.');
        }
    }
}
