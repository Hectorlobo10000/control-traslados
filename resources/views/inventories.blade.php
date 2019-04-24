@extends('layouts.custom.app')

@section('content')
  <div class="container pb-0">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header mb-4">
            <div class="row pl-2 pr-2">
              <span>
                {{ __('Inventario') }}
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
                  <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Anadir nuevo item') }}">
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
                  <th scope="col">Producto</th>
                  <th scope="col">Movimiento</th>
                  <th scope="col">Precio</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($inventories as $inventory)    
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <th>{{ $inventory->productName }}</th>
                    <th>{{ $inventory->movementName }}</th>
                    <th>{{ $inventory->balance }}</th>
                    <th>
                      <div class="row pl-4">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Editar producto') }}">
                          <a href="#" class="text-success" onclick='updateProductInventary(@json($inventory))'>
                            <i class="fas fa-edit"></i>
                          </a>
                        </span>
                        <form action="{{ route('delete-inventory', ['inventory' => $inventory->inventoryId]) }}" method="POST" id="delete-inventory-{{ $inventory->inventoryId }}">
                          @method('DELETE')
                          @csrf
                        </form>
                        <span class="ml-2 d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Eliminar movimiento') }}">
                          <a href="#" class="text-danger" onclick="deleteInventory('{{ $inventory->inventoryId }}')">
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
                {{ $inventories->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modal')
  {{-- create-inventory --}}
  <div class="modal fade" id="createModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Crear nuevo producto en inventario') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('create-inventory') }}" method="POST" id="create-inventory">
            @csrf

              {{-- product --}}
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-user"></i>
                    </span>
                  </div>
                  <input type="text" id="productCreate" placeholder="Producto" class="form-control{{ ($errors->has('productCreate') or $errors->has('enableProductCreate')) ? ' is-invalid' : '' }}" name="productCreate" required autofocus>
                  @if ($errors->has('productCreate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('productCreate') }}</strong>
                    </span>
                  @elseif ($errors->has('enableProductCreate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('enableProductCreate') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              {{-- product --}}

              {{-- balance --}}
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fab fa-amilia"></i>
                    </span>
                  </div>
                  <input type="text" id="balanceCreate" placeholder="Precio" class="form-control{{ $errors->has('balanceCreate') ? ' is-invalid' : '' }}" name="balanceCreate" required>
                  @if ($errors->has('balanceCreate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('balanceCreate') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              {{-- balance --}}

          </form>
        </div>
        <div class="modal-footer">
          <div class="row pr-2">
            <div class="ml-auto">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar')}}</button>
              <button type="button" class="btn btn-success"
                onclick="event.preventDefault();
                document.getElementById('create-inventory').submit();">
                  {{ __('Crear') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- create-inventory --}}

  {{-- update-inventory --}}
  <div class="modal fade" id="updateModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Crear nuevo producto en inventario') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('update-inventory') }}" method="POST" id="update-inventory">
            @method('PATCH')
            @csrf

              <input type="hidden" id="currentInventoryUpdate" name="currentInventoryUpdate" required>
              {{-- balance --}}
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fab fa-amilia"></i>
                    </span>
                  </div>
                  <input type="text" id="balanceUpdate" placeholder="Precio" class="form-control{{ $errors->has('balanceUpdate') ? ' is-invalid' : '' }}" name="balanceUpdate" required>
                  @if ($errors->has('balanceUpdate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('balanceUpdate') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              {{-- balance --}}

          </form>
        </div>
        
        <div class="modal-footer">
          <div class="row pr-2">
            <div class="ml-auto">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar')}}</button>
              <button type="button" class="btn btn-success"
                onclick="event.preventDefault();
                document.getElementById('update-inventory').submit();">
                  {{ __('Actualizar') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- update-inventory --}}

  @if ($errors->has('create'))
    <script>
      $('#createModal').modal('show');
    </script>
  @elseif ($errors->has('update'))
    <script>
      $('#updateModal').modal('show');
      document.getElementById('currentInventoryUpdate').value = "{{ old('currentInventoryUpdate') }}";
      document.getElementById('balanceUpdate').value = "{{ old('balanceUpdate') }}";
    </script>
  @endif

  <script>
    function updateProductInventary(inventory) {
      event.preventDefault();
      $('#updateModal').modal('show');
      document.getElementById('currentInventoryUpdate').value = inventory.inventoryId;
      document.getElementById('balanceUpdate').value = inventory.balance;
    }

    function deleteInventory(inventory) {
      event.preventDefault();
      document.getElementById('delete-inventory-' + inventory).submit();
    }
  </script>
@endsection