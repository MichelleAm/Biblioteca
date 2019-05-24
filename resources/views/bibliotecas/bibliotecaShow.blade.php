@extends('layouts.tabler')
@section('contenido')

<div class="page-header">
    <div class="page-title">
        SHOW BIBLIOTECA
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Bienvenido al sistema compañero trabajador!</h3>
            </div>

            <div class="card-body">
                <table class="table table-hover table-dark" >

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th> 
                            <th>Hora de Apertura</th> 
                            <th>Hora de Cierre</th> 
                            <th>Días</th> 
                            <th>Teléfono</th> 
                            <th>Página Web</th> 
                            <th>Facebook</th> 
                            <th>Correo Electrónico</th>
                            @if(\Auth::user())<th>Acciones</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>{{ $biblioteca->id }}</td>
                                <td>{{ $biblioteca->nombre }}</td>
                                <td>{{ $biblioteca->horaApertura }}</td>
                                <td>{{ $biblioteca->horaCierre }}</td>
                                <td>{{ $biblioteca->dias }}</td>
                                <td>{{ $biblioteca->telefono }}</td>
                                <td>{{ $biblioteca->paginaWeb }}</td>
                                <td>{{ $biblioteca->facebook }}</td>
                                <td>{{ $biblioteca->email }}</td>
                                <td>
                                    @if(\Auth::user() !== null && (Gate::check('permisos_admin') || (\Auth::user()->biblioteca_id == $biblioteca_id)))
                                            <a href="{{ route('bibliotecas.edit', $biblioteca->id) }}" class="btn btn-sm btn-warning">
                                                Editar
                                            </a>
                                        @can('permisos_admin')
                                            <form action="{{ route('bibliotecas.destroy', $biblioteca->id) }}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE"> 
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Borrar
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection