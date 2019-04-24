@extends('layouts.custom.app')

@section('content')
  <div class="container pb-0">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header mb-4">
            <div class="row pl-2 pr-2">
              <span>
                {{ __('Gestion de productos') }}
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
                  <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Crear nuevo producto') }}">
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
                  <th scope="col">Codigo</th>
                  <th scope="col">Descripcion</th>
                  <th scope="col">Habilitado</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($products as $key => $product)    
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <th>{{ $product->name }}</th>
                    <th>{{ $product->code }}</th>
                    <th>
                      <span class="d-inline-block" tab-index="0" data-toggle="tooltip"  data-placement="right" title="{{ $product->description }}">
                        <i class="fas fa-eye ml-4"></i>
                      </span>
                    </th>
                    <th class="pl-5">{!! $product->enable ? '<i class="fas fa-thumbs-up text-success"></i>' : '<i class="fas fa-thumbs-down text-danger"></i>' !!}</th>
                    <th>
                      <div class="row pl-4">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Editar producto') }}">
                          <a href="#" class="text-success" onclick='updateModal(@json($product))'>
                            <i class="fas fa-edit"></i>
                          </a>
                        </span>
                        <form action="{{ route('delete-product', ['product' => $product->id]) }}" method="POST" id="delete-product-{{ $product->id }}">
                          @method('DELETE')
                          @csrf
                        </form>
                        <span class="ml-2 d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Eliminar producto') }}">
                          <a href="#" class="text-danger" onclick="deleteProduct('{{ $product->id }}')">
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
                {{ $products->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modal')
  {{-- create-product --}}
  <div class="modal fade" id="createModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Crear nuevo producto') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('create-product') }}" method="POST" id="create-product">
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

              {{-- code --}}
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-key"></i>
                    </span>
                  </div>
                  <input type="text" id="codeCreate" placeholder="Codigo" class="form-control{{ $errors->has('codeCreate') ? ' is-invalid' : '' }}" name="codeCreate" required>
                  @if ($errors->has('codeCreate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('codeCreate') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              {{-- code --}}
              
              {{-- description --}}
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fab fa-amilia"></i>
                    </span>
                  </div>
                  <input type="text" id="descriptionCreate" placeholder="Descripcion" class="form-control{{ $errors->has('descriptionCreate') ? ' is-invalid' : '' }}" name="descriptionCreate" required>
                  @if ($errors->has('descriptionCreate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('descriptionCreate') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              {{-- description --}}

              {{-- Enable --}}
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="enableCreate" name="enableCreate" value="1">
                  <label for="enableCreate" class="custom-control-label">{{ __('Habilitar') }}</label>
                </div>
              </div>
              {{-- Enable --}}

          </form>
        </div>
        <div class="modal-footer">
          <div class="row pr-2">
            <div class="ml-auto">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar')}}</button>
              <button type="button" class="btn btn-success"
                onclick="event.preventDefault();
                document.getElementById('create-product').submit();">
                  {{ __('Crear') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- create-product --}}

  {{-- update-product --}}
  <div class="modal fade" id="updateModal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ __('Edita producto') }}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('update-product') }}" method="POST" id="update-product">
              @method('PATCH')
              @csrf
              
              <input type="hidden" id="currentProductUpdate" name="currentProductUpdate">
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
              
              {{-- description --}}
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fab fa-amilia"></i>
                    </span>
                  </div>
                  <input type="text" id="descriptionUpdate" placeholder="Descripcion" class="form-control{{ $errors->has('descriptionUpdate') ? ' is-invalid' : '' }}" name="descriptionUpdate" required>
                  @if ($errors->has('descriptionUpdate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('descriptionUpdate') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              {{-- description --}}

              {{-- Enable --}}
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="enableUpdate" name="enableUpdate" value="1">
                  <label for="enableUpdate" class="custom-control-label">{{ __('Habilitar') }}</label>
                </div>
              </div>
              {{-- Enable --}}
  
            </form>
          </div>
          <div class="modal-footer">
            <div class="row pr-2">
              <div class="ml-auto">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar')}}</button>
                <button type="button" class="btn btn-success"
                  onclick="event.preventDefault();
                  document.getElementById('update-product').submit();">
                    {{ __('Actualizar') }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- update-product --}}

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
    function updateModal(product) {
      event.preventDefault();
      $('#updateModal').modal('show');
      document.getElementById('currentProductUpdate').value = product.id;
      document.getElementById('nameUpdate').value = product.name;
      document.getElementById('descriptionUpdate').value = product.description;
      document.getElementById('enableUpdate').checked = product.enable;
    }

    function deleteProduct(product) {
      event.preventDefault();
      document.getElementById('delete-product-' + product).submit()
    }
  </script>
@endsection

