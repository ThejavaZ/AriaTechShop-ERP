@extends('layout.main')

@section('title', 'Crear Usuario')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
<li class="breadcrumb-item"><a href="{{ route('users') }}">Usuarios</a></li>
<li class="breadcrumb-item active">Crear usuario</li>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <i class="fas fa-user"></i>
        Crear Usuario
    </div>

    <div class="card-body">
        <form action="">
            <fieldset>
                <label for="" class="form form-text">Nombre</label>
                <input type="text" class="form-control">
            </fieldset>

        <fieldset>
                <label for="" class="form form-text">Contraseña</label>
                <input type="text" class="form-control">
            </fieldset>
        </form>

    </div>
</div>
@endsection
