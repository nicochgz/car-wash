@extends('app.master')

@section('titulo')
Formulario de material
@endsection

@section('contenido')
<div class="card">
<div class="card-header">
  <h3 class="card-title">Pagina dummy2</h3>

  <div class="card-tools">
    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
      <i class="fas fa-minus"></i></button>
    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
      <i class="fas fa-times"></i></button>
  </div>
</div>
<div class="card-body">


  <div id="app" class="row">
    <form action="{{action('ProductoController@save')}}" method="POST">
      {{csrf_field()}} 
      <input type="hidden" name="idproducto" class="form-control" value="{{$producto->idproducto}}">
      
      <div class="form-group">
        <label class="form-label" for="">Nombre del producto</label>
        <input type="text" v-model="nombreproducto" name="nombreproducto" class="form-control">
      </div>
      <div class="form-group">
        <label class="form-label" for="">Precio</label>
        <input type="text" v-model="precio" name="precio" class="form-control">
      </div>
      <div v-if="bandera==1" class="alert alert-warning" role="alert">
        @{{mensaje}}
      </div>      
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
          nombreproducto:'{{$producto->nombreproducto}}'
          ,precio:'{{$producto->precio}}'
          ,bandera:0
          ,mensaje:''
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
            if(this.nombreproducto==''){
              this.bandera=1;
              this.mensaje+=' El nombre no puede estar vacío';
            }

            if(this.precio==''){
              this.bandera=1;
              this.mensaje+=' El precio no puede estar vacío';
            }
      
            if(this.bandera==1){
              event.preventDefault();
            }         
          }
        }
      });
    </script>
@endsection