@extends('layouts.app')

@section('content')

    <a href="{{route('domains.create')}}" class="btn btn-primary">Add Domain</a>

    <br><br>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($domains as $domain)
                <tr>
                    <td>{{$domain->id}}</td>
                    <td>{{$domain->name}}</td>
                    <td class="table-centred">
                        <a href="domains/{{$domain->id}}/edit" role="button"><i class="fa fa-wrench fa-2x"></i></a>
                    </td>
                    <td class="table-centred">
                        <form action="domains/{{$domain->id}}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="submit" class="btn-delete"><i class="fa fa-close fa-2x"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

@endsection
