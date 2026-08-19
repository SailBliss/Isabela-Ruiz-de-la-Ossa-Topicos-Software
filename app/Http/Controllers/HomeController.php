<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home.index');
    }

    public function about(): View
    {
        return view('home.about', [
            'title' => 'About us - Online Store',
            'subtitle' => 'About us',
            'description' => 'This is an online store built with Laravel 12.',
            'author' => 'Developed by: Isabela Ruiz de la Ossa',
        ]);
    }

    public function contact(): View
    {
        return view('home.contact', [
            'title' => 'Contact - Online Store',
            'subtitle' => 'Contact',
            'name' => 'Isabela Ruiz de la Ossa',
            'address' => 'Medellín, Colombia',
            'phone' => '12345677',
        ]);
    }
}
