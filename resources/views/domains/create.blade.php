@extends('layouts.app')

@section('content')

<div class="form">

    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <form method="post" action="{{route('domains.store')}}">
                {!! csrf_field() !!}
                <div class="panel panel-default">
                    <div class="panel-heading"><h2>Add Bad Domain</h2></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                                <span class="help-block">{{$errors->has('name') ? $errors->first('name') : ''}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Add</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection