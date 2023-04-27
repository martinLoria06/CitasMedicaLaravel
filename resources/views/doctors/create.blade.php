<?php
    use Illuminate\Support\Str;
?>
@extends('layouts.panel')

@section('styles')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Nuevo Medico</h3>
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
        <form action="{{route('medicos.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre del médico</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" required>
            </div>

            <div class="form-group">
                <label for="specialties">Especialidades</label>
                <select name="specialties[]" id="specialties"
                        class="form-control selectpicker"
                        multiple
                        data-style="btn-primary"
                        title="Seleccionar Especialidades" required>
                        @foreach ($specialties as $especialidad)
                            <option value="{{$especialidad->id}}">{{$especialidad->name}}</option>
                        @endforeach
                    </select>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
            </div>

            <div class="form-group">
                <label for="cedula">Cédula</label>
                <input type="text" name="cedula" id="cedula" class="form-control" value="{{old('cedula')}}">
            </div>

            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" name="address" id="address" class="form-control" value="{{old('address')}}">
            </div>

            <div class="form-group">
                <label for="phone">Teléfono / Móvil</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{old('phone')}}">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="text" name="password" id="password" class="form-control" value="{{old('password', Str::random(8))}}">
            </div>

            <button type="submit" class="btn btn-sm btn-primary">Crear Medico</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
