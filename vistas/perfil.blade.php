@extends('app')

@section('head')
<meta name="google-signin-client_id" content="308612886182-5gbmi9iqmsjnlaqlsrftk96d8nhmnj52.apps.googleusercontent.com">
@endsection

@section('topright')
<div class="d-flex dropdown p-2">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
            {{ $usuario->getNombre() }} 
        </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="index.php?botonpetperfil">Perfil</a>
        <a class="dropdown-item" href="index.php?botonpetlogout">Logout</a>
        <a class="dropdown-item" href="index.php?botonpetbaja">Baja</a>
    </div>
</div>
@endsection

@section('content')
<div class="container" style='margin-top: 50px'>  
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="panel panel-default">
                    @if (isset($error)) 
                    <div class="alert alert-danger" role="alert">Error cambio de perfil</div>
                    @endif
                <div class="panel-heading">Perfil</div>
                <div class="panel-body mt-3">
                    <form class="form-horizontal validate" method="POST" action="index.php">
                        <div class="form-group row">
                            <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input id="inputNombre" type="text" value="{{ $usuario->getNombre() }}"
                                       class="form-control col-sm-10 {{ isset($nombre) ? ((!$nombre) ? "is-invalid" : "is-valid") : "" }}" 
                                       id="inputNombre" placeholder="Nombre" name="nombre" required pattern="{{ $REGEXP_NOMBRE }}" 
                                       title="El nombre es obligatorio y tiene entre 3 y 25 caracteres">
                                <div class="col-sm-10 invalid-feedback" id="error-for-inputNombre">
                                    El nombre es obligatorio y tiene entre 3 y 25 caracteres
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $usuario->getEmail() }}"
                                       class="form-control col-sm-10 {{ isset($email) ? ((!$email) ? "is-invalid" : "is-valid") : "" }}" id="inputEmail" placeholder="Email" 
                                       name="email" required>
                                <div class="col-sm-10 invalid-feedback" id="error-for-inputEmail">
                                    El email es obligatorio y/o no tiene el formato correcto
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" value="{{ $usuario->getClave() }}"
                                       class="form-control col-sm-10 {{ isset($clave) ? ((!$clave) ? "is-invalid" : "is-valid") : "" }}" id="inputPassword" placeholder="Password" 
                                       name="clave" required pattern="{{ $REGEXP_CLAVE }}" 
                                       title="La clave tiene entre 4 y 8 caracteres e incluye al menos un número">
                                <div class="col-sm-10 invalid-feedback" id="error-for-inputClave">
                                    La clave tiene entre 4 y 8 caracteres e incluye al menos un número
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPintor" class="col-sm-2 col-form-label">Pintor</label>
                            <div class="col-sm-10">
                                <select class="custom-select" name="pintor">
                                    @foreach ($pintores as $pintor)
                                    <option value="{{ $pintor->getNombre() }}">{{ $pintor->getNombre() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" name="botonpetprocperfil" class="btn btn-primary">
                                    Modificar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="js/formvalidation.js"></script>  
@endsection
