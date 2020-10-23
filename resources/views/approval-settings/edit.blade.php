<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header name="Edit Approval Setting" :backUrl="route('approval-settings.index')" />

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
                            @can('delete-approval-settings')
                                <form action="{{ route('approval-settings.destroy', $approval_setting) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" style="display: none">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" id="btn-delete" style="display: none" />
                                </form>
                            @endcan
                            <form role="form" action="{{ route('approval-settings.update', $approval_setting) }}" method="POST" autocomplete="off" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="from_amount">From Amount <span class="text-danger">*</span></label>
                                            <input type="number" name="from_amount" class="form-control @error('from_amount') is-invalid @enderror" id="from_amount" placeholder="From amount" value="{{ old('from_amount') ?? $approval_setting->from_amount }}">
                                            @error('from_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="to_amount">To Amount <span class="text-danger">*</span></label>
                                            <input type="number" name="to_amount" class="form-control @error('to_amount') is-invalid @enderror" id="to_amount" placeholder="To amount" value="{{ old('to_amount') ?? $approval_setting->to_amount }}">
                                            @error('to_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <fieldset class="form-group">
                                            <legend class="col-form-label font-weight-bold">Guarantors <span class="text-danger">*</span> @error('users') <small class="text-danger">{{ $message }}</small> @enderror</legend>
                                            <div class="form-row">
                                                @foreach ($users as $user)
                                                    <div class="col-sm-3">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" id="user-{{ $user->id }}" name="users[]" value="{{ $user->id }}" @if((old('users') && in_array($user->id, old('users'))) || $approval_setting->guarantors->contains('id', $user->id)) checked @endif>
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
                                        @can('delete-approval-settings')
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
