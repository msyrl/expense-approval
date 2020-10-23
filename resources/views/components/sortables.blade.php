<div class="form-group">
    <label for="sort_by">Sort By</label>
    <select name="sort_by" id="sort_by" class="form-control">
        <option value="" hidden>Sort By</option>
        @foreach ($sortables as $sortable)
            <option value="{{ $sortable->value }}" @if(request()->get('sort_by') === $sortable->value) selected @endif>{{ $sortable->name }}</option>
        @endforeach
    </select>
</div>
