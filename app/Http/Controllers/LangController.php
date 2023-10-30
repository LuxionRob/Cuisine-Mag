<?php

namespace App\Http\Controllers;

class LangController extends Controller
{
    public function changeLang($locale)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }
}
