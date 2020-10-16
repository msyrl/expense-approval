<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header title="Detail" :urls="['Categories' => route('sources.index'), 'Detail' => route('sources.show', $source->id)]" />

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-primary">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Name</strong>
                                        <div class="text-muted">{{ $source->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Created At</strong>
                                        <div class="text-muted">{{ $source->created_at }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Last Updated</strong>
                                        <div class="text-muted">{{ $source->updated_at }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </x-slot>
</x-app>
