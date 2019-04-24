@extends('layouts.custom.app')

@section('content')
  <div class="container pb-0">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header mb-4">
            <div class="row pl-2 pr-2">
              <span>
                {{ __('Gestion de sucursales') }}
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
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Crear nueva sucursal') }}">
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
                  <th scope="col">Direccion</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($branchOfficesDepartments as $branchOffice)    
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <th>{{ $branchOffice->name }}</th>
                    <th>{{ $branchOffice->abbreviation }}</th>
                    <th>
                      <span class="d-inline-block text-secondary" tab-index="0" data-toggle="tooltip"  data-placement="right" title="{{ $branchOffice->address }}; {{ $branchOffice->city }}; {{ $branchOffice->department }}">
                        <i class="fas fa-eye ml-4"></i>
                      </span>
                    </th>
                    <th>
                      <div class="row pl-4">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Editar sucursal') }}">
                          <a href="#" class="text-success" onclick='updateModal(@json($branchOffice))'>
                            <i class="fas fa-edit"></i>
                          </a>
                        </span>
                        <form action="{{ route('delete-branch-office', ['branchOffice' => $branchOffice->id]) }}" method="POST" id="delete-branch-office-{{ $branchOffice->id }}">
                          @method('DELETE')
                          @csrf
                        </form>
                        <span class="ml-2 d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Eliminar sucursal') }}">
                          <a href="#" class="text-danger" onclick="deleteBranchOffice('{{ $branchOffice->id }}')">
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
                {{ $branchOfficesDepartments->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modal')
  {{-- create-branch-office --}}
  <div class="modal fade" id="createModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Crear nueva sucursal') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('create-branch-office') }}" method="POST" id="create-branch-office">
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
  
              {{-- cities --}}
              <div class="form-group">
                <select name="cityCreate" id="cityCreate" class="custom-select form-control{{ $errors->has('cityCreate') ? ' is-invalid' : '' }}" required>
                  <option value="0">Seleccione una ciudad</option>
                  @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->nameCity }}, {{ $city->nameDepartment }} </option>
                  @endforeach
                </select>
                @if ($errors->has('cityCreate'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('cityCreate') }}</strong>
                  </span>
                @endif
              </div>
              {{-- cities --}}

              {{-- address-description --}}
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-address-card"></i>
                    </span>
                  </div>
                  <input type="text" id="addressCreate" placeholder="Descripcion de la direccion" class="form-control{{ $errors->has('addressCreate') ? ' is-invalid' : '' }}" name="addressCreate" required>
                  @if ($errors->has('addressCreate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('addressCreate') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              {{-- address-description --}}

          </form>
        </div>
        <div class="modal-footer">
          <div class="row pr-2">
            <div class="ml-auto">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar')}}</button>
              <button type="button" class="btn btn-success"
                onclick="event.preventDefault();
                document.getElementById('create-branch-office').submit();">
                  {{ __('Crear') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- create-branch-office --}}

  {{-- create-branch-office --}}
  <div class="modal fade" id="updateModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Editar sucursal') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('update-branch-office') }}" method="POST" id="update-branch-office">
            @method('PATCH')
            @csrf

            <input type="hidden" id="currentBranchOfficeUpdate" name="currentBranchOfficeUpdate" required>
            <input type="hidden" id="currentAddressUpdate" name="currentAddressUpdate" required>

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

              {{-- address-description --}}
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-address-card"></i>
                    </span>
                  </div>
                  <input type="text" id="addressUpdate" placeholder="Descripcion de la direccion" class="form-control{{ $errors->has('addressUpdate') ? ' is-invalid' : '' }}" name="addressUpdate" required>
                  @if ($errors->has('addressUpdate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('addressUpdate') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              {{-- address-description --}}

          </form>
        </div>
        <div class="modal-footer">
          <div class="row pr-2">
            <div class="ml-auto">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar')}}</button>
              <button type="button" class="btn btn-success"
                onclick="event.preventDefault();
                document.getElementById('update-branch-office').submit();">
                  {{ __('Actualizar') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- create-branch-office --}}

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
    function updateModal(branchOffice) {
      event.preventDefault();
      $('#updateModal').modal('show');
      document.getElementById('currentBranchOfficeUpdate').value = branchOffice.id;
      document.getElementById('currentAddressUpdate').value = branchOffice.addressId;
      document.getElementById('nameUpdate').value = branchOffice.name;
      document.getElementById('abbreviationUpdate').value = branchOffice.abbreviation;
      document.getElementById('addressUpdate').value = branchOffice.address;
    }

    function deleteBranchOffice(branchOffice) {
      event.preventDefault();
      document.getElementById('delete-branch-office-' + branchOffice).submit();
    }
  </script>
@endsection