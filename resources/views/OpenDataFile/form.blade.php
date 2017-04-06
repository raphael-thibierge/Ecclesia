@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if (isset ($file))
                            @lang('open_data_file.edit-file')
                        @else
                            @lang('open_data_file.add-file')
                        @endif
                    </div>
                    <div class="panel-body">

                        @if (isset ($file))
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('OpenDataFile.update', ['OpenDataFile' => $file]) }}">
                                {{ method_field('PATCH') }}
                        @else
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('OpenDataFile.store') }}">
                        @endif
                            {{ csrf_field() }}

                            {{-- NAME--}}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">{{ ucfirst(__('validation.attributes.name')) }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ isset($file) ? $file->name : old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            {{-- URL --}}
                            <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                                <label for="url" class="col-md-4 control-label">URL</label>

                                <div class="col-md-6">
                                    <input id="url" type="text" class="form-control" name="url" value="{{ isset($file) ? $file->url : old('url') }}" required>

                                    @if ($errors->has('url'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('url') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">{{ ucfirst(__('validation.attributes.description')) }}</label>

                                <div class="col-md-6">
                                    <input id="description" type="text" class="form-control" name="description" value="{{ isset($file) ? $file->description : old('description') }}" required>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        @if (isset ($file))
                                            Save
                                        @else
                                            Add
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection