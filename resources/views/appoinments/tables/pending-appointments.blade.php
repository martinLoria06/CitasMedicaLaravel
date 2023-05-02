
<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col">Description</th>
          <th scope="col">Especialidad</th>
          @if ($role == 'Paciente')
          <th scope="col">Medico</th>
          @elseif($role == 'Doctor')
          <th scope="col">Paciente</th>
          @endif
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
          <th scope="col">Tipo</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($pendingAppointments as $cita)
              <tr>
                  <th scope="row">
                    {{$cita->description}}
                  </th>
                  <td>
                      {{$cita->specialty->name}}
                  </td>
                  @if ($role == 'Paciente')
                  <td>
                    {{$cita->doctor->name}}
                  </td>
                  @elseif ($role == 'Doctor')
                  <td>
                    {{$cita->patient->name}}
                  </td>
                  @endif
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
                    @if ($role == 'admin')
                    <a href="{{route('miscitas.show',[$cita->id])}}" class="btn btn-sm btn-info"><i class="ni far fa-eye"></i></a>
                    @endif
                    @if ($role == 'Doctor'||$role == 'admin')
                        <form action="{{route('miscitas.confirm',[$cita->id])}}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" title="Confirmar cita"><i class="ni ni-check-bold"></i></button>
                        </form>
                    @endif
                      <form action="{{route('miscitas.cancelar',[$cita->id])}}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger" title="Cancelar cita"><i class="ni ni-fat-delete"></i></button>
                      </form>
                  </td>
            </tr>
          @endforeach
      </tbody>
    </table>
  </div>
