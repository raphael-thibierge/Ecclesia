@extends('layouts.app')

@section('content')
    <div class="container">

        @if (session('success'))
            <div class="row">
                <div class="col-xs-12">
                    <div class="alert alert-success">
                        {{ session('success')}}
                    </div>
                </div>
            </div>
        @endif


        <div class="page-header">
            <h1>@lang('actor.actors')</h1>
        </div>


        <div class="row">
            <div class="col-xs-12">

                {{ $actors->links() }}

                <div class="list-group">
                    @forelse($actors as $actor)
                        <a class="list-group-item" href="{{ route('actor.show', ['actor' => $actor]) }}">
                            <span class="text-uppercase">{{ $actor->last_name }}</span>
                            <span>{{ $actor->first_name }}</span>
                        </a>

                    @empty
                        <div class="list-group-item list-group-item-danger">
                            Pas d'acteur...
                        </div>

                    @endforelse
                </div>

            </div>
        </div>


    </div>
@endsection
