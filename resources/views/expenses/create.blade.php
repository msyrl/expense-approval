<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header title="Create" :urls="['Expenses' => route('expenses.index'), 'Create' => route('expenses.create')]" />

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
                            <form role="form" action="{{ route('expenses.store') }}" method="POST" autocomplete="off" novalidate>
                                @csrf
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <a href="{{ route('expenses.index') }}" class="btn btn-link">Cancel</a>
                                    </div>
                                    <div class="card-body">
                                        <fieldset class="form-group">
                                            <legend class="col-form-label font-weight-bold">Categories <span class="text-danger">*</span><small class="text-danger font-weight-normal">@error('categories') {{ $message }} @enderror</small></legend>
                                            <div class="row">
                                                @foreach ($categories as $category)
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="categories[]" id="category_id_{{ $category->id }}" value="{{ $category->id }}" @if(old('categories') && in_array($category->id, old('categories'))) checked @endif>
                                                            <label class="form-check-label" for="category_id_{{ $category->id }}">
                                                                {{ $category->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </fieldset>
                                        <div class="form-group">
                                            <label for="recipient">Recipient <span class="text-danger">*</span></label>
                                            <input type="text" name="recipient" class="form-control @error('recipient') is-invalid @enderror" id="recipient" placeholder="Recipient" value="{{ old('recipient') }}">
                                            @error('recipient') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Amount <span class="text-danger">*</span></label>
                                            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" id="amount" placeholder="Amount" value="{{ old('amount') }}">
                                            @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="4" placeholder="Description">{{ old('description') }}</textarea>
                                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
