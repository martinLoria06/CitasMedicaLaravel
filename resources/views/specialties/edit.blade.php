@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Editar Especialidad</h3>
        </div>
        <div class="col text-right">
          <a href="{{route('especialidades.index')}}" class="btn btn-sm btn-success">
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
        <form action="{{route('especialidades.update',[$specialty->id])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombre de la especialidad</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name',$specialty->name)}}" required>
            </div>
            <div class="form-group">
                <label for="description">Descripcion</label>
                <input type="text" name="description" id="description" class="form-control" value="{{old('description',$specialty->description)}}">
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Guardar Especialidad</button>
        </form>
    </div>
</div>
@endsection
