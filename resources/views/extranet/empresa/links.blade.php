<ul class="nav nav-pills">
  <li class="nav-item">
    <a class="nav-link {{Request::segment(3) === 'ruta' ? 'active' : null}}" href="{{url('/extranet/empresa/ruta/'.$empresa->id)}}">Rutas</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{Request::segment(3) === 'vehiculo' ? 'active' : null}}" href="{{url('/extranet/empresa/vehiculo/'.$empresa->id)}}">Vehiculos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{Request::segment(3) === 'terminal' ? 'active' : null}}" href="{{url('/extranet/empresa/terminal/'.$empresa->id)}}">Terminales</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{Request::segment(3) === 'oficina' ? 'active' : null}}" href="{{url('/extranet/empresa/oficina/'.$empresa->id)}}">Oficinas</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{Request::segment(3) === 'gerente' ? 'active' : null}}" href="{{url('/extranet/empresa/gerente/'.$empresa->id)}}">Gerente</a>
  </li>
</ul>