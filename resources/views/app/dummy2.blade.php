@extends('app.master')

@section('titulo')
Pagina dummy2
@endsection

@section('contenido')
<!-- Default box -->
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
  Este es un ejemplo de página hijo
</div>
<!-- /.card-body -->
<div class="card-footer">
  Footer
</div>
<!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection