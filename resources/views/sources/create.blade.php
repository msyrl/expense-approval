<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header name="Create Source" :backUrl="route('categories.index')" />

            <section class="content">
                <div class="container-fluid">
                    @if (session()->has('success'))
                        <x-alert-success>{{ session()->get('success') }}</x-alert-success>
                    @endif
                    @if ($errors->any())
                        <x-alert-danger>The given data is invalid.</x-alert-danger>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <form role="form" action="{{ route('sources.store') }}" method="POST" autocomplete="off" novalidate>
                                @csrf
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{ old('name') }}">
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <x-save-button />
                                        <x-cancel-button :url="route('sources.index')" />
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
