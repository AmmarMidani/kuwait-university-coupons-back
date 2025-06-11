<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function index($locale)
    {
        if (!in_array($locale, ['en', 'ar'])) {
            abort(400);
        }
        Session::put('locale', $locale);
        return redirect()->back();
    }
}
