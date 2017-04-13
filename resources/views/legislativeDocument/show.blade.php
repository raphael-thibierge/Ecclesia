@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-xs-12">
                <div class="page-header">
                    <h1>Document législatif</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="jumbotron">
                    <h2>
                        {{ ucfirst($document->title) }}
                        <br>
                        <small>{{ ucfirst($document->classificationTypeTitle)}} {{ $document->classificationUnderTypeTitle }} </small>
                    </h2>
                    @if ($document->adoptionStatus != null)
                        <p> Status d'adoption: {{ $document->adoptionStatus }}</p>
                    @endif

                    @if ($document->creation_date != null)
                        <p> Date de création : {{ $document->creation_date->format('d-m-Y') }}</p>
                    @endif

                    @if ($document->deposit_date != null)
                        <p> Date de dépot : {{ $document->deposit_date->format('d-m-Y') }}</p>
                    @endif

                    @if ($document->publish_date != null)
                        <p> Date de publication : {{ $document->publish_date->format('d-m-Y') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h2>Acteurs autheurs</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">

                <div class="list-group">
                    @forelse($document->author_actors as $actor)

                        @if ($loop->first)
                        @endif

                        <a class="list-group-item" href="{{ route('actor.show', ['actor' => $actor]) }}">
                            {{ $actor->first_name }} {{ $actor->last_name }}
                        </a>

                    @empty
                        <div class="list-group-item">
                            Pas d'acteur autheur
                        </div>
                    @endforelse
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <h2>Organes autheures</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">

                <div class="list-group">
                    @forelse($document->author_organs as $organ)

                        <a class="list-group-item" href="{{ route('organ.show', ['organ', $organ]) }}">
                            {{ ucfirst($organ->short_title)}}
                        </a>

                    @empty
                        <div class="list-group-item">
                            Pas d'organe autheure
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h2>Amendements</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">

                <div class="list-group">
                    @forelse($document->amendments as $amendment)

                        <a href="{{ route('amendment.show', ['amendment' => $amendment]) }}" class="list-group-item list-group-item-{{ $amendment->decision == "Adopté" ? 'success' : 'danger' }}">
                            <h4 class="list-group-item-heading">
                                <strong>
                                    {{ ucfirst($amendment->text_fragment_pointer_title)}}
                                </strong>
                            </h4>
                            <div class="list-group-item-text">
                                {!! $amendment->content !!}
                            </div>
                        </a>

                    @empty
                        <div class="list-group-item">
                            Pas d'amendement...
                        </div>
                    @endforelse
                </div>
            </div>
        </div>



    </div>
@endsection
