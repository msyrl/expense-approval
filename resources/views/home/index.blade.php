<x-app>
    <x-slot name="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-content-header title="Home" :urls="['Home' => '#']" />

            <!-- Main content -->
            <section class="content">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Welcome to {{ config('app.name') }}</h3>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </x-slot>
</x-app>
