<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header title="My Profile" :urls="['My Profile' => route('profile.index')]" />

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
                            <form role="form" action="{{ route('profile.update') }}" method="POST" autocomplete="off" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('profile.index') }}" class="btn btn-link">Cancel</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{ old('name') ?? $user->name }}">
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Username <span class="text-danger">*</span></label>
                                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Username" value="{{ old('username') ?? $user->username }}">
                                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{ old('email') ?? $user->email }}">
                                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="old_password">Old Password</label>
                                            <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" placeholder="Password" value="{{ old('old_password') }}">
                                            <small class="form-text text-muted">* Optional.</small>
                                            @error('old_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" value="{{ old('password') }}">
                                            <small class="form-text text-muted">* Optional. Required if old password is filled.</small>
                                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation">Password Confirmation</label>
                                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Password Confirmation" value="{{ old('password_confirmation') }}">
                                            <small class="form-text text-muted">* Optional. Required if old password is filled.</small>
                                        </div>
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
