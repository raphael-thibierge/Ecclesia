<?php

namespace App\Http\Controllers;

use App\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actors = Actor::orderBy('last_name', 'ASC')->paginate(50);
        return view('Actor.index', [
            'actors'    => $actors
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function show(Actor $actor)
    {


        return view('Actor.show', [
            'actor' => $actor
        ]);
    }
}
