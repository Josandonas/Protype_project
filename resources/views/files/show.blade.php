@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Mostrar Arquivos</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('files.index') }}"> Voltar</a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>Ação
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Arquivo:</strong>
                {{ $path->file_path }}
            </div>
        </div>
    </div>
@endsection
