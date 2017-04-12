@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-xs-12">
                <div class="page-header">
                    <h1>Dossier législatif</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="jumbotron">
                    <h2>
                        {{ ucfirst($folder->title) }}
                    </h2>
                    <p><a href="{{ $folder->url }}">Voir sur le site du sénat</a></p>
                    <p>Procédure parlementaire :  {{ $folder->parliamentaryProcedureTitle }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h2>Actes parlementaires</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">

                <div class="list-group">
                    @forelse($folder->acts as $act)

                        <div class="list-group-item">
                            <h4 class="list-group-item-heading">{{ $act->title }}</h4>
                            <p class="list-group-item-text">
                                {{ $act->organ->title }}
                            </p>
                            @if($act->date != null)
                                <p class="list-group-item-text">
                                    {{ $act->date->format('d-m-Y') }}
                                </p>
                            @endif
                        </div>

                    @empty
                        <div class="list-group-item list-group-item-danger">
                            Pas d'acte parlementaire
                        </div>
                    @endforelse
                </div>
            </div>
        </div>



    </div>
@endsection
