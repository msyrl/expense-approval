<div class="d-flex justify-content-between align-items-center">
    <span>{{ $name }}</span>
    @if (request()->get('sort_by') == $asc)
        <i class="fas fa-sort-alpha-down"></i>
    @endif
    @if (request()->get('sort_by') == $desc)
        <i class="fas fa-sort-alpha-down-alt"></i>
    @endif
</div>
