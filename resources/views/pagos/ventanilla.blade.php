@extends('app.master')

@section('titulo')
Pago en ventanilla
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Time Table</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">  
  <form name="frm" action="{{action('PagoController@ventanilla')}}" method="POST">
      {{csrf_field()}}
      <div class="form-group">
        <label for="">Número de Servicio</label>
        <input type="text" class="form-control" value="" name="idservicio">
      </div>
      <button class="btn btn-success" type="submit"> Buscar servicio</button>
  </form>
  @if(isset($servicio))
  <hr>
  <form action="">
    <div class="form-group row">
      <div class="col-md-4">
        <label for="">Socio</label>
        <input type="text" class="form-control" readonly="" value="{{$servicio->cliente}}">
      </div>
      <div class="col-md-4">
        <label for="">Tipo de Servicio</label>
        <input type="text" class="form-control" readonly="" value="{{$servicio->tipo}}">
      </div>
      <div class="col-md-4">
        <label for="">Fecha de atención</label>
        <input type="text" class="form-control" readonly="" value="{{$servicio->fecha_atencion_inicial}}">
      </div>      
    </div>
    <div class="form-group row">
      <div class="col-md-3">
        <label for="">Estacion</label>
        <input type="text" class="form-control" readonly="" value="{{$servicio->nomestacion}}">
      </div>
      <div class="col-md-3">
        <label for="">Placa</label>
        <input type="text" class="form-control" readonly="" value="{{$servicio->placa}}">
      </div>
      <div class="col-md-3">
        <label for="">Modelo</label>
        <input type="text" class="form-control" readonly="" value="{{$servicio->modelo}}">
      </div>
      <div class="col-md-3">
        <label for="">Año</label>
        <input type="text" class="form-control" readonly="" value="{{$servicio->anio}}">
      </div>      
    </div>
    <div class="row">
      <h3>Total: ${{$servicio->precio}}</h3>
    </div>
  </form>
  <div id="app"></div>
  @endif
   
    <!-- /.card-body -->
  </div>
</div>

@endsection



@section('javascripts')
  @if(isset($servicio))
  <script src="https://js.stripe.com/v2/"></script>
  <script>
      var llave_publica='pk_test_51Ke7gxLjAsFwQDsts4ZWWSmVz4Y4NI33JcPRxy1UHbSqAYEvpSnEsFnuXr2KIplUj86XBuyJ6VTptrBBBkcIstP700dB7hNibc';
      var servicio={{$servicio->idservicio}};
      var laravel_token='{{csrf_token()}}';
      var url_pago='{{action('PagoController@realizar_pago')}}';
    </script>
    <script src="{{asset('public/payment/build.js')}}"></script>
  @endif
  
@endsection












 
