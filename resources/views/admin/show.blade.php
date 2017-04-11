@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-xs-12">
                <div class="page-header">
                    <h1>
                        Admin pannel
                    </h1>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <div class="list-group">
                    <a href="{{ route('OpenDataFile.index') }}" class="list-group-item">@lang('open_data_file.open_data_files')</a></li>
                </div>
            </div>
        </div>









    </div>
@endsection
