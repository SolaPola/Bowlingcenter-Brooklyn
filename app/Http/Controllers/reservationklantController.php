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

class ReservationKlantController extends Controller
{
    /**
     * Display a listing of the reservations.
     */
    public function index(Request $request)
    {
        try {

             // Haal de datum op uit de request
            $date = $request->input('date');
            // Get all reservations from stored procedure
            $allReservations = DB::select('CALL sp_get_all_reservations()');
            // Filter reservations by date if provided
            
            $reservationsfilter = DB::select('CALL sp_get_reservations_by_date_filter(?)', [$date]);
            // Check if the user is authenticated
            if (!$date) {
                // Haal alle reserveringen op als er geen datum is opgegeven
                $reservationsfilter = DB::select('CALL sp_get_all_reservations()');
            } else {
                // Filter reserveringen op de opgegeven datum
                $reservationsfilter = DB::select('CALL sp_get_reservations_by_date_filter(?)', [$date]);
            }
        
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
            
           
            return view('reservation_klant.index', compact('reservations', 'date','reservationsfilter'));
            return view('reservation_klant.index.filter', compact('reservations', 'date'));
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
            
            // Check if there are available courts and timeslots
            if ($courts->isEmpty()) {
                return redirect()->route('reservation_klant.index')
                               ->with('error', 'Er zijn geen beschikbare banen gevonden.');
            }
            
            if ($timeslots->isEmpty()) {
                return redirect()->route('reservation_klant.index')
                               ->with('error', 'Er zijn geen beschikbare tijdslots gevonden.');
            }
            
            return view('reservation_klant.create', compact('courts', 'timeslots'));
        } catch (Exception $e) {
            Log::error('Error in create form: ' . $e->getMessage());
            return redirect()->route('reservation_klant.index')
                           ->with('error', 'Er is een fout opgetreden bij het laden van het formulier.');
        }
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {
        try {
            // Log the beginning of the store method
            Log::info('Starting reservation creation process');
            Log::info('Form data received: ' . json_encode($request->all()));
            
            $validated = $request->validate([
                'courtId' => 'required|exists:court,id',
                'timeslotId' => 'required|exists:timeslot,id',
                'date' => 'required|date|after_or_equal:today',
                'numberOfPeople' => 'required|integer|min:1',
                'minutes' => 'required|integer|min:30',
                'note' => 'nullable|string|max:255',
            ]);
            
            // Get the customer ID from the authenticated user
            $customerId = Auth::id();
            
            // Check if the user is authenticated
            if (!$customerId) {
                Log::error('User is not authenticated. Cannot create reservation.');
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'U moet ingelogd zijn om een reservering te maken.');
            }
            
            Log::info('Creating reservation for customer ID: ' . $customerId);
            
            $status = 'pending';
            $note = $validated['note'] ?? null;
            
            // Log parameters before calling stored procedure
            Log::info('Calling stored procedure with parameters: ', [
                'customerId' => $customerId,
                'courtId' => $validated['courtId'],
                'timeslotId' => $validated['timeslotId'],
                'date' => $validated['date'],
                'minutes' => $validated['minutes'],
                'status' => $status,
                'numberOfPeople' => $validated['numberOfPeople'],
                'note' => $note
            ]);

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
            
            // Log the stored procedure result
            Log::info('Stored procedure result: ' . json_encode($result));
            
            if (!empty($result) && isset($result[0]->reservation_id) && $result[0]->reservation_id > 0) {
                Log::info('New reservation created with ID: ' . $result[0]->reservation_id);
                return redirect()->route('reservation_klant.show', $result[0]->reservation_id)
                              ->with('success', 'Reservering is succesvol aangemaakt.');
            } else {
                $errorMessage = !empty($result) && isset($result[0]->message) 
                    ? $result[0]->message 
                    : 'Er is een fout opgetreden bij het aanmaken van de reservering.';
                
                Log::error('Failed to create reservation: ' . $errorMessage);
                return redirect()->back()
                               ->withInput()
                               ->with('error', $errorMessage);
            }
        } catch (Exception $e) {
            Log::error('Exception in store method: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Er is een fout opgetreden bij het opslaan van de reservering: ' . $e->getMessage());
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
                return redirect()->route('reservation_klant.index')
                               ->with('error', 'Reservering niet gevonden.');
            }
            
            $reservation = $reservationData[0];
            
            // Get related orders
            $orders = DB::table('order')
                       ->where('reservationId', $id)
                       ->where('isActive', 1)
                       ->get();
            
            return view('reservation_klant.show', compact('reservation', 'orders'));
        } catch (Exception $e) {
            Log::error('Error showing reservation details: ' . $e->getMessage());
            return redirect()->route('reservation_klant.index')
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
                return redirect()->route('reservation_klant.index')
                               ->with('error', 'Reservering niet gevonden.');
            }
            
