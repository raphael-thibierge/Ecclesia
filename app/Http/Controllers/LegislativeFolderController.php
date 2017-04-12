<?php

namespace App\Http\Controllers;

use App\LegislativeFolder;
use Illuminate\Http\Request;

class LegislativeFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = LegislativeFolder::paginate(50);
        return view('legislativeFolder.index', [
            'folders'   => $folders
        ]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LegislativeFolder  $legislativeFolder
     * @return \Illuminate\Http\Response
     */
    public function show(LegislativeFolder $legislativeFolder)
    {
        return view('legislativeFolder.show', [
            'folder'    => $legislativeFolder
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LegislativeFolder  $legislativeFolder
     * @return \Illuminate\Http\Response
     */
    public function edit(LegislativeFolder $legislativeFolder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LegislativeFolder  $legislativeFolder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LegislativeFolder $legislativeFolder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LegislativeFolder  $legislativeFolder
     * @return \Illuminate\Http\Response
     */
    public function destroy(LegislativeFolder $legislativeFolder)
    {
        //
    }
}
