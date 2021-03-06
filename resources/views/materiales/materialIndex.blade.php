@extends('layouts.tabler')
@section('contenido')

<div class="page-header">
    <div class="page-title">
    @if(isset($biblioteca_id))
            <h3>BIBLIOTECA - <a class="enlace_no_fondo" href="{{ route('bibliotecas.show', [$biblioteca_id]) }}">{{ $biblioteca_id->nombre }}</a></h3>
        @else
            <h3>COLECCION GENERAL DE LIBROS</h3>
        @endif
    </div>

    <div class="col-lg-3 ml-auto">
        @if(!isset($biblioteca_id))
            <form action = " {{ route('materiales.index') }}" class="input-icon my-3 my-lg-0" method="POST">
        @else
            <form action = " {{ route('bibliotecas.materiales.index', $biblioteca_id) }}" class="input-icon my-3 my-lg-0" method="POST">
        @endif
            @csrf
            <input type="search" class="form-control header-search" placeholder="Search&hellip;" tabindex="1" name="buscar">
            <div class="input-icon-addon">
            <i class="fe fe-search"></i>
            </div>
        </form>
    </div>
</div>

@include('extra.mensajes')  

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Bienvenido al sistema</h3>
                @if(\Auth::user() !== null)
                    <div class="ml-auto">
                        @if(!isset($biblioteca_id) && Gate::check('permisos_admin') )
                            <form class="input-icon my-3 my-lg-0" action="{{ route('materiales.create') }}">
                        @elseif(isset($biblioteca_id) && (Gate::check('permisos_admin') || Gate::check('es_trabajador', $biblioteca_id->id)))
                            <form class="input-icon my-3 my-lg-0" action="{{ route('bibliotecas.materiales.create', $biblioteca_id) }}">
                        @endif
                                <button type="submit" class="btn btn-green">Registrar Material <i class="fe fe-share"></i></button>
                            </form>
                    </div>
                @endif
            </div>

            <div class="card-body">
                <table class="table table-hover table-dark" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Sección</th>
                            <th>Autor</th>
                            <th>Ejemplares</th>
                            @if(\Auth::user() !== null)<th>Acciones</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materiales as $material)
                            <tr>
                                <td>
                                    <a class= "a-ESE-ENLACE-ES-MIO" href="{{ route('bibliotecas.materiales.show', [$material->biblioteca_id, $material->id]) }}">{{ $material->id }}</a>
                                </td>
                                <td>{{ $material->nombre }}</td>
                                <td>{{ $material->seccion }}</td>
                                <td>{{ $material->autor }}</td>
                                <td>
                                    @if(count($material->ejemplares))
                                        @foreach($material->ejemplares as $ejemplar)
                                            <ul class="nav nav-tabs border-0">
                                                <li class="nav-item a-ESE-ENLACE-ES-MIO">{{ ($ejemplar->numEjemp)? $ejemplar->numEjemp : $ejemplar->id }} - {{ $ejemplar->nombre }} {{ ($ejemplar->estado)? 'Disponible' : 'Ocupado' }}</li>
                                            </ul>
                                        @endforeach
                                    @else
                                        <h6>No hay ejemplares<h6>
                                    @endif
                                </td>
                                @if(\Auth::user() !== null && (Gate::check('permisos_admin') || Gate::check('es_trabajador', $biblioteca_id->id)))
                                    <td>
                                        <a href="{{ route('bibliotecas.materiales.edit', [$material->biblioteca_id, $material->id]) }}" class="btn btn-sm btn-warning"><i class="fe fe-edit-3"></i>Editar</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                 </table>
            </div>
            <div class="col-lg-3 ml-auto">
                {{ $materiales->links() }}
            </div>
        </div>
    </div>
</div>

@endsection