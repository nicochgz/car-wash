@extends('app.master')

@section('titulo')
Listado de rentas de {{$socio->nombre}}
@endsection

@section('contenido')
<div class="card">
<div class="card-header">
  <h3 class="card-title">Listado de Rentas</h3>

  <div class="card-tools">
    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
      <i class="fas fa-minus"></i></button>
    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
      <i class="fas fa-times"></i></button>
  </div>
</div>
<div class="card-body">  

<div class="row">
    <div class="col-md-12">
      <form action="{{action('RentaController@formulario')}}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="idsocio" value="{{$socio->idsocio}}">
        <button class="btn btn-success">Agregar</button>
      </form>
    </div>
  </div>
  
  <div id="app" class="row">
    <div class="col-md-12 col-xs-12 col-sm-12">      
      <table class="table">
        <tr>
          <th>Precio</th>
          <th>Fecha Inicio</th>
          <th>Fecha Fin</th>
        </tr>
        
        <tr v-for="elemento in lista">
          <td><a :href="url_editar+'?idrenta='+elemento.idrenta">@{{elemento.precio}}</a></td>
          <td>@{{elemento.fecha_inicio}}</td>
          <td>@{{elemento.fecha_fin}}</td>
          <!--<td>@{{elemento.nomtiposocio}}</td>-->
          <!--<td>
            
            <img :src="'{{URL::to('/')}}/'+elemento.foto" width="100" alt=""> 
          </td>-->
        </tr>
        
      </table>
    </div>
  </div>

</div>
<!-- /.card-body -->
<div class="card-footer">
  Footer
</div>
<!-- /.card-footer-->
</div>
@endsection



@section('script')
 <script>
    new Vue({
      el:'#app',
      data:{
        lista:<?php echo json_encode($lista);?>
        ,url_editar:'{{action("RentaController@formulario")}}'
      }
      ,methods:{}
    });
  </script>
@endsection












 
