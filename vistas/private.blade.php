@extends('app')

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

<div class="d-flex justify-content-center mt-4">
    Bienvenido {{ $usuario->getIdentificador() }} !!
</div>
<div class="d-flex justify-content-center mt-4">   
    <img style="flex: 1; object-fit: scale-down; height:300px" class="col-md-8 rounded" src= '{{ "img/".$cuadro->getImagen() }}'/>   
</div>
@endsection
