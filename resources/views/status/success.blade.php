@extends('layouts.app')

@section('content')

    <div class="panel panel-success">
        <div class="panel-heading">Переданые данные</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Значение</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>id</td>
                        <td>{{$click->id}}</td>
                    </tr>
                    <tr>
                        <td>ip</td>
                        <td>{{$click->ip}}</td>
                    </tr>
                    <tr>
                        <td>user agent</td>
                        <td>{{$click->ua}}</td>
                    </tr>
                    <tr>
                        <td>referer</td>
                        <td>{{$click->ref}}</td>
                    </tr>
                    <tr>
                        <td>param1</td>
                        <td>{{$click->param1}}</td>
                    </tr>
                    <tr>
                        <td>param2</td>
                        <td>{{$click->param2}}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-footer"></div>
    </div>

@endsection

