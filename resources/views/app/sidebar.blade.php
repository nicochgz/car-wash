<!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          
        </div>
        <div class="info">          
          @if(validar_permiso_rol(auth()->user()->idrol,'PERFIl'))
          <a href="{{action('SocioController@perfil')}}" class="d-block">
          <i class="nav-icon fas fa-user-circle"></i></a>  
          @endif
        </div>
        <div class="info">          
          <a>{{dame_nombre_usuario(auth()->user())}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!--<li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Consolas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../../index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li>-->
          
          @if(validar_permiso_rol(auth()->user()->idrol,'SERVICIO'))  
          <li class="nav-item">
            <a href="{{action('ServicioController@listado')}}" class="nav-link">
              <i class="nav-icon far fa-list-alt"></i>
              <p>
                Servicios
              </p>
            </a>
          </li>
          @endif
          @if(validar_permiso_rol(auth()->user()->idrol,'TIPOSERVICIO')) 
          <li class="nav-item">
            <a href="{{action('TipoServicioController@listado')}}" class="nav-link">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>
                Tipo Servicios
              </p>
            </a>
          </li>
          @endif           
          @if(validar_permiso_rol(auth()->user()->idrol,'PERSONAL')) 
          <li class="nav-item">
            <a href="{{action('PersonalController@listado')}}" class="nav-link">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Personal
              </p>
            </a>
          </li>
          @endif
          @if(validar_permiso_rol(auth()->user()->idrol,'SOCIOS')) 
          <li class="nav-item">
            <a href="{{action('SocioController@listado')}}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Socios
              </p>
            </a>
          </li>
          @endif 
          @if(validar_permiso_rol(auth()->user()->idrol,'TIPOSOCIO')) 
          <li class="nav-item">
            <a href="{{action('TipoSocioController@listado')}}" class="nav-link">
              <i class="nav-icon fas fa-handshake"></i>
              <p>
                Tipo Socios
              </p>
            </a>
          </li>
          @endif                     
          @if(validar_permiso_rol(auth()->user()->idrol,'ROLES'))
          <li class="nav-item">
            <a href="{{action('RolController@listado')}}" class="nav-link">
              <i class="nav-icon fas fa-tags"></i>
              <p>
                Roles
              </p>
            </a>
          </li>
          @endif 
          @if(validar_permiso_rol(auth()->user()->idrol,'MATERIASPRIMAS'))
          <li class="nav-item">
            <a href="{{action('MateriaPrimaController@listado')}}" class="nav-link">
              <i class="nav-icon fas fa-pump-soap"></i>
              <p>
                Materias primas
              </p>
            </a>
          </li>
          @endif 
          @if(validar_permiso_rol(auth()->user()->idrol,'USUARIOS'))
          <li class="nav-item">
            <a href="{{action('UsuarioController@listado')}}" class="nav-link">
              <i class="nav-icon fas fa-id-card"></i>
              <p>
                Usuarios
              </p>
            </a>
          </li>
          @endif 
          @if(validar_permiso_rol(auth()->user()->idrol,'PERMISOS'))
          <li class="nav-item">
            <a href="{{action('PermisoController@listado')}}" class="nav-link">
              <i class="nav-icon fas fa-flag"></i>
              <p>
                Permisos
              </p>
            </a>
          </li>
          @endif           
          @if(validar_permiso_rol(auth()->user()->idrol,'PRODUCTOS'))
          <li class="nav-item">
            <a href="{{action('ProductoController@listado')}}" class="nav-link">
              <i class="nav-icon fas fa-dolly"></i>
              <p>
                Productos
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="{{action('DemoController@prueba_vue')}}" class="nav-link">
              <i class="nav-icon fas fa-bullhorn"></i>
              <p>
                Petición asíncrona (test)
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{action('PagoController@ventanilla')}}" class="nav-link">
              <i class="nav-icon far fa-credit-card"></i>
              <p>
                Pago ventanilla (test)
              </p>
            </a>
          </li>
          

          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->