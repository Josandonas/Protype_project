@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Arquivos</h2>
            </div>
            <div class="pull-right">
                @can('file-create')
                <a class="btn btn-success" href="{{ route('files.create') }}"> Criar novo arquivo</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Arquivo</th>
            <th width="280px">Ação</th>
        </tr>
	    @foreach ($files as $file)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $file->name }}</td>
	        <td>{{ $file->file_path }}</td>
	        <td>
                <form action="{{ route('files.destroy',$file->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('files.show',$file->id) }}">Show</a>
                    @can('file-edit')
                    <a class="btn btn-primary" href="{{ route('files.edit',$file->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('file-delete')
                    <button type="submit" class="btn btn-danger">Apagar</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $products->links() !!}

@endsection
