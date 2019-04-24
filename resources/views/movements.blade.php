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

@section('modal')
  {{-- create-movement --}}
  <div class="modal fade" id="createModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Crear nuevo movimiento') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('create-movement') }}" method="POST" id="create-movement">
            @csrf

              {{-- name --}}
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-user"></i>
                    </span>
                  </div>
                  <input type="text" id="nameCreate" placeholder="Nombre" class="form-control{{ $errors->has('nameCreate') ? ' is-invalid' : '' }}" name="nameCreate" required autofocus>
                  @if ($errors->has('nameCreate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('nameCreate') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              {{-- name --}}

              {{-- abbreviation --}}
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fab fa-amilia"></i>
                    </span>
                  </div>
                  <input type="text" id="abbreviationCreate" placeholder="Abreviatura" class="form-control{{ $errors->has('abbreviationCreate') ? ' is-invalid' : '' }}" name="abbreviationCreate" required>
                  @if ($errors->has('abbreviationCreate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('abbreviationCreate') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              {{-- abbreviation --}}

          </form>
        </div>
        <div class="modal-footer">
          <div class="row pr-2">
            <div class="ml-auto">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar')}}</button>
              <button type="button" class="btn btn-success"
                onclick="event.preventDefault();
                document.getElementById('create-movement').submit();">
                  {{ __('Crear') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- create-movement --}}

  {{-- update-movement --}}
  <div class="modal fade" id="updateModal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ __('Actualizar movimiento') }}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('update-movement') }}" method="POST" id="update-movement">
              @method('PATCH')
              @csrf
  
                <input type="hidden" id="currentMovementUpdate" name="currentMovementUpdate" required>
                {{-- name --}}
                <div class="form-group">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                          <i class="fa fa-user"></i>
                      </span>
                    </div>
                    <input type="text" id="nameUpdate" placeholder="Nombre" class="form-control{{ $errors->has('nameUpdate') ? ' is-invalid' : '' }}" name="nameUpdate" required autofocus>
                    @if ($errors->has('nameUpdate'))
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('nameUpdate') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                {{-- name --}}
  
                {{-- abbreviation --}}
                <div class="form-group">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                          <i class="fab fa-amilia"></i>
                      </span>
                    </div>
                    <input type="text" id="abbreviationUpdate" placeholder="Abreviatura" class="form-control{{ $errors->has('abbreviationUpdate') ? ' is-invalid' : '' }}" name="abbreviationUpdate" required>
                    @if ($errors->has('abbreviationUpdate'))
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('abbreviationUpdate') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                {{-- abbreviation --}}
  
            </form>
          </div>
          <div class="modal-footer">
            <div class="row pr-2">
              <div class="ml-auto">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar')}}</button>
                <button type="button" class="btn btn-success"
                  onclick="event.preventDefault();
                  document.getElementById('update-movement').submit();">
                    {{ __('Actualizar') }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- update-movement --}}

    @if ($errors->has('create'))
    <script>
      $('#createModal').modal('show');
    </script>
    @elseif ($errors->has('update'))
      <script>
        $('#updateModal').modal('show');
      </script>
    @endif

    <script>
      function updateModal(movement) {
        event.preventDefault();
        $('#updateModal').modal('show');
        document.getElementById('currentMovementUpdate').value = movement.id;
        document.getElementById('nameUpdate').value = movement.name;
        document.getElementById('abbreviationUpdate').value = movement.abbreviation;
      }

      function deleteMovement(movement) {
        event.preventDefault();
        document.getElementById('delete-movement-' + movement).submit();
      }

    </script>
@endsection