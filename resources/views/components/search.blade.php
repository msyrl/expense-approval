<!-- SEARCH FORM -->
<form class="form-inline ml-3">
    <div class="input-group input-group-sm">
        <input name="q" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" value="{{ request()->get('q') }}">
        <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form>
