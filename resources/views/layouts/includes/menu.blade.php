<aside class="left-sidebar" data-sidebarbg="skin5">
	<div class="scroll-sidebar">
		<nav class="sidebar-nav">
			<ul id="sidebarnav" class="p-t-30">
				<li class="sidebar-item-title"><span class="hide-menu">Menu</span></li>
				<li class="sidebar-item {{Request::segment(2) === 'dashboard' ? 'selected' : null}}">
					<a class="sidebar-link waves-effect waves-dark sidebar-link {{Request::segment(2) === 'dashboard' ? 'active' : null}}" href="{{url('/extranet/dashboard')}}" aria-expanded="false">
						<i class="mdi mdi-view-dashboard"></i>
						<span class="hide-menu">Dashboard</span>
					</a>
				</li>
				@role('Master|Admin|Registro')
				<li class="sidebar-item {{Request::segment(2) === 'empresacreate' ? 'selected' : null}}">
					<a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/extranet/empresacreate/create')}}" aria-expanded="false">
						<i class="fas fa-plus"></i>
						<span class="hide-menu">Nueva Empresa</span>
					</a>
				</li>
				@endcan
				@role('Master|Admin|Registro|Practicante')
				<li class="sidebar-item {{Request::segment(2) === 'empresa' ? 'selected' : null}}">
					<a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/extranet/empresa')}}" aria-expanded="false">
						<i class="fas fa-building"></i>
						<span class="hide-menu">Empresas</span>
					</a>
				</li>
				@endcan
				@role('Master|Admin|Registro')
				<li class="sidebar-item {{Request::segment(2) === 'autorizacioncreate' ? 'selected' : null}}">
					<a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/extranet/autorizacioncreate/create')}}" aria-expanded="false">
						<i class="mdi mdi-file-check"></i>
						<span class="hide-menu">Nueva Autorización</span>
					</a>
				</li>
				<li class="sidebar-item {{Request::segment(2) === 'renovacion' ? 'selected' : null}}">
					<a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/extranet/renovacion')}}" aria-expanded="false">
						<i class="mdi mdi-file-multiple"></i>
						<span class="hide-menu">Renovacion</span>
					</a>
				</li>
				
				<li class="sidebar-item-title"><span class="hide-menu">Modificaiones</span></li>
				<li class="sidebar-item {{Request::segment(3) === 'rutas' ? 'selected' : null}}">
					<a class="sidebar-link has-arrow waves-effect waves-dark {{Request::segment(3) === 'rutas' ? 'active' : null}}" href="javascript:void(0)" aria-expanded="false">
					  <i class="mdi mdi-road-variant"></i><span class="hide-menu">Rutas </span>
					</a>
					<ul aria-expanded="false" class="collapse first-level {{Request::segment(3) === 'rutas' ? 'in' : null}}">
						<li class="sidebar-item"><a href="{{url('extranet/modificacion/rutas/ampliacion')}}" class="sidebar-link {{Request::segment(4) === 'ampliacion' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Ampliación</span></a></li>
						<li class="sidebar-item"><a href="{{url('extranet/modificacion/rutas/frecuencia')}}" class="sidebar-link {{Request::segment(4) === 'frecuencia' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Frecuencia</span></a></li>
						<li class="sidebar-item"><a href="{{url('extranet/modificacion/rutas/itinerario')}}" class="sidebar-link {{Request::segment(4) === 'itinerario' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Itinerario</span></a></li>
						<li class="sidebar-item"><a href="{{url('extranet/modificacion/rutas/renuncia')}}" class="sidebar-link {{Request::segment(4) === 'renuncia' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Renuncia</span></a></li>
						<li class="sidebar-item"><a href="{{url('extranet/modificacion/rutas/reconsideracion')}}" class="sidebar-link {{Request::segment(4) === 'reconsideracion' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Reconsideración</span></a></li>
					</ul>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link has-arrow waves-effect waves-dark {{Request::segment(3) === 'vehiculos' ? 'selected' : null}}" href="javascript:void(0)" aria-expanded="false">
					  <i class="mdi mdi-car"></i><span class="hide-menu">Vehiculos </span>
					</a>
					<ul aria-expanded="false" class="collapse first-level {{Request::segment(3) === 'vehiculos' ? 'in' : null}}">
						<li class="sidebar-item"><a href="{{url('extranet/modificacion/vehiculos/sustitucion')}}" class="sidebar-link {{Request::segment(4) === 'sustitucion' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Sustitución</span></a></li>
						<li class="sidebar-item"><a href="{{url('extranet/modificacion/vehiculos/incremento')}}" class="sidebar-link {{Request::segment(4) === 'incremento' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Incremento</span></a></li>
						<li class="sidebar-item"><a href="{{url('extranet/modificacion/vehiculos/baja')}}" class="sidebar-link {{Request::segment(4) === 'baja' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Baja</span></a></li>
					</ul>
				</li>
				@endcan
				@role('Master|Admin|Reporte')
				<li class="sidebar-item-title"><span class="hide-menu">Otros</span></li>
				<li class="sidebar-item">
					<a class="sidebar-link has-arrow waves-effect waves-dark {{Request::segment(2) === 'reporte' ? 'selected' : null}}" href="javascript:void(0)" aria-expanded="false">
					  <i class="fas fa-chart-line"></i><span class="hide-menu">Reportes </span>
					</a>
					<ul aria-expanded="false" class="collapse first-level {{Request::segment(2) === 'reporte' ? 'in' : null}}">
						<li class="sidebar-item"><a href="{{url('extranet/reporte/vehiculo')}}" class="sidebar-link {{Request::segment(3) === 'vehiculo' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Vehiculos</span></a></li>
						<li class="sidebar-item"><a href="{{url('extranet/reporte/ruta')}}" class="sidebar-link {{Request::segment(3) === 'ruta' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Rutas</span></a></li>
						<li class="sidebar-item"><a href="{{url('extranet/reporte/resolucion')}}" class="sidebar-link {{Request::segment(3) === 'resolucion' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Resolucion</span></a></li>
					</ul>
				</li>
				@endcan
				@role('Master|Admin')
				<li class="sidebar-item">
					<a class="sidebar-link has-arrow waves-effect waves-dark {{Request::segment(2) === 'configuracion' ? 'selected' : null}}" href="javascript:void(0)" aria-expanded="false">
					  <i class="fas fa-cogs"></i><span class="hide-menu">Configuracion </span>
					</a>
					<ul aria-expanded="false" class="collapse first-level {{Request::segment(2) === 'configuracion' ? 'in' : null}}">
						<li class="sidebar-item"><a href="{{url('extranet/configuracion/categoria')}}" class="sidebar-link {{Request::segment(3) === 'categoria' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Categorias</span></a></li>
						<li class="sidebar-item"><a href="{{url('extranet/configuracion/marca')}}" class="sidebar-link {{Request::segment(3) === 'marca' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Marcas</span></a></li>
						<li class="sidebar-item"><a href="{{url('extranet/configuracion/carroceria')}}" class="sidebar-link {{Request::segment(3) === 'carroceria' ? 'active' : null}}"><i class="mdi mdi-ray-start"></i><span class="hide-menu">Carrocerias</span></a></li>
					</ul>
				</li>
				@endcan
				@role('Master')
				<li class="sidebar-item {{Request::segment(2) === 'usuario' ? 'selected' : null}}">
					<a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/extranet/usuario')}}" aria-expanded="false">
						<i class="fas fa-users"></i>
						<span class="hide-menu">Usuarios</span>
					</a>
				</li>
				@endcan
			</ul>
		</nav>
	</div>
</aside>