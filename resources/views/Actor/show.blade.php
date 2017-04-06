@extends('layouts.app')

@section('content')
    <div class="container">



        <div class="row">
            <div class="col-xs-12">
                <div class="jumbotron">
                    </h1><h1>
                        {{ $actor->first_name }} {{ $actor->last_name }}
                    </h1>
                    <p>Gender : {{ $actor->gender  }}</p>
                    <p>Birth date : {{ $actor->birth_date  }}</p>

                    @if ($actor->death_date != null)
                        <p>Birth date : {{ $actor->death_date  }}</p>
                    @endif

                    @if ($actor->birth_city != null)
                        <p>Birth city : {{ $actor->birth_city  }}</p>
                    @endif

                    @if ($actor->birth_department != null)
                        <p>Birth department : {{ $actor->birth_department  }}</p>
                    @endif

                    @if ($actor->birth_country != null)
                        <p>Birth country : {{ $actor->birth_country  }}</p>
                    @endif

                </div>
            </div>
        </div>



        @forelse($actor->mandates as $mandate)

            @if ($loop->first)
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            @endif


                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                {{ $mandate->quality }} {{ $mandate->organ_type }}
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">

                            <p>Start date : {{ $mandate->start_date }} </p>
                            <p>Taking Office Date : {{ $mandate->taking_office_date }} </p>
                            <p>End date : {{ $mandate->start_date }} </p>

                        </div>
                    </div>
                </div>


            @if($loop->last)
                </div>
            @endif
        @empty
            <div class="alert alert-info">
                No mandate for this actor.
            </div>


        @endforelse




    </div>
@endsection
