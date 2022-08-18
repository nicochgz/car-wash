@extends('app.master')

@section('titulo')
Formulario de servicio
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
    <form action="{{action('ServicioController@save')}}" method="POST">
      {{csrf_field()}}
      <input type="hidden" name="idservicio" class="form-control" value="{{$servicio->idservicio}}">
      <input type="hidden" name="idpersonal" class="form-control" value="{{$servicio->idpersonal}}">
      <input type="hidden" name="idsocio" class="form-control" value="{{$servicio->idsocio}}">
      <input type="hidden" name="idtiposervicio" class="form-control" value="{{$servicio->idtiposervicio}}">

      
      <div class="form-group">
        <label class="form-label" for="">Socio</label>
        <!--<input type="text" v-model="idsocio" name="idsocio" class="form-control">-->
        <select name="idsocio" v-model="idsocio" id="" class="form-control">
          <option v-for="socio in socios" :value="socio.idsocio">@{{socio.nombre}}</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="">Miembro del personal a cargo del servicio</label>
        <!--<input type="text" v-model="idsocio" name="idsocio" class="form-control">-->
        <select name="idpersonal" v-model="idpersonal" id="" class="form-control">
          <option v-for="personal in personales" :value="personal.idpersonal">@{{personal.nombrecompleto}}</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="">Placa</label>
        <input type="text" v-model="placa" name="placa" class="form-control">
      </div>
      <div class="form-group">
        <label class="form-label" for="">Modelo</label>
        <input type="text" v-model="modelo" name="modelo" class="form-control">
      </div>
      <div class="form-group">
        <label class="form-label" for="">Año</label>
        <input type="text" v-model="anio" name="anio" class="form-control">
      </div>

      <div class="form-group">
        <label class="form-label" for="">Tipo de servicio</label>
        <!--<input type="text" v-model="tiposervicio" name="tiposervicio" class="form-control">-->
        <select name="idtiposervicio" v-model="idtiposervicio" id="" class="form-control">
            <option v-for="tipo in tipos" :value="tipo.idtiposervicio">@{{tipo.nombre}}</option>
        </select>
      </div>


      <div class="form-group">
        <label class="form-label" for="">Fecha de atencion</label>
        <vuejs-datepicker
                         input-class="form-control"
                         placeholder="Seleccione una fecha"
                         format="yyyy-MM-dd"
                         :language="lenguaje"
                         v-model="fecha_atencion"
                         name="fecha_atencion"
                         ></vuejs-datepicker>
      </div>


      <div v-if="bandera==1" class="alert alert-warning" role="alert">
        @{{mensaje}}
      </div>
      <input type="submit" @click="validar_formulario($event)" class="btn btn-success" name="operacion" value="{{$operacion}}">
      <!--<button type="submit" class="btn btn-success"></button>-->
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


@section('javascripts')
<script src="{{asset('public/vuejs-datepicker.min.js')}}"></script>
<script src="{{asset('public/es.js')}}"></script>
@endsection


@section('script')
 <script>
    new Vue({
      el:'#app',
      data:{
        idsocio:'{{$servicio->idsocio}}'
        ,idpersonal:'{{$servicio->idpersonal}}' 
        ,placa:'{{$servicio->placa}}'
        ,modelo:'{{$servicio->modelo}}'
        ,anio:'{{$servicio->anio}}'
        ,idtiposervicio:'{{$servicio->idtiposervicio}}' 
        ,tipos:<?php echo json_encode($tipos);?>
        ,socios:<?php echo json_encode($socios);?>
        ,personales:<?php echo json_encode($personales);?>
        ,bandera:0
        ,mensaje:''
        ,fecha_atencion:'{{$servicio->fecha_atencion}}'
        ,lenguaje:vdp_translation_es.js
      }
      ,methods:{
        confirmar_eliminar:function(event){
          if(!confirm("Desea eliminar el servicio?"))            
            event.preventDefault();
        },
        validar_formulario:function(event){
          this.bandera=0;
          this.mensaje='';
          //vamos a prender la bandera si un campo no está bien llenado
          //cambiar a nombre
          if(this.idsocio==''){ 
            this.bandera=1;
            this.mensaje+=' El nombre no puede estar vacío';
          }

          if(this.placa==''){
            this.bandera=1;
            this.mensaje+=' La placa no puede estar vacía';
          }

          if(this.modelo==''){
            this.bandera=1;
            this.mensaje+=' El modelo no puede estar vacío';
          }

          if(this.anio==''){
            this.bandera=1;
            this.mensaje+=' El año no puede estar vacío';
          }
          /*else{
            temporal=parseInt(this.anio);
            if(Number.isInteger(temporal)){
              if(temporal>2020 || temporal<1970){
                this.bandera=1;
                this.mensaje+=' El año no está entre 1970 y 2020';
              }
              else{
                this.bandera=1;
                this.mensaje+=' El año tiene que ser un número';
              }
            }
          }*/

          //cambiar a tiposervicio
          if(this.idtiposervicio==''){ 
            this.bandera=1;
            this.mensaje+=' El tipo de servicio no puede estar vacío';
          }



          if(this.bandera==1){
            event.preventDefault();
          }         
        }  
      },
        components: {
          vuejsDatepicker
        }
    });
  </script>
@endsection