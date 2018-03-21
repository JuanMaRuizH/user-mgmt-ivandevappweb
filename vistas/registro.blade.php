@extends('app') 
@section('title') Formulario registro
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
                    <form class="form-horizontal validate" method="POST" action="index.php">
                        <div class="form-group row">
                            <label for="inputIdentificador" class="col-sm-2 col-form-label">Identificador</label>
                            <div class="col-sm-10">
                                <input type="text" id="inputIdentificador" placeholder="Identificador" name="identificador" required 
                                value="{{ (isset($datos) && $datos['identificador'] ) ? $datos['identificador'] : "" }}" 
                                class="form-control col-sm-10 {{ isset($errores) ? (isset($errores['identificador']) ? "is-invalid " : "is-valid ") : " " }}" pattern="{{ $patrones['identificador']['regexp'] }}"
                                    title="{{ $patrones[ 'identificador'][ 'mensaje'] }}">
                                <div class="col-sm-10 invalid-feedback" id="error-for-inputNombre">{{ $patrones['identificador']['mensaje'] }}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" id="inputPassword" placeholder="Password" name="clave" required 
                                value="{{ (isset($datos) && $datos['clave'] ) ? $datos['clave'] : "" }}" 
                                class="form-control col-sm-10 {{ isset($errores) ? (isset($errores['clave']) ? " is-invalid" : "is-valid ") : " " }}" 
                                pattern="{{ $patrones['clave']['regexp'] }}" title="{{ $patrones['clave'][ 'mensaje'] }}">
                                <div class="col-sm-10 invalid-feedback" id="error-for-inputNombre">{{ $patrones['clave']['mensaje'] }}</div>
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
 
@section('script')
<script src="js/formvalidation.js"></script>
@endsection