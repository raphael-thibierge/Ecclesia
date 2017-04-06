@extends('layouts.app')

@section('content')
    <div class="container">



        <div class="row">
            <div class="col-xs-12">
                <div class="jumbotron">
                    </h1><h1>
                        {{ $actor->first_name }} {{ $actor->last_name }}
                    </h1>
                    <p>@lang('basics.gender') :  @lang('basics.' . $actor->gender)</p>
                    <p>@lang('basics.birth_date') : {{ $actor->birth_date  }}</p>

                    @if ($actor->death_date != null)
                        <p>@lang('basics.death_date') : {{ $actor->death_date  }}</p>
                    @endif

                    @if ($actor->birth_city != null)
                        <p>@lang('basics.birth_city') : {{ $actor->birth_city  }}</p>
                    @endif

                    @if ($actor->birth_department != null)
                        <p>@lang('basics.birth_department') : {{ $actor->birth_department  }}</p>
                    @endif

                    @if ($actor->birth_country != null)
                        <p>@lang('basics.birth_country') : {{ $actor->birth_country  }}</p>
                    @endif

                </div>
            </div>
        </div>



        @forelse($actor->mandates as $mandate)

            @if ($loop->first)
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            @endif


                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading{{ $mandate->id }}">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $mandate->id }}" aria-expanded="false" aria-controls="collapse{{ $mandate->id }}">
                                {{ $mandate->quality }} {{ $mandate->organ_type }}
                            </a>
                        </h4>
                    </div>
                    <div id="collapse{{ $mandate->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $mandate->id }}">
                        <div class="panel-body">

                            <p>@lang('basics.start_date') : {{ $mandate->start_date }} </p>
                            <p>@lang('actor.taking_office_date') : {{ $mandate->taking_office_date }} </p>
                            <p>@lang('basics.end_date') : {{ $mandate->end_date }} </p>

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
