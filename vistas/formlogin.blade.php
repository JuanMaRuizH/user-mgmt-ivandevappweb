@extends('app')

@section('title')
Formulario login
@endsection

@section('topright')
<a class="p-2" href="index.php?botonpetregistro">Registro</a>
@endsection

@section('content')

<div class="row justify-content-center" style='margin-top: 50px'>
    <div class="col-md-8">
        <div class="panel panel-default">
            @if (isset($error)) 
            <div class="alert alert-danger" role="alert">Error Credenciales</div>
            @endif
            <div class="panel-heading">Login</div>
            <div class="panel-body mt-3">
                <form class="form-horizontal" method="POST" action="index.php" id='formlogin'>
                    <div class="form-group row">                            
                        <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input id="inputNombre" type="text" value="{{ (isset($nombre) ) ? $nombre : "" }}"
                                   class="{{ (isset($nombre) && !$nombre) ? "form-control is-invalid col-sm-10" : "form-control col-sm-10" }}" 
                                   id="inputNombre" placeholder="Nombre" name="nombre">
                            <div class="col-sm-10 invalid-feedback">
                                El nombre es obligatorio y tiene entre 3 y 25 caracteres
                            </div>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" value="{{ (isset($clave) ) ? $clave : "" }}"
                                   class="{{ (isset($clave) && !$clave) ? "form-control is-invalid col-sm-10" : "form-control col-sm-10" }}" id="inputPassword" placeholder="Password" name="clave">
                            <div class="col-sm-10 invalid-feedback">
                                La clave tiene entre 4 y 8 caracteres e incluye al menos un número
                            </div>
                        </div>        
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary" name="botonpetproclogin">
                                Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section ('script')
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('formlogin');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endsection