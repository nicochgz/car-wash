@extends('app.master')

@section('titulo')
Formulario de Usuarios
@endsection


@section('contenido')
<div class="card">
<div class="card-header">
  <h3 class="card-title">Registro de usuarios</h3>
  <div class="card-tools">
    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
      <i class="fas fa-minus"></i></button>
    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
      <i class="fas fa-times"></i></button>
  </div>
</div>
<div class="card-body">
<div id="app" class="row">
    <form action="{{action('Auth\RegisterController@register')}}" method="POST">
      {{csrf_field()}} 
      <input type="hidden" name="idusuario" value="">
      <div class="form-group">
        <label class="form-label" for="">Email</label>
        <input type="email" value="" name="email" class="form-control">
      </div>
      <div class="form-group">
        <label class="form-label" for="">Password</label>
        <input type="password" value="" name="password" class="form-control">
      </div>

      <div class="form-group">        
        <label class="form-label" for="">Rol</label>
        <select class="form-control" name="idrol" id="">
            <option value="1">Gerente</option>
            <option value="2">Contabilidad</option>
            <option value="3">Hostess</option>
        </select>
      </div>


      <!--<div class="form-group">        
        <label class="form-label" for="">Rol</label>
        <select class="form-control" name="idrol" id="">
            <option value="1">Gerente</option>
            <option value="1">Contabilidad</option>
            <option value="1">Hostess</option>
        </select>
      </div>-->
      
      <input type="submit" class="btn btn-success" name="operacion" value="Registrar">
      <input type="submit" class="btn btn-warning" name="operacion" value="Cancelar">
    </form>
  </div>


</div>
<!-- /.card-body -->
<div class="card-footer">
  Footer
</div>
<!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection


@section('script')
<script>
    <script>
      new Vue({
        el:'#app',
        data:{
          
          }
        }
        ,methods:{
          remove:function(){
            
        }
      });
    </script>
</script>
@endsection