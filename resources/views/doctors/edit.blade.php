<?php
    use Illuminate\Support\Str;
?>
@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Editar Medico</h3>
        </div>
        <div class="col text-right">
          <a href="{{route('medicos.index')}}" class="btn btn-sm btn-success">
            <i class="fas fa-chevron-left"></i>
            Regresar</a>
        </div>
      </div>
    </div>
    <div class="card-body">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Por favor!!</strong> {{$error}}
                </div>
            @endforeach
        @endif
        <form action="{{route('medicos.update', [$doctor->id])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombre del médico</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name',$doctor->name)}}" required>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control" value="{{old('email',$doctor->email)}}">
            </div>

            <div class="form-group">
                <label for="cedula">Cédula</label>
                <input type="text" name="cedula" id="cedula" class="form-control" value="{{old('cedula',$doctor->cedula)}}">
            </div>

            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" name="address" id="address" class="form-control" value="{{old('address',$doctor->address)}}">
            </div>

            <div class="form-group">
                <label for="phone">Teléfono / Móvil</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{old('phone',$doctor->phone)}}">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="text" name="password" id="password" class="form-control">
                <small class="text-warning">Solo rellena el campo si desea cambiar de contraseña</small>
            </div>

            <button type="submit" class="btn btn-sm btn-primary">Guardar Cambios</button>
        </form>
    </div>
</div>
@endsection
