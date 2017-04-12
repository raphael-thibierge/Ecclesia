@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="page-header">
            <h1>Document législatifs</h1>
        </div>


        <div class="row">
            <div class="col-xs-12">

                {{ $documents->links() }}

                <div class="list-group">
                    @forelse($documents as $document)
                        <a class="list-group-item" href="{{ route('legislativeDocument.show', ['legislativeDocument' => $document]) }}">
                            {{ ucfirst($document->title) }}
                        </a>

                    @empty
                        <div class="list-group-item list-group-item-danger">
                            Pas de document législatif...
                        </div>

                    @endforelse
                </div>


            </div>
        </div>


    </div>
@endsection
