<div>
    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#filterModal">
        <i class="fas fa-sliders-h"></i>
        <span class="d-none d-sm-inline">FILTER</span>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="GET" autocomplete="off">
                <input type="hidden" name="page" value="{{ $paginator->currentPage() }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @isset($body) {!! $body !!} @endisset
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check fa-fw"></i>
                            <span>APPLY</span>
                        </button>
                        <button type="button" class="btn btn-outline-primary border-0" data-dismiss="modal">
                            <i class="fas fa-times fa-fw"></i>
                            <span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
