<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header title="Edit" :urls="['Expenses' => route('expenses.index'), 'Edit' => route('expenses.create')]" />

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
                            <form role="form" action="{{ route('expenses.update', $expense->id) }}" method="POST" autocomplete="off" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('expenses.index') }}" class="btn btn-link">Cancel</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="source_id">Source <span class="text-danger">*</span></label>
                                            <select name="source_id" id="source_id" class="form-control @error('source_id') is-invalid @enderror">
                                                <option value="">-- Select source --</option>
                                                @foreach ($sources as $source)
                                                    <option value="{{ $source->id }}" @if((old('source_id') && old('source_id') == $source->id) || $expense->source_id == $source->id) selected @endif>{{ $source->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('source_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="category_id">Category <span class="text-danger">*</span></label>
                                            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                                <option value="">-- Select category --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @if((old('category_id') && old('category_id') == $category->id) || $expense->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient">Recipient <span class="text-danger">*</span></label>
                                            <input type="text" name="recipient" class="form-control @error('recipient') is-invalid @enderror" id="recipient" placeholder="Recipient" value="{{ old('recipient') ?? $expense->recipient }}">
                                            @error('recipient') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Amount <span class="text-danger">*</span></label>
                                            <input type="hidden" name="amount" value="{{ $expense->amount }}">
                                            <div>{{ $expense->amount_with_separator }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="4" placeholder="Description">{{ old('description') ?? $expense->description }}</textarea>
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
