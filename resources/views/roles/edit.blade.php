<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header name="Edit Role" :backUrl="route('roles.index')" />

            <section class="content">
                <div class="container-fluid">
                    @if (session()->has('success'))
                        <x-alert-success>
                            {{ session()->get('success') }}
                        </x-alert-success>
                    @endif
                    @if (session()->has('error'))
                        <x-alert-danger>
                            {{ session()->get('error') }}
                        </x-alert-danger>
                    @endif
                    @if ($errors->any())
                        <x-alert-danger>
                            The given data is invalid.
                        </x-alert-danger>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            @can('delete-roles')
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" style="display: none">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" id="btn-delete" style="display: none" />
                                </form>
                            @endcan
                            <form role="form" action="{{ route('roles.update', $role) }}" method="POST" autocomplete="off" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{ old('name') ?? $role->name }}">
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="slug">Slug</label>
                                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug" placeholder="Rolename" value="{{ old('slug') ?? $role->slug }}">
                                            <small class="form-text text-muted">* Optional. Leave it blank for auto generate.</small>
                                            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <fieldset class="form-group">
                                            <legend class="col-form-label font-weight-bold">Permissions</legend>
                                            <div class="form-row">
                                                @foreach ($permissions->chunk(4) as $chunk)
                                                    <div class="col-sm-3">
                                                        @foreach ($chunk as $permission)
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" @if((old('permissions') && in_array($permission->id, old('permissions'))) || $role->permissions->contains('id', $permission->id)) checked @endif>
                                                                <label class="custom-control-label font-weight-normal" for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="card-footer">
                                        <x-save-button />
                                        <x-cancel-button :url="route('roles.index')" />
                                        @can('delete-roles')
                                            <a href="javascript:void(0)" class="btn btn-outline-danger border-0" onclick="document.getElementById('btn-delete').click()">
                                                <i class="fas fa-trash-alt fa-fw"></i>
                                                <span>DELETE</span>
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </x-slot>
</x-app>
