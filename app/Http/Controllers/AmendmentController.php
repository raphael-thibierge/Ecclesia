<?php

namespace App\Http\Controllers;

use App\Amendment;
use Illuminate\Http\Request;

class AmendmentController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Amendment  $amendment
     * @return \Illuminate\Http\Response
     */
    public function show(Amendment $amendment)
    {
        return view('amendment.show', ['amendment' => $amendment]);
    }
}
