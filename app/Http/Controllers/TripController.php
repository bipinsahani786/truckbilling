<?php

namespace App\Http\Controllers;

use App\Services\TripService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    protected TripService $tripService;

    public function __construct(TripService $tripService)
    {
        $this->tripService = $tripService;
    }

    /**
     * Download trip ledger/bill PDF for web users.
     * 
     * @param int $id Trip ID
     * @return \Illuminate\Http\Response
     */
    public function downloadInvoice($id)
    {
        $user = Auth::user();
        
        // Security: Ensure driver only sees their own trips
        $driverId = $user->hasRole('driver') ? $user->id : null;

        try {
            // Verify access through loadTripData which has security checks
            // This will throw ModelNotFoundException if the trip doesn't belong to the driver
            $this->tripService->loadTripData((int)$id, $driverId);
            
            return $this->tripService->generateBillPdf((int)$id);
        } catch (\Exception $e) {
            abort(404, 'Trip not found or unauthorized.');
        }
    }
}
