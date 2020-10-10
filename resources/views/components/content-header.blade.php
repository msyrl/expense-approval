<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @forelse ($urls as $key => $url)
                        @if ($url === end($urls))
                            <li class="breadcrumb-item active">{{ $key }}</li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ $url }}">{{ $key }}</a></li>
                        @endif
                    @empty

                    @endforelse
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
