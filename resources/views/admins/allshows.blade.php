@extends('layouts.admin')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('delete'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('delete') }}
        </div>
    @endif
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 d-inline">Shows</h5>
                    <a href="{{ route('shows.create') }}" class="btn btn-primary mb-4 text-center float-right">Create
                        Shows</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">title</th>
                                <th scope="col">image</th>
                                <th scope="col">type</th>
                                <th scope="col">date_aired</th>
                                <th scope="col">status</th>
                                <th scope="col">genre</th>
                                <th scope="col">created_at</th>
                                <th scope="col">delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allShows as $show)
                                <tr>
                                    <th scope="row">{{ $show->id }}</th>
                                    <td>{{ $show->name }}</td>
                                    <td><img src="{{ asset('assets/' . $show->image) }}" width="100px"></td>
                                    <td>{{ $show->type }}</td>
                                    <td>{{ $show->date_aired }}</td>
                                    <td>{{ $show->status }}</td>
                                    <td>{{ $show->genre }}</td>
                                    <td>{{ $show->created_at }}</td>
                                    <td><a href="{{route('shows.delete', $show->id)}}" class="btn btn-danger  text-center ">delete</a></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
