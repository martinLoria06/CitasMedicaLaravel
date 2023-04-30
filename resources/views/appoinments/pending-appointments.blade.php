
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
                      <form action="{{route('miscitas.cancelar',[$cita->id])}}" method="POST">
                          @csrf
                      <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                  </form>
                  </td>
            </tr>
          @endforeach
      </tbody>
    </table>
  </div>
