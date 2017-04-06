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
            <h1>@lang('actor.actor')</h1>
        </div>


        <div class="row">
            <div class="col-xs-12">

                <table class="table table-bordered table-hover">

                    <thead>
                        <td>{{ucfirst(__('validation.attributes.first_name'))}}</td>
                        <td>{{ucfirst(__('validation.attributes.last_name'))}}</td>
                        <td>@lang('basics.gender')</td>
                        <td>@lang('basics.birth_date')</td>
                        <td>@lang('basics.death_date')</td>
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
                            <td>@lang('basics.' . $actor->gender)</td>
                            <td>{{ $actor->birth_date }}</td>
                            <td>{{ $actor->death_date }}</td>
                        </tr>

                    @empty
                        <tr class="danger">
                            <td colspan="5" class="text-center">@lang('basics.no_data')</td>
                        </tr>

                    @endforelse

                    {{ $actors->links() }}

                    </tbody>
                </table>

            </div>
        </div>


    </div>
@endsection
