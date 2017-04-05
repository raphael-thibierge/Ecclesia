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
            <h1>Open Data Files <small><a href="{{ route('OpenDataFile.create') }}" class="btn btn-success">New</a></small></h1>
        </div>


        <div class="row">
            <div class="col-xs-12">

                <table class="table table-bordered table-hover">


                    <thead>
                        <td>Name</td>
                        <td>Description</td>
                        <td>URL</td>
                        <td></td>
                    </thead>

                    <tbody>

                    @forelse($files as $file)

                        <tr>
                            <td>{{ $file->name }}</td>
                            <td>{{ $file->description }}</td>
                            <td>{{ $file->url }}</td>
                            <td>

                                <a href="{{ route('OpenDataFile.edit', ['OpenDataFile' => $file]) }}" class="btn btn-xs btn-default">
                                    Edit
                                </a>

                                <form action="{{ route('OpenDataFile.destroy', ['OpenDataFile' => $file]) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-xs btn-danger" type="submit">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr class="warning">
                            <td colspan="3" class="text-center">No file.</td>
                        </tr>

                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>


    </div>
@endsection
