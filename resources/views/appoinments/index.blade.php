@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Mis citas</h3>
        </div>

      </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{session('success')}}
            </div>
        @endif
    </div>
    <div class="table-responsive">
      <!-- Projects table -->
      <table class="table align-items-center table-flush">
        <thead class="thead-light">
          <tr>
            <th scope="col">Description</th>
            <th scope="col">Especialidad</th>
            <th scope="col">Medico</th>
            <th scope="col">Fecha</th>
            <th scope="col">Hora</th>
            <th scope="col">Tipo</th>
            <th scope="col">Estado</th>
            <th scope="col">Opciones</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $cita)
                <tr>
                    <th scope="row">
                      {{$cita->description}}
                    </th>
                    <td>
                        {{$cita->specialty->name}}
                    </td>
                    <td>
                        {{$cita->doctor->name}}
                    </td>
                    <td>
                        {{$cita->scheduled_date}}
                    </td>
                    <td>
                        {{$cita->Schedule_Time_12}}
                    </td>
                    <td>
                        {{$cita->type}}
                    </td>
                    <td>
                        {{$cita->status}}
                    </td>
                    <td>
                        <form action="{{route('miscitas.index',[$cita->id])}}" method="POST">
                            @csrf
                            @method('DELETE')

                        <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                    </form>
                    </td>
              </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    {{-- <div class="card-body">
        {{$patients->links()}}
    </div> --}}
</div>
@endsection
