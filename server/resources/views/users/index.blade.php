@extends('layout.main')

@section('title', 'Usuarios')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
<li class="breadcrumb-item active">Usuarios</li>
@endsection

@section('content')

<div class="d-flex justify-between mb-4">
    <a href="" class="btn btn-lg btn-outline-danger">
        <i class="fas fa-file-pdf"></i>
    </a>
    <a href="" class="btn btn-lg btn-outline-primary">
        <i class="fas fa-file-word"></i>
    </a>
    <a href="" class="btn btn-lg btn-outline-success">
        <i class="fas fa-file-excel"></i>
    </a>
    <a href="{{ route('users.create') }}" class="btn btn-lg btn-outline-warning">
        <i class="fas fa-plus"></i>
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-users me-1"></i>
        Usuarios
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Cambiar contraseña</th>
                    <th>Verificado</th>
                    <th>Rol</th>
                    <th>Idioma</th>
                    <th>Creado</th>
                    <th>Creado Hace</th>
                    <th>Actualizado</th>
                    <th>Actualizado Hace</th>
                    <th>Acciones</th>
                    <th>Reportes</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Cambiar contraseña</th>
                    <th>Acciones</th>
                    <th>Acciones</th>
                    <th>Acciones</th>
                    <th>Creado Hace</th>
                    <th>Actualizado</th>
                    <th>Actualizado Hace</th>
                    <th>Acciones</th>
                    <th>Reportes</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $user->name ?? "sin info" }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="" class="btn btn-outline-dark btn-lg">
                                <i class="fas fa-lock"></i>
                            </a>
                        </td>
                        <td>{{ $user->email_verified_at }}</td>
                        <td>
                            @switch($user->role)
                                @case(1)
                                    Administrador
                                    @break
                                @case(2)
                                    Operador
                                    @break
                                @default
                                    No Info
                            @endswitch
                        </td>
                        <td>
                            @switch($user->language)
                                @case(1)
                                    Español
                                    @break
                                @case(2)
                                    Inglés
                                    @break
                                @default
                                    No Info
                            @endswitch
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                        <td>{{ $user->updated_at->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $user->updated_at->diffForHumans() }}</td>

                        <td>
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-lg btn-outline-info">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="" class="btn btn-lg btn-outline-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="" class="btn btn-lg btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                        <td>
                            <a href="" class="btn btn-lg btn-outline-danger">
                                <i class="fas fa-file-pdf"></i>
                            </a>

                            <a href="" class="btn btn-lg btn-outline-primary">
                                <i class="fas fa-file-word"></i>
                            </a>

                            <a href="" class="btn btn-lg btn-outline-success">
                                <i class="fas fa-file-excel"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection
