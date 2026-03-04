<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with(['booking', 'field'])->where('is_deleted', false)->get();
        return Inertia::render('Reviews/Index', [
            'reviews' => $reviews
        ]);
    }
}
