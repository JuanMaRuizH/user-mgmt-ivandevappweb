@extends('app')

@section('content')

<div class="d-flex justify-content-center mt-4">
    Bienvenido {{ $auth->loggedUsuario()->getNombre() }} !!
</div>
<div class="d-flex justify-content-center mt-4">   
    <img style="flex: 1; object-fit: scale-down; height:300px" class="col-md-8 rounded" src= '{{ "img/".$cuadro->getImagen() }}'/>   
</div>
@endsection
