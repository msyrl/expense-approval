<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header title="Edit" :urls="['Categories' => route('categories.index'), 'Edit' => route('categories.create')]" />

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
                            <form role="form" action="{{ route('categories.update', $category->id) }}" method="POST" autocomplete="off" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('categories.index') }}" class="btn btn-link">Cancel</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{ old('name') ?? $category->name }}">
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
