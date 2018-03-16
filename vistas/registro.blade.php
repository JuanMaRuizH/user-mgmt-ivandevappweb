@extends('app')

@section('title')
Formulario registro
@endsection

@section('topright')
<a class="p-2" href="index.php?botonpetlogin">Login</a>
@endsection

@section('content')
<div class="container" style='margin-top: 50px'>  
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="panel panel-default">
                    @if (isset($error)) 
                    <div class="alert alert-danger" role="alert">Error alta usuario</div>
                    @endif
                <div class="panel-heading">Registro</div>
                <div class="panel-body mt-3">
                    <form class="form-horizontal" method="POST" action="index.php">
                        <div class="form-group row">
                            <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input id="inputNombre" type="text" value="{{ (isset($nombre) && $nombre) ? $nombre : "" }}"
                                       class="form-control col-sm-10 {{ (isset($nombre) && !$nombre) ? "is-invalid" : "is-valid" }}" 
                                       id="inputNombre" placeholder="Nombre" name="nombre">
                                <div class="col-sm-10 invalid-feedback">
                                    El nombre es obligatorio y tiene entre 3 y 25 chars
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ (isset($email) && $email ) ? $email : "" }}"
                                       class="form-control col-sm-10 {{ (isset($email) && !$email) ? "is-invalid" : "is-valid" }}" id="inputEmail" placeholder="Email" name="email">
                                <div class="col-sm-10 invalid-feedback">
                                    El email es obligatorio y/o no tiene el formato correcto
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" value="{{ (isset($clave) && $clave) ? $clave : "" }}"
                                       class="form-control col-sm-10 {{ (isset($clave) && !$clave) ? "is-invalid" : "is-valid" }}" id="inputPassword" placeholder="Password" name="clave">
                                <div class="col-sm-10 invalid-feedback">
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
                                <button type="submit" name="botonpetprocregistro" class="btn btn-primary">
                                    Registro
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

