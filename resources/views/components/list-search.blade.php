<form action="" method="GET">
    <div class="input-group">
        <input type="search" name="q" id="q" class="form-control" placeholder="Search here" value="{{ request()->get('q') }}">
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form>
