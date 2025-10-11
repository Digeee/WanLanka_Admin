<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function testFixedBookings()
    {
        try {
            $count = DB::table('fixed_bookings')->count();
            return response()->json([
                'status' => 'success',
                'message' => "Found {$count} fixed bookings in the database"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}