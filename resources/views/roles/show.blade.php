<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header title="Detail" :urls="['Roles' => route('roles.index'), 'Detail' => route('roles.show', $role->id)]" />

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-primary">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Name</strong>
                                        <div class="text-muted">{{ $role->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Slug</strong>
                                        <div class="text-muted">{{ $role->slug }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Permissions</strong>
                                        <div class="text-muted">{{ $role->joined_permission_names }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Created At</strong>
                                        <div class="text-muted">{{ $role->created_at }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Last Updated</strong>
                                        <div class="text-muted">{{ $role->updated_at }}</div>
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
