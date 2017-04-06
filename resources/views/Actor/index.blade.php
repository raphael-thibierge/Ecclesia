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
            <h1>Actors</h1>
        </div>


        <div class="row">
            <div class="col-xs-12">

                <table class="table table-bordered table-hover">

                    <thead>
                        <td>First name</td>
                        <td>Last name</td>
                        <td>Sec</td>
                        <td>Birth date</td>
                        <td>Death date</td>
                    </thead>

                    <tbody>

                    @forelse($actors as $actor)

                        <tr>
                            <td>{{ $actor->first_name }}</td>
                            <td>
                                <a href="{{ route('actor.show', ['actor' => $actor]) }}">
                                    {{ $actor->last_name }}
                                </a>
                            </td>
                            <td>{{ $actor->gender }}</td>
                            <td>{{ $actor->birth_date }}</td>
                            <td>{{ $actor->death_date }}</td>
                        </tr>

                    @empty
                        <tr class="danger">
                            <td colspan="3" class="text-center">No actor.</td>
                        </tr>

                    @endforelse

                    {{ $actors->links() }}

                    </tbody>
                </table>

            </div>
        </div>


    </div>
@endsection
