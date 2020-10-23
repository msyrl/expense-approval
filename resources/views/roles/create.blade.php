<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header name="Create Role" :backUrl="route('roles.index')" />

            <section class="content">
                <div class="container-fluid">
                    @if (session()->has('success'))
                        <x-alert-success>
                            {{ session()->get('success') }}
                        </x-alert-success>
                    @endif
                    @if ($errors->any())
                        <x-alert-danger>
                            The given data is invalid.
                        </x-alert-danger>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <form role="form" action="{{ route('roles.store') }}" method="POST" autocomplete="off" novalidate>
                                @csrf
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{ old('name') }}">
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="slug">Slug</label>
                                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug" placeholder="Slug" value="{{ old('slug') }}">
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
                                                                <input type="checkbox" class="custom-control-input" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" @if(old('permissions') && in_array($permission->id, old('permissions'))) checked @endif>
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
