<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Mail;
use App\Mail\NotificationMail;

class BookingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // $user = Auth::user();
        $user = Auth::user();
        if($user->role_id == 1){
            $listing = Court::whereDoesntHave('booking', function($q) use($request){
                $q->where('date', $request->date ?? date('Y-m-j'));
            })->get();
        }
        else{
            $listing = Booking::where('date', $request->date ?? date('Y-m-j'))->get()->transform(function($q){
                return [
                    'id' => $q->id,
                    'name' => $q->court_name,
                    'user' => $q->user_name,
                    'approved' => $q->approved,
                    'date' => $q->date,
                ];
            });
        }


        // dd($listing);
        return json_encode($listing);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $request->validate([

        // ]);
        $user = Auth::user();

        $booking = new Booking();
        $booking->user_id = $request->user_id ?? $user->id;
        $booking->court_id = $request->court_id;
        $booking->date = $request->date;
        $booking->save();

        $content = [
            'title' => 'New Booking Application',
            'body' => 'A new Booking Application has been made by ' .$user->name. '(' . $user->email . ')',
        ];

        $admin = User::where('role_id', '<>', 2)->first();

        Mail::to($admin->email)->send(new NotificationMail ($content));

        if (Mail::failures()) {
            return response('Oopps! Something went wrong', 200);
        }

        $listing = $this->index($request);
        return $listing;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
        $booking->update([
            'approved' => $request->approved,
        ]);

        $status = $request->approved == 1 ? 'Approved' : 'Rejected';

        $content = [
            'title' => 'Booking Application Status',
            'body' => 'Dear ' .$booking->user_name. '(' . $booking->user->email . '). Your booking status on date '.$booking->date.' is '.$status,
        ];

        Mail::to($booking->user->email)->send(new NotificationMail ($content));

        if (Mail::failures()) {
            return response('Oopps! Something went wrong', 200);
        }


        $listing = $this->index($request);
        return $listing;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
