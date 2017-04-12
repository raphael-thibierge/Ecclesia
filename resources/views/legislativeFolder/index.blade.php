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
            <h1>Dossiers législatifs</h1>
        </div>


        <div class="row">
            <div class="col-xs-12">

                {{ $folders->links() }}

                <div class="list-group">
                    @forelse($folders as $folder)
                        <a class="list-group-item" href="{{ route('legislativeFolder.show', ['legislativeFolder' => $folder]) }}">
                            {{ ucfirst($folder->title) }}
                        </a>

                    @empty
                        <div class="list-group-item list-group-item-danger">
                            Pas de dossier législatif...
                        </div>

                    @endforelse
                </div>


            </div>
        </div>


    </div>
@endsection
