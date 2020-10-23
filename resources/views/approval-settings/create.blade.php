<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header name="Create Approval Setting" :backUrl="route('approval-settings.index')" />

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
                            <form role="form" action="{{ route('approval-settings.store') }}" method="POST" autocomplete="off" novalidate>
                                @csrf
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="from_amount">From Amount <span class="text-danger">*</span></label>
                                            <input type="number" name="from_amount" class="form-control @error('from_amount') is-invalid @enderror" id="from_amount" placeholder="From amount" value="{{ old('from_amount') }}">
                                            @error('from_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="to_amount">To Amount <span class="text-danger">*</span></label>
                                            <input type="number" name="to_amount" class="form-control @error('to_amount') is-invalid @enderror" id="to_amount" placeholder="To amount" value="{{ old('to_amount') }}">
                                            @error('to_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <fieldset class="form-group">
                                            <legend class="col-form-label font-weight-bold">Guarantors <span class="text-danger">*</span> @error('users') <small class="text-danger">{{ $message }}</small> @enderror</legend>
                                            <div class="form-row">
                                                @foreach ($users as $user)
                                                    <div class="col-sm-3">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" id="user-{{ $user->id }}" name="users[]" value="{{ $user->id }}" @if(old('users') && in_array($user->id, old('users'))) checked @endif>
                                                            <label class="custom-control-label font-weight-normal" for="user-{{ $user->id }}">{{ $user->name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="card-footer">
                                        <x-save-button />
                                        <x-cancel-button :url="route('approval-settings.index')" />
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
