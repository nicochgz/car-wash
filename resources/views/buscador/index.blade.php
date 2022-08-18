@extends('app.master')

@section('titulo')
Buscador
@endsection

@section('contenido')
  <div class="row">
    <div class="col-md-12">
      <form action="{{action('BuscadorController@index')}}" method="POST">
        {{csrf_field()}}
        <div class="form-group">
          <label for="">Buscar</label>
          <input type="text" name="criterio" value="{{$criterio}}" placeholder="Escribir nombre del personal, nombre del cliente, número de placa..." class="form-control"></input>
        </div>
        <button class="btn btn-success">Buscar</button>        
      </form>
    </div>
  </div>
  <div id="app" class="row">    
    <div v-if="registros.length!=0" class="col-md-12 col-xs-12 col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Búsqueda rápida</h3>
        </div>
        <div class="panel-body">


         
          <div class="form-group">
            <label>Tipo de socio</label>
            <select class="form-control" v-model="filtro_tiposocio">
              <option v-for="tipsoc in tiposocio" :value="tipsoc">@{{tipsoc}}</option>
            </select>
          </div>


          <div class="form-group">
            <label>Tipo de servicio</label>
            <select class="form-control" v-model="filtro_tipo">
              <option v-for="tip in tipos" :value="tip">@{{tip}}</option>
            </select>
          </div>
          <div class="form-group">
            <label>Modelo</label>
            <select class="form-control" v-model="filtro_modelo">
              <option v-for="mod in modelos" :value="mod">@{{mod}}</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div v-if="registros.length!=0" class="col-md-12 col-xs-12 col-sm-12">
      <h1>Resultado de búsqueda</h1> 
      <table class="table">
        <tr>
          <th>Socio</th>
          <th>Tipo de socio</th>
          <th>Placa</th>
          <th>Modelo / Año</th>
          <th>Tipo de servicio</th>
          <th>Precio</th>
          <th>Personal</th>
        </tr>      

        <tr v-for="elemento in registros_final">
          <td>@{{elemento.nombre}}</td>
          <td>@{{elemento.nomtiposocio}}</td>
          <td>@{{elemento.placa}}</td>
          <td>@{{elemento.modelo+' '+elemento.anio}}</td>
          <td>@{{elemento.tiposervicio}}</td>
          <td>@{{elemento.precio}}</td>
          <td>@{{elemento.personal}}</td>
        </tr> 

      </table>
    </div>
  </div>
@endsection


@section('script')
 <script>
    new Vue({
      el:'#app',
      data:{
        registros:<?php echo json_encode($registros);?>
        //agregué esto
        ,filtro_tiposocio:'Todos'

        ,filtro_tipo:'Todos'
        ,filtro_modelo:'Todos'
        ,tiposocio:[]
        ,tipos:[]
        ,modelos:[]
        //,url_editar:'{{action("BuscadorController@index")}}'
      }
      ,methods:{
        borrar:function(){
          this.registros_final.splice(0,this.registros_final.length);
        }
        
        ,filtrar:function(){
          this.borrar();
          for(i=0;i<this.registros.length;i++){
            bandera=false;
            if(this.filtro_tipo=='Todos')
              bandera=true;
            else{
              if(this.filtro_tipo==this.registros[i].tiposervicio)
                bandera=true;
            }

            //agregué esto
            if(this.filtro_tiposocio=='Todos')
              bandera=true;
            else{
              if(this.filtro_tiposocio==this.registros[i].nomtiposocio)
                bandera=true;
            }


            if(bandera){
              this.registros_final.push(this.registros[i]);
            }
          }
        }
      }
      ,computed:{
        registros_final:function(){
        lista=[];

        self=this;
          lista=this.registros.filter(function(item){
          bandera_tipo=false;            
          bandera_tiposoc=false;            
          bandera_modelo=false;            
            if(self.filtro_tipo=='Todos')
              bandera_tipo=true;
            else{
              if(self.filtro_tipo==item.tiposervicio)
                bandera_tipo=true;
            }

            if(self.filtro_modelo=='Todos')
              bandera_modelo=true;
            else{
              if(self.filtro_modelo==item.modelo)
                bandera_modelo=true;
            }


            //agregué esto
            if(self.filtro_tiposocio=='Todos')
              bandera_tiposoc=true;
            else{
              if(self.filtro_tiposocio==item.nomtiposocio)
                bandera_tiposoc=true;
            }



            return bandera_tipo&&bandera_modelo&&bandera_tiposoc;
          })
          return lista;
        }        
      }
      ,created(){

        //agregué esto
          this.tiposocio.push('Todos');


          this.tipos.push('Todos');
          this.modelos.push('Todos');
          for(i=0;i<this.registros.length;i++){

            //agregué esto
            if(this.tiposocio.indexOf(this.registros[i].nomtiposocio)==-1){
              this.tiposocio.push(this.registros[i].nomtiposocio);
            }


            if(this.tipos.indexOf(this.registros[i].tiposervicio)==-1){
              this.tipos.push(this.registros[i].tiposervicio);
            }

            if(this.modelos.indexOf(this.registros[i].modelo)==-1){
              this.modelos.push(this.registros[i].modelo);
            }
          }
        }

    });
  </script>
  @endsection