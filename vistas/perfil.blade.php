@extends('app') 
@section('head')
<meta name="google-signin-client_id" content="308612886182-5gbmi9iqmsjnlaqlsrftk96d8nhmnj52.apps.googleusercontent.com">
@endsection
 
@section('topright')
<div class="d-flex dropdown p-2">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
            {{ $usuario->getIdentificador() }} 
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
                            <label for="inputIdentificador" class="col-sm-2 col-form-label">Identificador</label>
                            <div class="col-sm-10">
                                <input type="text" id="inputIdentificador" placeholder="Identificador" name="identificador"  required
                                value="{{ $usuario->getIdentificador() }}" 
                                class="form-control col-sm-10 {{ isset($errores) ? (isset($errores['identificador']) ? "is-invalid " : "is-valid ") : " " }}"
                                    pattern="{{ $patrones['identificador']['regexp'] }}" title="{{ $patrones['identificador']['mensaje'] }}">
                                <div class="col-sm-10 invalid-feedback" id="error-for-inputIdentificador">{{ $patrones['identificador']['mensaje'] }}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" id="inputNombre" placeholder="Nombre" name="nombre" 
                                value="{{ $usuario->getNombre() }}" 
                                class="form-control col-sm-10 {{ isset($errores) ? (isset($errores['nombre']) ? "is-invalid " : "is-valid ") : " " }}"
                                    pattern="{{ $patrones['nombre']['regexp'] }}" title="{{ $patrones['nombre']['mensaje'] }}">
                                <div class="col-sm-10 invalid-feedback" id="error-for-inputNombre">{{ $patrones['nombre']['mensaje'] }}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputApellidos" class="col-sm-2 col-form-label">Apellidos</label>
                            <div class="col-sm-10">
                                <input type="text" id="inputApellidos" placeholder="Apellidos" name="apellidos" 
                                value="{{ $usuario->getApellidos() }}" 
                                class="form-control col-sm-10 {{ isset($errores) ? (isset($errores['apellidos']) ? "is-invalid " : "is-valid ") : " " }}"
                                    pattern="{{ $patrones['apellidos']['regexp'] }}" title="{{ $patrones['apellidos']['mensaje'] }}">
                                <div class="col-sm-10 invalid-feedback" id="error-for-inputApellidos">{{ $patrones['apellidos']['mensaje'] }}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" value="{{ $usuario->getEmail() }}" 
                                class="form-control col-sm-10 {{ isset($email) ? ((!$email) ? " is-invalid" : "is-valid ") : " " }}" id="inputEmail" placeholder="Email" name="email" required>
                                <div class="col-sm-10 invalid-feedback" id="error-for-inputEmail">{{ $patrones['email']['mensaje'] }}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputOcupacion" class="col-sm-2 col-form-label">Ocupación</label>
                            <div class="col-sm-10">
                                <input type="text" id="inputOcupacion" placeholder="Ocupacion" name="ocupacion" 
                                value="{{ $usuario->getOcupacion() }}" 
                                class="form-control col-sm-10 {{ isset($errores) ? (isset($errores['ocupacion']) ? "is-invalid " : "is-valid ") : " " }}"
                                    pattern="{{ $patrones['ocupacion']['regexp'] }}" title="{{ $patrones['ocupacion']['mensaje'] }}">
                                <div class="col-sm-10 invalid-feedback" id="error-for-inputOcupacion">{{ $patrones['ocupacion']['mensaje'] }}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputGenero" class="col-sm-2 col-form-label">Género</label>
                            <div class="col-sm-10">
                                <select class="form-control col-sm-10" id="inputGenero" name="genero">
                                            <option {{ !$usuario->getOcupacion() ? "selected": "" }}>Selecciona una opción</option>
                                            <option {{ $usuario->getOcupacion() === 'M' ? "selected": "" }} value="M">M</option>
                                            <option {{ $usuario->getOcupacion() === 'H' ? "selected": "" }} value="H">H</option>
                                          </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputOcupacion" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" id="inputClave" placeholder="Password" name="clave" 
                                value="{{ $usuario->getClave() }}" 
                                class="form-control col-sm-10 {{ isset($errores) ? (isset($errores['clave']) ? "is-invalid " : "is-valid ") : " " }}"
                                    pattern="{{ $patrones['clave']['regexp'] }}" title="{{ $patrones['clave']['mensaje'] }}">
                                <div class="col-sm-10 invalid-feedback" id="error-for-inputClave">{{ $patrones['clave']['mensaje'] }}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPintor" class="col-sm-2 col-form-label">Pintor</label>
                            <div class="col-sm-10">
                                <select class="custom-select col-sm-10" name="pintor">
                                    @foreach ($pintores as $pintor)
                                    <option value="{{ $pintor->getNombre() }}">{{ $pintor->getNombre() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <button type="submit" name="botonpetprocperfil" class="btn btn-primary">
                                    Modificar
                                </button>
                            </div>
                            <div class="col">
                                <a onclick="signIn();" class="btn btn-primary">
                                    Rellenar con Google+
                                </a>
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
<script src="js/fillprofile.js"></script>
<script async defer src="https://apis.google.com/js/client:platform.js?onload=startApp"></script>
@endsection