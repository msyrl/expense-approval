<div class="row align-items-center">
    <div class="col">
        {{ "{$paginator->firstItem()}-{$paginator->lastItem()} of {$paginator->total()}" }}
    </div>
    <div class="col-auto ml-auto">
        {{ $paginator->withQueryString()->links() }}
    </div>
</div>
