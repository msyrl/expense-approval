<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header title="Create" :urls="['Users' => route('users.index'), 'Create' => route('users.create')]" />

            <section class="content">
                <div class="container-fluid">
                    @if (session()->has('alert-success'))
                        <x-alert-success>
                            {!! session()->get('alert-success') !!}
                        </x-alert-success>
                    @endif
                    @if ($errors->any())
                        <x-alert-danger>
                            The given data is invalid.
                        </x-alert-danger>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <form role="form" action="{{ route('users.store') }}" method="POST" autocomplete="off" novalidate>
                                @csrf
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <a href="{{ route('users.index') }}" class="btn btn-link">Cancel</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{ old('name') }}">
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Username <span class="text-danger">*</span></label>
                                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Username" value="{{ old('username') }}">
                                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{ old('email') }}">
                                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation">Password Confirmation <span class="text-danger">*</span></label>
                                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Password Confirmation">
                                        </div>
                                        <fieldset class="form-group">
                                            <legend class="col-form-label font-weight-bold">Roles</legend>
                                            <div class="form-row">
                                                @foreach ($roles as $role)
                                                    <div class="col-sm-3">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" id="role-{{ $role->id }}" name="roles[]" value="{{ $role->id }}" @if(old('roles') && in_array($role->id, old('roles'))) checked @endif>
                                                            <label class="custom-control-label font-weight-normal" for="role-{{ $role->id }}">{{ $role->name }}</label>
                                                        </div>
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
