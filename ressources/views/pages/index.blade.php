@extends('layouts.app')

@section('content')
    Hello World Page rendered at {{ date('Y-m-d H:i:s') }}
    <br>
    <br>Variable toto = {{ $toto }}
@stop
