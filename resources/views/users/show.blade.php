<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header title="Detail" :urls="['Users' => route('users.index'), 'Detail' => route('users.show', $user->id)]" />

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-primary">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Name</strong>
                                        <div class="text-muted">{{ $user->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Username</strong>
                                        <div class="text-muted">{{ $user->username }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Email</strong>
                                        <div class="text-muted">{{ $user->email }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Roles</strong>
                                        <div class="text-muted">{{ $user->joined_role_names }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Created At</strong>
                                        <div class="text-muted">{{ $user->created_at }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Last Updated</strong>
                                        <div class="text-muted">{{ $user->updated_at }}</div>
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
