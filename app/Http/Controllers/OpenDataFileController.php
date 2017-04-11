<?php

namespace App\Http\Controllers;

use App\Http\Requests\OpenDataFileRequest;
use App\OpenDataFile;
use Illuminate\Http\Request;

class OpenDataFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }


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
     * @param OpenDataFileRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(OpenDataFileRequest $request)
    {
        OpenDataFile::create($request->getAttributes());
        return redirect()->route('OpenDataFile.index')->with('success', 'New pen data file added !');
    }

    /**
     * Display the specified resource.
     *
     * @param OpenDataFile $OpenDataFile
     * @return \Illuminate\Http\Response
     * @internal param OpenDataFile $openDataFile
     */
    public function show(OpenDataFile $OpenDataFile)
    {
        // excepted in route file
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param OpenDataFile $OpenDataFile
     * @return \Illuminate\Http\Response
     * @internal param $id
     * @internal param OpenDataFile $openDataFile
     */
    public function edit(OpenDataFile $OpenDataFile)
    {
        return view('OpenDataFile.form', [
            "file" => $OpenDataFile
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OpenDataFileRequest|Request $request
     * @param OpenDataFile $OpenDataFile
     * @return \Illuminate\Http\Response
     * @internal param $id
     * @internal param OpenDataFile $openDataFile
     */
    public function update(OpenDataFileRequest $request, OpenDataFile $OpenDataFile)
    {
        $OpenDataFile->update($request->getAttributes());
        return redirect()->route('OpenDataFile.index')->with('success', 'Open data file updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param OpenDataFile $openDataFile
     */
    public function destroy($id)
    {
        OpenDataFile::destroy($id);
        return redirect()->route('OpenDataFile.index')->with('success', 'Open data file deleted !');
    }

    public function execute(OpenDataFile $OpenDataFile){
        $OpenDataFile->newJob();
        return redirect()->route('OpenDataFile.index')->with('success', 'Open data file will be imported as soon as possible !');
    }


}
