@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-xs-12">
                <div class="jumbotron">
                    <h1>
                        {{ $amendment->text_fragment_pointer_title }}
                    </h1>

                    @if ($amendment->legislative_document != null)
                    <p> Document législatif : <strong><a href="{{ route('legislativeDocument.show', ['legislativeDocument' => $amendment->legislative_document]) }}">{{ ucfirst($amendment->legislative_document->title) }}</a></strong></p>
                    @else
                        <div class="alert alert-danger">
                            Document législatif introuvable
                        </div>
                    @endif
                    <p>Etat :  {{ $amendment->state }}</p>

                    @if ($amendment->deposit_date != null)
                        <p>Date de dépot : {{ $amendment->deposit_date->format('d-m-Y') }}</p>
                    @endif

                    @if ($amendment->distribution_date != null)
                        <p>Date de distribution : {{ $amendment->distribution_date->format('d-m-Y') }}</p>
                    @endif

                    @if ($amendment->decision_date != null)
                        <p>Date de distribution : {{ $amendment->distribution_date->format('d-m-Y') }}</p>
                    @endif


                    <p>Autheur :
                        <a href="{{ route('actor.show', ['actor' => $amendment->author ]) }}">
                            {{ $amendment->author->first_name}} <span class="text-uppercase"> {{ $amendment->author->last_name }}</span>
                        </a>
                    </p>

                    @if ($amendment->author != $amendment->co_author)
                        <p>Co-autheur :
                            <a href="{{ route('actor.show', ['actor' => $amendment->co_author ]) }}">
                                {{ $amendment->co_author->first_name}} <span class="text-uppercase"> {{ $amendment->co_author->last_name }}</span>
                            </a>
                        </p>
                    @endif

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Corps
                    </div>
                    <div class="panel-body">
                        {!! $amendment->content !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Sommaire
                    </div>
                    <div class="panel-body">
                        {!! $amendment->content_summary !!}
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection
