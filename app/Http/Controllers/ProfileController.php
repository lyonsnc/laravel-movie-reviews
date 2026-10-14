<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ProfileController extends Controller
{
    public function show() {
        #grab the users reviews, etc.
        $reviews = Review::where('user_id', auth()->user()->id)
        ->latest()
        ->get();
        $earliest = $reviews->sortBy('created_at')->first();
        $earliest_date = count($reviews) > 0 ? date("M Y", strtotime($earliest->created_at)) : "none yet...";
        return view('profile', [
            'reviews' => $reviews,
            'earliest_date' => $earliest_date,
        ]);
    }
}
