@extends('layouts.custom.app')

@section('content')
  <div class="container pb-0">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header mb-4">
            <div class="row pl-2 pr-2">
              <span>
                {{ __('Gestion de movimientos') }}
              </span>
              {{-- <form action="" class="form-inline ml-auto">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <input type="text" placeholder="Buscar...">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                  </div>
                </div>
              </form> --}}
            </div>
          </div>
          <div class="card-body">
            <div class="row pb-1 pr-4">
                <div class="ml-auto">
                  <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Crear nuevo movimiento') }}">
                    <button type="button" data-toggle="modal" data-target="#createModal">
                      <i class="fas fa-plus"></i>
                    </button>
                  </span>
                </div>
              </div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Abreviatura</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($movements as $movement)    
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <th>{{ $movement->name }}</th>
                    <th>{{ $movement->abbreviation }}</th>
                    <th>
                      <div class="row pl-4">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Editar sucursal') }}">
                          <a href="#" class="text-success" onclick='updateModal(@json($movement))'>
                            <i class="fas fa-edit"></i>
                          </a>
                        </span>
                        <form action="{{ route('delete-movement', ['movement' => $movement->id]) }}" method="POST" id="delete-movement-{{ $movement->id }}">
                          @method('DELETE')
                          @csrf
                        </form>
                        <span class="ml-2 d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Eliminar movimiento') }}">
                          <a href="#" class="text-danger" onclick="deleteMovement('{{ $movement->id }}')">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                        </span>
                      </div>
                    </th>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="row">
              <div class="ml-auto pr-3">
                {{ $movements->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection