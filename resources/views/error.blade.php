@extends('layouts.master')

@section('content')
<div class="alert alert-danger">
    <p>Désolé une erreur technique empêche le bon fonctionnement du site !</p>

    @if (is_a($exception, '\App\Exceptions\UserException'))
        <p>{{ $exception->getUserMessage() }}</p>
    @endif

    <p>Veuillez réessayer plus tard...</p>

    @if (env('APP_DEBUG') && isset($exception))
        <hr>
        <p><b>Type : </b>{{ get_class($exception) }}</p>
        <p><b>Message : </b>{{ $exception->getMessage() }}</p>
        <p><b>Code : </b>{{ $exception->getCode() }}</p>
        <p><b>File : </b>{{ $exception->getFile() }}</p>
        <p><b>Line : </b>{{ $exception->getLine() }}</p>
    @endif
</div>
@endsection
