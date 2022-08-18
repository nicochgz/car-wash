@extends('app.master')

@section('titulo')
Formulario de rentas
@endsection

@section('style')
      <style>
        #dropzone{
          border-radius: 5px;
          padding: 40px;
          border-width: 2px;
          border-style: dashed;
        }

        .inactivo{
          background-color: #BBDEFB;
        }

        .conarchivo{
          background-color: #C8E6C9;
          border-color: #2E7D32;
        }

        .sobre{
          background-color: #FFF9C4;
          border-color: #F9A825;
        }

        .invalido{
          background-color: #ffcdd2;
          border-color: #c62828;
        }

        #foto{
          display: none;
        }

        #carga_file{
          cursor: pointer;
        }
      </style>
@endsection      




@section('contenido')
<div class="card">
<div class="card-header">
  <h3 class="card-title">Formulario</h3>

  <div class="card-tools">
    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
      <i class="fas fa-minus"></i></button>
    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
      <i class="fas fa-times"></i></button>
  </div>
</div>
<div class="card-body">
 

<div id="app" class="row">
    <form enctype="multipart/form-data" action="{{action('RentaController@save')}}" method="POST">
      {{csrf_field()}} 
      <input type="hidden" name="idrenta" class="form-control" value="{{$renta->idrenta}}">
      <input type="hidden" name="idsocio" value="{{$renta->idsocio}}">
      
      <div class="form-group">
        <label class="form-label" for="">Precio</label>
        <input type="text" v-model="precio" name="precio" class="form-control">
      </div>      

      <div class="form-group">
        <label class="form-label" for="">Fecha Inicio</label>
        <input type="text" v-model="fecha_inicio" name="fecha_inicio" class="form-control">
      </div> 

      <div class="form-group">
        <label class="form-label" for="">Fecha Fin</label>
        <input type="text" v-model="fecha_fin" name="fecha_fin" class="form-control">
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
          fecha_inicio:'{{$renta->fecha_inicio}}'
          ,fecha_fin:'{{$renta->fecha_fin}}'
          ,precio:'{{$renta->precio}}'
          ,bandera:0
          ,mensaje:''
          ,tipos_permitidos:['image/png','image/jpeg']
          ,url:'{{URL::to('/')}}/'+'{{$renta->foto}}'
          ,nombre_archivo:''
          ,clase:{
            inactivo:true
            ,conarchivo:false
            ,sobre:false
            ,invalido:false
          }
        }
        ,methods:{
          remove:function(){
            this.$refs.campo.value='';
            this.nombre_archivo='';
            this.url='';
          },
          cambiar:function(){
            ultimo=this.$refs.campo.files.length-1;
            if(this.tipos_permitidos.indexOf(this.$refs.campo.files[ultimo].type)!=-1){
              this.nombre_archivo=this.$refs.campo.files[ultimo].name;
              this.url = URL.createObjectURL(this.$refs.campo.files[ultimo]);

              console.log(this.$refs.campo.files);
              //console.log('archivo valido');
            }
            else{
              this.clase.sobre=false;
              this.clase.conarchivo=false;
              this.clase.inactivo=false;
              this.clase.invalido=true; 
              console.log('archivo invalido');
            }
          },

          sobre:function(event){
            event.preventDefault();
            this.clase.sobre=true;
            this.clase.conarchivo=false;
            this.clase.inactivo=false;
            this.clase.invalido=false; 
          },
          fuera:function(event){
            event.preventDefault();
            this.clase.sobre=false;
            this.clase.conarchivo=false;
            this.clase.inactivo=true; 
            this.clase.invalido=false;        
          },
          drop:function(event){
            event.preventDefault();
            //event es el objeto del evento que se disparó que en este caso es drop
            //dataTransfer es un atributo donde se guarda la referencia al manejo de  los archivos del evento
            //files son los archivos asociados al evento
            this.$refs.campo.files=event.dataTransfer.files;
            this.clase.sobre=false;
            this.clase.conarchivo=true;
            this.clase.inactivo=false; 
            this.clase.invalido=false; 
            this.cambiar();         
          },


          confirmar_eliminar:function(event){
            if(!confirm("Desea eliminar el registro?"))            
              event.preventDefault();
          },
          validar_formulario:function(event){
            this.bandera=0;
            this.mensaje='';
            //vamos a prender la bandera si un campo no está bien llenado
            if(this.fecha_inicio==''){
              this.bandera=1;
              this.mensaje+=' La fecha no puede estar vacía';
            }

            if(this.fecha_fin==''){
              this.bandera=1;
              this.mensaje+=' La fecha no puede estar vacía';
            }

            if(this.precio==''){
              this.bandera=1;
              this.mensaje+=' El precio no puede estar vacío';
            }

            if(this.idrenta==''){
              
            }
      
            if(this.bandera==1){
              event.preventDefault();
            }         
          }
        }
      });
    </script>
@endsection