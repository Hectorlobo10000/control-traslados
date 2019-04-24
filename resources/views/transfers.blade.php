@extends('layouts.custom.app')

@section('content')
<div class="container pb-0">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header mb-4">
            <div class="row pl-2 pr-2">
              <span>
                {{ __('Gestion de traslados') }}
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
                  <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Crear nuevo traslado') }}">
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
                  <th scope="col">Estado</th>
                  <th scope="col">Receptor</th>
                  <th scope="col">Sucursal receptora</th>
                  <th scope="col">Emisor</th>
                  <th scope="col">Detalles</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($boxes as $boxe)    
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <th>{{ $boxe->stateName }}</th>
                    <th>{{ $boxe->userName }}</th>
                    <th>{{ $boxe->branchName }}</th>
                    <th>{{ Auth::user()->name }}</th>
                    <th>
                        <form action="{{ route('boxes-for-transfer', ['box' => $boxe->transferId ]) }}" method="get" id="boxes-for-transfer-{{ $boxe->transferId }}">
                          @csrf
                        </form>
                        <span class="d-inline-block" tab-index="0" data-toggle="tooltip"  data-placement="right" title="{{ __('Ver cajas en traslado') }}">
                          <a href="#" class="text-secondary" onclick='showProducts("{{ $boxe->transferId }}")'>
                            <i class="fas fa-eye ml-4"></i>
                          </a>  
                        </span>
                      </th>
                    <th>
                      <div class="row pl-4">
                        {{-- <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Editar sucursal') }}">
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
                        </span> --}}
                      </div>
                    </th>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="row">
              <div class="ml-auto pr-3">
                {{ $boxes->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container pb-0 mt-4">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card">
            <div class="card-header mb-4">
              <div class="row pl-2 pr-2">
                <span>
                  {{ __('Cajas en traslados') }} 
                  {{-- <strong>
                    {{ $firstBox->code }}
                  </strong> --}}
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
                {{-- <div class="ml-auto">
                  <form action="{{ route('create-box') }}" method="POST" id="create-box">
                    @csrf
                  </form>
                  <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Crear nueva caja') }}">
                    <button type="button" 
                      onclick="
                        event.preventDefault();
                        document.getElementById('create-box').submit();
                      ">
                      <i class="fas fa-plus"></i>
                    </button>
                  </span>
                </div>
              </div> --}}
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Codigo de traslado</th>
                    <th scope="col">Codigo de caja</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($transfersUser as $user)    
                    <tr>
                      <th scope="row">{{ $loop->iteration }}</th>
                      <th>{{ $user->transferId }}</th>
                      <th>{{ $user->boxId }}</th>
                      <th>
                        <div class="row pl-3"> 
                          {{-- @if ($firstBox->box_state_id == 1) 
                            <form action="{{ route('delete-product-for-box', ['product' => $product->boxDetailId]) }}" method="POST" id="delete-product-for-box-{{ $product->boxDetailId }}">
                              @method('DELETE')
                              @csrf
                            </form>
                            <span class="d-inline-block ml-2" tabindex="0" data-toggle="tooltip" title="{{ __('Eliminar producto') }}">
                              <a href="#" class="text-danger" onclick="deleteProduct('{{ $product->boxDetailId }}')">
                                  <i class="fas fa-trash-alt"></i>
                              </a>
                            </span>
                          @endif --}}
                        </div>
                      </th>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="row">
                <div class="ml-auto pr-3">
                  {{ $transfersUser->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('modal')
  {{-- create-transfer --}}
  <div class="modal fade" id="createModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Crear nuevo traslado') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('create-transfer') }}" method="POST" id="create-transfer">
            @csrf

            {{-- user --}}
            <div class="form-group">
                <select name="userR" id="userR" class="custom-select form-control{{ $errors->has('userR') ? ' is-invalid' : '' }}" required>
                  <option value="0">Seleccione el usuario receptor </option>
                  @foreach ($usersR as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('userR'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('userR') }}</strong>
                  </span>
                @endif
              </div>
              {{-- user --}}

          </form>
        </div>
        <div class="modal-footer">
          <div class="row pr-2">
            <div class="ml-auto">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar')}}</button>
              <button type="button" class="btn btn-success"
                onclick="event.preventDefault();
                document.getElementById('create-transfer').submit();">
                  {{ __('Crear') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- create-transfer --}}

  @if ($errors->has('create'))
  <script>
    $('#createModal').modal('show');
  </script>
  @endif 
@endsection 