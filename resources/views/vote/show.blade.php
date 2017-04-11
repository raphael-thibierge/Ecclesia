@extends('layouts.app')

@section('content')
    <div class="container">



        <div class="row">
            <div class="col-xs-12">
                <div class="jumbotron">
                    <h1>
                        Scrutin n°{{ $vote->number }} du {{ $vote->date }}
                    </h1>
                    <p>{{ ucfirst($vote->title) }}</p>
                    <p>Demandeur :  {{ $vote->applicant }}</p>
                    <p>Décision :  {{ $vote->decision }}</p>
                </div>
            </div>
        </div>



    </div>
@endsection
