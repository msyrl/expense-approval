<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header name="Role Detail" :backUrl="route('roles.index')" />

            <section class="content">
                <div class="container-fluid">
                    @if (session()->has('error'))
                        <x-alert-danger>
                            {{ session()->get('error') }}
                        </x-alert-danger>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
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
                                        <div class="text-muted">
                                            @forelse ($role->permissions as $permission)
                                                <span class="badge badge-primary">{{ $permission->name }}</span>
                                            @empty
                                                <span>-</span>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Created At</strong>
                                        <div class="text-muted">{{ $role->created_at }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Updated At</strong>
                                        <div class="text-muted">{{ $role->updated_at }}</div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    @can('edit-roles')
                                        <x-edit-button :url="route('roles.edit', $role)" />
                                    @endcan
                                    <x-cancel-button :url="route('roles.index')" />
                                    @can('delete-roles')
                                        <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" style="display: none">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" id="btn-delete" style="display: none" />
                                        </form>
                                        <a href="javascript:void(0)" class="btn btn-outline-danger border-0" onclick="document.getElementById('btn-delete').click()">
                                            <i class="fas fa-trash-alt fa-fw"></i>
                                            <span>DELETE</span>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </x-slot>
</x-app>
