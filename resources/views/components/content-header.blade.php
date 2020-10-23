<section class="content-header">
    <div class="container-fluid">
        <div class="row align-items-end">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    @isset($backUrl)
                        <a href="{{ $backUrl }}" class="btn btn-link pl-1">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @endisset
                    <h1>{{ $name }}</h1>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
