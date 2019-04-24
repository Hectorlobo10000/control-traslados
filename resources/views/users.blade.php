@extends('layouts.custom.app')

@section('content')
  <div class="container pb-0">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header mb-2">
            <div class="row pl-2 pr-2">
              <span>
                {{ __('Gestion de usuarios') }}
              </span>
              {{-- <form class="form-inline ml-auto">
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
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Crear nuevo usuario') }}">
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
                  <th scope="col">Sucursal</th>
                  <th scope="col">Rol</th>
                  <th scope="col">Correo</th>
                  <th scope="col">Habilitado</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)    
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <th>{{ $user->name }}</th>
                    <th>{{ $user->nameBranchOffice }}</th>
                    <th>{{ $user->roleName }}</th>
                    <th>{{ $user->email }}</th>
                    <th class="pl-5">{!! $user->enable ? '<i class="fas fa-thumbs-up text-success"></i>' : '<i class="fas fa-thumbs-down text-danger"></i>' !!}</th>
                    <th>
                      <div class="row pl-4">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Editar usuario') }}">
                          <a href="#" class="text-success" onclick='updateModal(@json($user), "{{ asset("storage/avatars") }}")'>
                            <i class="fas fa-edit"></i>
                          </a>
                        </span>
                        <form action="{{ route('delete-user', ['user' => $user->id]) }}" method="POST" id="delete-user-{{ $user->id }}">
                          @method('DELETE')
                          @csrf
                        </form>
                        <span class="ml-2 d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ __('Eliminar usuario') }}">
                          <a href="#" class="text-danger" onclick="deleteUser('{{ $user->id }}')">
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
                {{ $users->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modal')
  {{-- create-user --}}
  <div class="modal fade" id="createModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Crear nuevo usuario') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('create-user') }}" method="POST" id="create-user" enctype="multipart/form-data">
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

              {{-- E-mail --}}
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                          <i class="fa fa-envelope"></i>
                      </span>
                    </div>
                    <input type="email" id="emailCreate" placeholder="Correo" class="form-control{{ $errors->has('emailCreate') ? ' is-invalid' : '' }}" name="emailCreate" required>
                    @if ($errors->has('emailCreate'))
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('emailCreate') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
              {{-- E-mail --}}

              {{-- Seleccionar-foto --}}
              <div class="form-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input form-control{{ $errors->has('avatarCreate') ? ' is-invalid' : '' }}" id="avatarCreate" name="avatarCreate">
                  <label for="avatarCreate" class="custom-file-label">{{ __('Seleccionar avatar') }}</label>
                  @if ($errors->has('avatarCreate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('avatarCreate') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              {{-- Seleccionar-foto --}}

              {{-- Enable --}}
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="enableCreate" name="enableCreate" value="1">
                  <label for="enableCreate" class="custom-control-label">{{ __('Habilitar') }}</label>
                </div>
              </div>
              {{-- Enable --}}

              {{-- Role --}}
              <div class="form-group">
                {{-- <label for="role">Role</label> --}}
                <select name="roleCreate" id="roleCreate" class="custom-select form-control{{ $errors->has('roleCreate') ? ' is-invalid' : '' }}" required>
                  <option selected value="0">Seleccione un rol</option>
                  @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('roleCreate'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('roleCreate') }}</strong>
                  </span>
                @endif
              </div>
              {{-- Role --}}

              {{-- Branch-Officess --}}
              <div class="form-group">
                <select name="branchOfficeCreate" id="branchOfficeCreate" class="custom-select form-control{{ $errors->has('branchOfficeCreate') ? ' is-invalid' : '' }}" required>
                  <option value="0">Seleccione un sucursal</option>
                  @foreach ($branchOffices as $branchOffice)
                    <option value="{{ $branchOffice->id }}">{{ $branchOffice->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('branchOfficeCreate'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('branchOfficeCreate') }}</strong>
                  </span>
                @endif
              </div>
              {{-- Branch-Officess --}}

            {{-- </div> --}}
          </form>
        </div>
        <div class="modal-footer">
          <div class="row pr-2">
            <div class="ml-auto">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar')}}</button>
              <button type="button" class="btn btn-success"
                onclick="event.preventDefault();
                document.getElementById('create-user').submit();">
                  {{ __('Crear') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- create-user --}}

  {{-- update-user --}}
  <div class="modal fade" id="updateModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Editar usuario') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('update-user') }}"  method="POST" id="update-user" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="form-group row">
              
              <input type="hidden" id="currentUserUpdate" name="currentUserUpdate" required>

              {{-- avatar --}}
              <div class="container-fluid col-4">
                <div class="d-flex justify-content-center">
                  <img src="" id="avatarImg" class="img-fluid img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
              </div>
              {{-- avatar --}}

              <div class="col-8">
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

              </div>
            </div>

              {{-- Seleccionar-avatar --}}
              <div class="form-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input form-control{{ $errors->has('avatarUpdate') ? ' is-invalid' : '' }}" id="avatarUpdate" name="avatarUpdate">
                  <label for="avatarUpdate" class="custom-file-label">{{ __('Seleccionar avatar')}}</label>
                  @if ($errors->has('avatarUpdate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('avatarUpdate') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              {{-- Seleccionar-avatar --}}

              {{-- Enable --}}
              <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="enableUpdate" name="enableUpdate" value="1">
                    <label for="enableUpdate" class="custom-control-label">{{ __('Habilitar') }}</label>
                  </div>
                </div>
                {{-- Enable --}}
  
                {{-- Role --}}
                <div class="form-group">
                  {{-- <label for="role">Role</label> --}}
                  <select name="roleUpdate" id="roleUpdate" class="custom-select form-control{{ $errors->has('roleUpdate') ? ' is-invalid' : '' }}">
                    <option selected value="0">Seleccione un rol</option>
                    @foreach ($roles as $role)
                      <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('roleUpdate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('roleUpdate') }}</strong>
                    </span>
                  @endif
                </div>
                {{-- Role --}}
  
                {{-- Branch-Officess --}}
                <div class="form-group">
                  <select name="branchOfficeUpdate" id="branchOfficeUpdate" class="custom-select form-control{{ $errors->has('branchOfficeUpdate') ? ' is-invalid' : '' }}">
                    <option value="0">Seleccione un sucursal</option>
                    @foreach ($branchOffices as $branchOffice)
                      <option value="{{ $branchOffice->id }}">{{ $branchOffice->name }}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('branchOfficeUpdate'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('branchOfficeUpdate') }}</strong>
                    </span>
                  @endif
                </div>
                {{-- Branch-Officess --}}

          </form>
        </div>
        <div class="modal-footer">
            <div class="row pr-2">
              <div class="ml-auto">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar')}}</button>
                <button type="button" class="btn btn-success"
                  onclick="event.preventDefault();
                  document.getElementById('update-user').submit();">
                    {{ __('Actualizar') }}
                </button>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
  {{-- update-user --}}


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
    function updateModal(user, avatar) {
      event.preventDefault();
      $('#updateModal').modal('show');
      document.getElementById('avatarImg').src = '{{ asset("storage/avatars") }}/' + user.avatar;
      document.getElementById('nameUpdate').value = user.name;
      document.getElementById('enableUpdate').checked = user.enable;
      document.getElementById('roleUpdate').value = user.roleId;
      document.getElementById('branchOfficeUpdate').value = user.branchOfficeId;
      document.getElementById('currentUserUpdate').value = user.id;
    }

    function deleteUser(user) {
      event.preventDefault();
      document.getElementById('delete-user-' + user).submit()
    }
  </script>
@endsection

