@extends('app.master')

@section('titulo')
Catálogo de personal
@endsection

@section('contenido')
<div class="card">
<div class="card-header">
  <h3 class="card-title">Listado</h3>

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
      <form action="{{action('PersonalController@formulario')}}" method="POST">
        {{csrf_field()}}
        <button class="btn btn-success">Agregar</button>
      </form>
    </div>
  </div>
  
  <div id="app" class="row">
    <div class="col-md-12 col-xs-12 col-sm-12">      
      <table class="table">
        <tr>
          <th>Nombre completo</th>
          <th>Curp</th>
          <th>Foto</th>
        </tr>
        
        <tr v-for="elemento in lista">
          <td><a :href="url_editar+'?idpersonal='+elemento.idpersonal">@{{elemento.nombrecompleto}}</a></td>
          <td>@{{elemento.curp}}</td>
          <td>
            <!-- Comentar esto-->
            <img :src="'{{URL::to('/')}}/'+elemento.foto" width="100" alt=""> 
          </td>
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
        ,url_editar:'{{action("PersonalController@formulario")}}'
      }
      ,methods:{}
    });
  </script>
@endsection












 
