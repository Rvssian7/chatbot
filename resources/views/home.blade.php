@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-responsive table-hover col-md-12">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>TIPO</th>
                                <th>DATOS</th>
                                <th>ESTADO</th>
                                <th>CREADO</th>
                                <th>ACCIONES</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @foreach($conversations as $item)
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->type}}</td>
                                    <td>
                                        <ul>
                                            @if($item->data !== null)
                                                @foreach($item->data as $key => $value)
                                                    <li><strong>{{$key}}:</strong> {{$value}}</li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </td>
                                    <td>{{$item->status}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <a href="#" class="btn btn-success" title="Cambiar de stado">Change</a>
                                    </td>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
