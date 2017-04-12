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
}