            $reservation = $reservationData[0];
            $courts = Court::where('isActive', true)->get();
            $timeslots = Timeslot::where('isActive', true)->get();
            
            // Check if there are available courts and timeslots
            if ($courts->isEmpty() || $timeslots->isEmpty()) {
                Log::warning('No active courts or timeslots available for editing a reservation');
                return redirect()->route('reservation_klant.index')
                               ->with('error', 'Er zijn geen actieve banen of tijdslots beschikbaar.');
            }
            
            return view('reservation_klant.edit', compact('reservation', 'courts', 'timeslots'));
        } catch (Exception $e) {
            Log::error('Error in edit form: ' . $e->getMessage());
            return redirect()->route('reservation_klant.index')
                           ->with('error', 'Er is een fout opgetreden bij het laden van het formulier.');
        }
    }

    /**
     * Update the specified reservation in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('Starting reservation update process for ID: ' . $id);
            Log::info('Update form data received: ' . json_encode($request->all()));
            
            $validated = $request->validate([
                'courtId' => 'required|exists:court,id',
                'timeslotId' => 'required|exists:timeslot,id',
                'date' => 'required|date',
                'numberOfPeople' => 'required|integer|min:1',
                'minutes' => 'required|integer|min:30',
                'status' => 'required|string|in:pending,confirmed,canceled,completed',
                'note' => 'nullable|string|max:255',
            ]);
            
            // First, check if the reservation exists and is active
            $existingReservation = DB::select('CALL sp_get_reservation_by_id(?)', [$id]);
            
            if (empty($existingReservation)) {
                Log::warning('Attempted to update non-existent reservation with ID: ' . $id);
                return redirect()->route('reservation_klant.index')
                               ->with('error', 'Reservering niet gevonden.');
            }
            
            if (!$existingReservation[0]->isActive) {
                Log::warning('Attempted to update canceled reservation with ID: ' . $id);
                return redirect()->route('reservation_klant.index')
                               ->with('error', 'Geannuleerde reserveringen kunnen niet worden bijgewerkt.');
            }
            
            // If court, timeslot or date has changed, check availability
            if ($existingReservation[0]->courtId != $validated['courtId'] || 
                $existingReservation[0]->timeslotId != $validated['timeslotId'] || 
                $existingReservation[0]->date != $validated['date']) {
                
                // Check if the court is available
                $availability = DB::select('CALL sp_check_court_availability(?, ?)', [
                    $validated['date'],
                    $validated['timeslotId']
                ]);
                
                $courtAvailable = false;
                foreach ($availability as $court) {
                    if ($court->id == $validated['courtId'] && $court->status === 'Available') {
                        $courtAvailable = true;
                        break;
                    }
                }
                
                if (!$courtAvailable) {
                    Log::warning('Court is not available for the selected date and time during update');
                    return redirect()->back()
                                   ->withInput()
                                   ->with('error', 'Deze baan is helaas al gereserveerd voor het gekozen tijdslot.');
                }
            }
            
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
            
            if (!empty($result) && isset($result[0]->reservation_id) && $result[0]->reservation_id > 0) {
                Log::info('Reservation updated with ID: ' . $id);
                return redirect()->route('reservation_klant.show', $id)
                               ->with('success', 'Reservering is succesvol bijgewerkt.');
            } else {
                $errorMessage = !empty($result) && isset($result[0]->message) 
                    ? $result[0]->message 
                    : 'Er is een fout opgetreden bij het bijwerken van de reservering.';
                
                Log::error('Failed to update reservation: ' . $errorMessage);
                return redirect()->back()
                               ->withInput()
                               ->with('error', $errorMessage);
            }
        } catch (Exception $e) {
            Log::error('Error updating reservation: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Er is een fout opgetreden bij het bijwerken van de reservering: ' . $e->getMessage());
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
            return redirect()->route('reservation_klant.index')
                           ->with('success', 'De reservering is succesvol geannuleerd.');
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
            
            return view('reservation_klant.by-date', compact('reservations', 'date'));
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