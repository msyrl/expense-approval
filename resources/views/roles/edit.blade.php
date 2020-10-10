<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header title="Edit" :urls="['Roles' => route('roles.index'), 'Edit' => route('roles.create')]" />

            <section class="content">
                <div class="container-fluid">
                    @if (session()->has('alert-success'))
                        <x-alert-success>{!! session()->get('alert-success') !!}</x-alert-success>
                    @endif
                    @if ($errors->any())
                        <x-alert-danger>The given data is invalid.</x-alert-danger>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <form role="form" action="{{ route('roles.update', $role->id) }}" method="POST" autocomplete="off" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('roles.index') }}" class="btn btn-link">Cancel</a>
                                    </div>
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
                                                                <input type="checkbox" class="custom-control-input" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" @if((old('permissions') && in_array($permission->id, old('permissions'))) || ($permission->checked)) checked @endif>
                                                                <label class="custom-control-label font-weight-normal" for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </fieldset>
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
