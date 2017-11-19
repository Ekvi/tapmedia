@extends('layouts.app')

@section('content')

    <div class="btn-group">
        <a href="click?param1=param1&param2=param2" class="btn btn-default">Btn 1</a>
        <a href="click?param1=param1_new&param2=param2_new" class="btn btn-default">Btn 2</a>
        <a href="click?param1=another param&param2=another_param" class="btn btn-default">Btn 3</a>
    </div>

    <br><br>

    <click-panel></click-panel>

@endsection