@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="jumbotron">
                        <h1 class="text-center">
                            Bienvenue sur Ecclesia
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('actor.index') }}" class="col-md-12 btn btn-default">
                            Liste des acteurs
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('vote.index') }}" class="col-md-12 btn btn-default">
                            Liste des scrutins
                        </a>
                    </div>

                </div>

            </div>



        </div>
    </div>
@endsection
