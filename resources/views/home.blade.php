@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header"><h2>{{ __('Dashboard') }}</h2></div>

                    <div class="body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="tabla"
                                   class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable">
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
                                @foreach($conversations as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->type}}<br>{{$item->subtype}}</td>
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
                                            @if($item->status != 'FINALIZADO')
                                                <a href="{{route('conversation.finalizar',$item->id)}}"
                                                   class="btn btn-info waves-effect btn-xs" data-toggle="tooltip"
                                                   data-placement="top" title="Cambiar de estado"><i
                                                        class="material-icons">check_box</i>
                                                    Finalizar</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tabla').DataTable();
        });
    </script>
@endsection
