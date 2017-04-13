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
                    <p>@lang('basics.birth_date') : {{ $actor->birth_date->format('d-m-Y')  }}</p>

                    @if ($actor->death_date != null)
                        <p>@lang('basics.death_date') : {{ $actor->death_date->format('d-m-Y')  }}</p>
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


        <div class="row">
            <div class="col-xs-12">
                <h2>Derniers votes</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="list-group">
                    @forelse($actor->ballots as $ballot)
                        <div class="list-group-item list-group-item-{{ $ballot->decision == 'pour' ? 'success' : ($ballot->decision == 'contre' ? 'danger' : 'warning')  }}">
                            {{ $ballot->vote->date->format('d-m-Y')}} : {{ $ballot->decision}} : {{ $ballot->vote->title}}
                        </div>
                    @empty
                        <div class="list-group-item list-group-item-info">Pas de vote</div>
                    @endforelse

                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <h2>Mandats</h2>
            </div>
        </div>


        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <script type="text/javascript">
            google.charts.load("current", {packages:["timeline"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {

                var container = document.getElementById('mandate-timeline');
                var chart = new google.visualization.Timeline(container);
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn({ type: 'string', id: 'Position' });
                dataTable.addColumn({ type: 'string', id: 'Name' });
                dataTable.addColumn({ type: 'date', id: 'Start' });
                dataTable.addColumn({ type: 'date', id: 'End' });


                dataTable.addRows([
                    @foreach($actor->mandates as $mandate)
                    [ "{!! ucfirst(str_replace("\n", '', $mandate->organ->title)) !!}", "{{ ucfirst($mandate->quality) }}", new Date("{{ $mandate->start_date }}"), new Date("{{ $mandate->end_date != null ? $mandate->end_date  : \Carbon\Carbon::today()}}") ],
                    @endforeach
                ]);

                chart.draw(dataTable);
            }
        </script>

        <div id="mandate-timeline" style="height: 500px;"></div>

        <div class="row">
            <div class="col-xs-12">
                <h2>Documents législatifs</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="list-group">
                    @forelse($actor->legislative_documents as $legislative_document)
                        <div class="list-group-item">
                            <h4 class="list-group-item-heading">
                                {{  ucfirst($legislative_document->title) }}
                            </h4>
                            @if ($legislative_document->adoptionStatus != null)
                                <p class="list-group-item-text">{{ ucfirst($legislative_document->adoptionStatus) }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="list-group-item list-group-item-info">Pas de vote</div>
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
                    @forelse($actor->amendments_as_author as $amendment)
                        <a class="list-group-item" href="{{ route('amendment.show', ['amendment' => $amendment]) }}">
                            <h4 class="list-group-item-heading">
                                {{  ucfirst($amendment->text_fragment_pointer_title) }}
                            </h4>

                            @if($amendment->legislative_document != null)
                            <p class="list-group-item-text">
                                {{ ucfirst($amendment->legislative_document->title) }}
                            </p>
                            @endif
                        </a>
                    @empty
                        <div class="list-group-item list-group-item-info">Pas d'amendements</div>
                    @endforelse

                </div>
            </div>
        </div>

    </div>
@endsection
