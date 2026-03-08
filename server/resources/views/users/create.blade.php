@extends('layout.main')
<<<<<<< Updated upstream
=======

@section('title', 'Crear Usuario')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
<li class="breadcrumb-item"><a href="{{ route('users') }}">Usuarios</a></li>
<li class="breadcrumb-item active">Crear usuario</li>
@endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <i class="fas fa-user"></i> Crear Usuario
    </div>

    <div class="card-body">
        <form action="{{ route('auth.store') }}" method="POST">
            @csrf <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Rol</label>
                    <select name="role" class="form-control">
                        <option value="1">Administrador</option>
                        <option value="2">Vendedor</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Idioma</label>
                    <select name="language" class="form-control">
                        <option value="1">Español</option>
                        <option value="2">Inglés</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Usuario</button>
        </form>
    </div>
</div>
@endsection
>>>>>>> Stashed changes
