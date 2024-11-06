<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'doctor') {
            return view('doctor.appointment.index');
        }

        return view('patient.appointment.index');
    }
}
