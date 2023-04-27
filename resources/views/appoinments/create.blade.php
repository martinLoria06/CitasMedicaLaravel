<?php
    use Illuminate\Support\Str;
?>
@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Registar Nueva Cita</h3>
        </div>
        <div class="col text-right">
          <a href="{{route('pacientes.index')}}" class="btn btn-sm btn-success">
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
        <form action="{{route('pacientes.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Especialidad</label>
                <select name="" id="" class="form-control">
                    @foreach ($specialties as $especialidad)
                        <option value="{{$especialidad->id}}">{{$especialidad->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="email">Médicos</label>
                <select name="" id="" class="form-control"></select>
            </div>

            <div class="form-group">
                <label for="cedula">Fecha</label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input class="form-control datepicker"
                             placeholder="Seleccionar Fecha"
                             type="text" value="{{date('Y-m-d')}}"
                             data-date-format="yyyy-mm-dd"
                             data-date-start-date="{{date('Y-m-d')}}" data-date-end-date="+30d">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Hora de atención</label>
                <input type="text" name="address" id="address" class="form-control" value="{{old('address')}}">
            </div>

            <div class="form-group">
                <label for="phone">Tipo de consulta</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{old('phone')}}">
            </div>

            <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
@endsection
