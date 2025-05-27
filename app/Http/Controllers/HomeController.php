<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('welcome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function welcome()
    {
        $section_titles = [
            ['title' => '🛡️ Secure & Role-Based Access', 'content' => 'Built with robust authentication and role management, the system ensures that students, merchants, and administrators can only access what’s relevant to them — powered by Laravel Sanctum and Spatie Permissions.'],
            ['title' => '🍽️ Smart Meal Scheduling', 'content' => 'Meals are organized by specific time windows and dynamically presented based on the current time. Students can easily view what\'s upcoming or ongoing today.'],
            ['title' => '💳 Merchant-Specific Pricing', 'content' => 'Each meal can have multiple prices based on which merchant is providing it — complete with effective dates and dynamic retrieval through the API.'],
            ['title' => '📋 Feedback-Driven Surveys', 'content' => 'After each meal, students are invited to submit optional survey responses. This feedback loop helps improve food quality and service transparency.'],
            ['title' => '🔐 Student QR Authentication', 'content' => 'Each student has a unique, regenerable QR code tied to their account — used for quick identification, meal collection, and survey matching.'],
            ['title' => '📊 Real-Time Reporting & Analytics', 'content' => 'Admins can monitor meal activity, survey completion rates, and merchant participation in real-time, helping them make data-informed decisions efficiently.'],
        ];
        return view('welcome', compact('section_titles'));
    }
}
