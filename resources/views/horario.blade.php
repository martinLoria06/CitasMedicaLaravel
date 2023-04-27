@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Gestinar Horario</h3>
        </div>
        <div class="col text-right">
          <a href="" class="btn btn-sm btn-primary">Guardar Cambios</a>
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
            <th scope="col">Dia</th>
            <th scope="col">Activo</th>
            <th scope="col">Turno Mañana</th>
            <th scope="col">Turno Tarde</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($days as $day)
                <tr>
                    <th>{{$day}}</th>
                    <td>
                        <label class="custom-toggle">
                            <input type="checkbox" checked>
                            <span class="custom-toggle-slider rounded-circle"></span>
                        </label>
                    </td>

                    <td>
                        <div class="row">
                            <div class="col">
                                <select name="" id="" class="form-control">
                                        @for ($i = 8; $i <= 11; $i++)
                                            <option value=""> {{$i}}:00 AM</option>
                                            <option value=""> {{$i}}:30 AM</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col">
                                <select name="" id="" class="form-control">
                                        @for ($i = 8; $i <= 11; $i++)
                                            <option value=""> {{$i}}:00 AM</option>
                                            <option value=""> {{$i}}:30 AM</option>
                                        @endfor
                                </select>
                            </div>

                    </td>

                    <td>
                        <div class="row">
                            <div class="col">
                                <select name="" id="" class="form-control">
                                        @for ($i = 2; $i <= 11; $i++)
                                            <option value=""> {{$i}}:00 PM</option>
                                            <option value=""> {{$i}}:30 PM</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col">
                                <select name="" id="" class="form-control">
                                        @for ($i = 2; $i <= 11; $i++)
                                            <option value=""> {{$i}}:00 PM</option>
                                            <option value=""> {{$i}}:30 PM</option>
                                        @endfor
                                </select>
                            </div>

                    </td>


                </tr>
            @endforeach
        </tbody>
      </table>
    </div>

</div>
@endsection
