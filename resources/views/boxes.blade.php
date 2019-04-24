@extends('layouts.custom.app')

@section('content')
  <div class="container pb-0 mb-4">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header mb-4">
            <div class="row pl-2 pr-2">
              <span>
                {{ __('Gestion de cajas') }}
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
              </div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Codigo</th>
                  <th scope="col">Destalles</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($boxes as $box)    
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <th>{{ $box->code }}</th>
                    <th>
                      <form action="{{ route('products-for-box', ['box' => $box->id ]) }}" method="get" id="products-for-box-{{ $box->id }}">
                        @csrf
                      </form>
                      <span class="d-inline-block" tab-index="0" data-toggle="tooltip"  data-placement="right" title="{{ __('Ver productos en caja') }}">
                        <a href="#" class="text-secondary" onclick='showProducts("{{ $box->id }}")'>
                          <i class="fas fa-eye ml-4"></i>
                        </a>  
                      </span>
                    </th>
                    <th>{{ $box->state }}</th>
                    <th>
                      <div class="row pl-3">
                        @if ($box->box_state_id == 1)    
                          <span class="d-inline-block ml-3" tabindex="0" data-toggle="tooltip" title="{{ __('Agregar producto') }}">
                            <a href="#" class="text-secondary" onclick="addProduct({{ $box->id }})">
                              <i class="fas fa-plus"></i>
                            </a>
                          </span>
                          <span class="d-inline-block ml-2" tabindex="0" data-toggle="tooltip" title="{{ __('Editar caja') }}">
                            <a href="#" class="text-success" onclick='updateModal(@json($box))'>
                              <i class="fas fa-edit"></i>
                            </a>
                          </span>
                          {{-- <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Eliminar caja') }}">
                            <a href="#" class="text-danger">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                          </span> --}}
                        @endif
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

  <div class="container pb-0">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header mb-4">
            <div class="row pl-2 pr-2">
              <span>
                {{ __('Productos en caja') }} 
                <strong>
                  {{ $firstBox->code }}
                </strong>
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
                  <th scope="col">Nombre</th>
                  <th scope="col">Codigo</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($products as $product)    
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <th>{{ $product->productName }}</th>
                    <th>{{ $product->productCode }}</th>
                    <th>
                      <div class="row pl-3"> 
                        @if ($firstBox->box_state_id == 1) 
                          <form action="{{ route('delete-product-for-box', ['product' => $product->boxDetailId]) }}" method="POST" id="delete-product-for-box-{{ $product->boxDetailId }}">
                            @method('DELETE')
                            @csrf
                          </form>
                          <span class="d-inline-block ml-2" tabindex="0" data-toggle="tooltip" title="{{ __('Eliminar producto') }}">
                            <a href="#" class="text-danger" onclick="deleteProduct('{{ $product->boxDetailId }}')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                          </span>
                        @endif
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
@endsection

@section('modal')
  {{-- update-caja --}}
  <div class="modal fade" id="updateModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Actualizar caja') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('update-box') }}" method="POST" id="update-box">
            @method('PATCH')
            @csrf

            <input type="hidden" id="currentBoxUpdate" name="currentBoxUpdate" required>
            {{-- box-states --}}
            <div class="form-group">
              <select name="boxStateUpdate" id="boxStateUpdate" class="custom-select form-control{{ $errors->has('boxStateUpdate') ? ' is-invalid' : '' }}" required>
                <option value="0">Seleccione el estado de la caja </option>
                @foreach ($boxStates as $boxState)
                  <option value="{{ $boxState->id }}">{{ $boxState->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('boxStateUpdate'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('boxStateUpdate') }}</strong>
                </span>
              @endif
            </div>
            {{-- box-states --}}

          </form>
        </div>
        <div class="modal-footer">
          <div class="row pr-2">
            <div class="ml-auto">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar')}}</button>
              <button type="button" class="btn btn-success"
                onclick="event.preventDefault();
                document.getElementById('update-box').submit();">
                  {{ __('Actualizar') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- update-movement --}}
  
  {{-- add-product --}}
  <div class="modal fade" id="addModal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ __('Anadir producto') }}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('add-product') }}" method="POST" id="add-product">
              @csrf
              <input type="hidden" id="currentBoxAdd" name="currentBoxAdd" value="{{ $firstBox->id }}" required>
                {{-- product --}}
                <div class="form-group">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                          <i class="fab fa-product-hunt"></i>
                      </span>
                    </div>
                    <input type="text" id="productAdd" placeholder="Producto" class="form-control{{ ($errors->has('productAdd') or $errors->has('enableProductAdd') or $errors->has('productInBranchOffice')) ? ' is-invalid' : '' }}" name="productAdd" required autofocus>
                    @if ($errors->has('productAdd'))
                      <span class="invalid-feedback" role="alert">
                        <strong>
                          {{ $errors->first('productAdd') }}
                        </strong>
                      </span>
                    @elseif ($errors->has('enableProductAdd'))
                      <span class="invalid-feedback" role="alert">
                        <strong>
                          {{ $errors->first('enableProductAdd') }}
                        </strong>
                      </span>
                    @elseif ($errors->has('productInBranchOffice'))
                      <span class="invalid-feedback" role="alert">
                        <strong>
                          {{ $errors->first('productInBranchOffice') }}
                        </strong>
                      </span>
                    @endif
                  </div>
                </div>
                {{-- product --}}
  
            </form>
          </div>
          <div class="modal-footer">
            <div class="row pr-2">
              <div class="ml-auto">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar')}}</button>
                <button type="button" class="btn btn-success"
                  onclick="event.preventDefault();
                  document.getElementById('add-product').submit();">
                    {{ __('Anadir') }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  {{-- add-product --}}

  @if ($errors->has('updateBox'))
  <script>
    $('#updateModal').modal('show');
  </script>
  @elseif ($errors->has('add'))
  <script>
    $('#addModal').modal('show');
  </script>
  @endif 

  <script>
    function updateModal(box) {
      event.preventDefault();
      $('#updateModal').modal('show');
      document.getElementById('currentBoxUpdate').value = box.id;
      document.getElementById('boxStateUpdate').value = box.box_state_id;
    }

    function showProducts(box) {
      event.preventDefault();
      document.getElementById('products-for-box-' + box).submit();
    }

    function addProduct(box) {
      $('#addModal').modal('show');
      event.preventDefault();
      document.getElementById('currentBoxAdd').value = box;
    }

    function deleteProduct(product) {
      event.preventDefault();
      document.getElementById('delete-product-for-box-' + product).submit();
    }
  </script>
@endsection