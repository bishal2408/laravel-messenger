<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    /**
     * home
     *
     * @return mixed
     */
    public function home()
    {
        return inertia('Home');
    }
}
