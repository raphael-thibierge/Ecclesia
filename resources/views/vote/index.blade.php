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
            <h1>Scrutins</h1>
        </div>


        <div class="row">
            <div class="col-xs-12">

                {{ $votes->links() }}

                <div class="list-group">
                    @forelse($votes as $vote)
                        <a class="list-group-item" href="{{ route('vote.show', ['vote' => $vote]) }}">
                            {{ ucfirst($vote->description) }}
                        </a>

                    @empty
                        <div class="list-group-item list-group-item-danger">
                            Pas de scrutins...
                        </div>

                    @endforelse
                </div>


            </div>
        </div>


    </div>
@endsection
