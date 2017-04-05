<?php

namespace App\Http\Controllers;

use App\Http\Requests\OpenDataFileRequest;
use App\OpenDataFile;
use Illuminate\Http\Request;

class OpenDataFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = OpenDataFile::all();
        return view('OpenDataFile.index', [
            'files'     => $files
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('OpenDataFile.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OpenDataFileRequest $request)
    {

        $attributes = [
            'name'  => $request->get('name'),
            'url'  => $request->get('url'),
            'description'  => $request->get('description')
        ];

        OpenDataFile::create($attributes);

        return redirect()->route('OpenDataFile.index')->with('success', 'New pen data file added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OpenDataFile  $openDataFile
     * @return \Illuminate\Http\Response
     */
    public function show(OpenDataFile $openDataFile)
    {
        die('euh');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OpenDataFile  $openDataFile
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $file = OpenDataFile::findOrFail($id);

        return view('OpenDataFile.form', [
            "file" => $file
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OpenDataFile  $openDataFile
     * @return \Illuminate\Http\Response
     */
    public function update(OpenDataFileRequest $request, $id)
    {

        $attributes = [
            'name'  => $request->get('name'),
            'url'  => $request->get('url'),
            'description'  => $request->get('description')
        ];

        $file = OpenDataFile::findOrFail($id);
        $file->update($attributes);

        return redirect()->route('OpenDataFile.index')->with('success', 'Open data file updated !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OpenDataFile  $openDataFile
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OpenDataFile::destroy($id);
        return redirect()->route('OpenDataFile.index')->with('success', 'Open data file deleted !');
    }
}
