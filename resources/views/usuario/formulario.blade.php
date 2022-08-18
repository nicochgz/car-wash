@extends('app.master')

@section('titulo')
Datos de usuarios
@endsection



@section('contenido')
<div class="card">
<div class="card-header">
  <h3 class="card-title">Datos de usuarios</h3>

  <div class="card-tools">
    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
      <i class="fas fa-minus"></i></button>
    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
      <i class="fas fa-times"></i></button>
  </div>
</div>
<div class="card-body">
 

<div id="app" class="row">
    <form enctype="multipart/form-data" action="{{action('UsuarioController@save')}}" method="POST">
      {{csrf_field()}} 
      <input type="hidden" name="idusuario" class="form-control" value="{{$usuario->idusuario}}">
      
      
      <div class="form-group">
        <label class="form-label" for="">Email</label>
        <input type="email" v-model="email" name="email" class="form-control">
      </div>
      
      <div class="form-group">
        <label class="form-label" for="">Rol</label>
        <!--<input type="text" v-model="idtiposocio" name="idtiposocio" class="form-control">-->
        <select name="idrol" v-model="idrol" id="" class="form-control">
          <option v-for="rol in roles" :value="rol.idrol">@{{rol.nomrol}}</option>
        </select>
      </div>
      
      <div v-if="bandera==1" class="alert alert-warning" role="alert">
        @{{mensaje}}
      </div>
      <img :src="url" width="200" alt=""><br/>  
      <input type="submit" @click="validar_formulario($event)" class="btn btn-success" name="operacion" value="{{$operacion}}">
      @if($operacion=='Editar')
      <input type="submit" @click="confirmar_eliminar($event)" class="btn btn-danger" name="operacion" value="Eliminar">
      @endif
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
      new Vue({
        el:'#app',
        data:{
          email:'{{$usuario->email}}'
          ,idrol:'{{$usuario->idrol}}'
          ,bandera:0
          ,mensaje:''
          ,roles:<?php echo json_encode($roles);?>          
        }
        ,methods:{  
          confirmar_eliminar:function(event){
            if(!confirm("Desea eliminar el registro?"))            
              event.preventDefault();
          },
          validar_formulario:function(event){
            this.bandera=0;
            this.mensaje='';
            //vamos a prender la bandera si un campo no está bien llenado
            if(this.email==''){
              this.bandera=1;
              this.mensaje+=' El email no puede estar vacío';
            }

            if(this.idrol==''){
              this.bandera=1;
              this.mensaje+=' El rol de socio no puede estar vacío';
            }
      
            if(this.bandera==1){
              event.preventDefault();
            }         
          }
        }
      });
    </script>
@endsection