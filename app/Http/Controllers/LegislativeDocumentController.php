<?php

namespace App\Http\Controllers;

use App\LegislativeDocument;
use Illuminate\Http\Request;

class LegislativeDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = LegislativeDocument::paginate(50);
        return view('legislativeDocument.index', [
            'documents' => $documents
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\LegislativeDocument  $legislativeDocument
     * @return \Illuminate\Http\Response
     */
    public function show(LegislativeDocument $legislativeDocument)
    {
        return view('legislativeDocument.show', [
            'document'  => $legislativeDocument
        ]);
    }
}
