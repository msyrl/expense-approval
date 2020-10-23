<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header name="User Detail" :backUrl="route('users.index')" />

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
                                        <div class="text-muted">
                                            @forelse ($user->roles as $role)
                                                <span class="badge badge-primary">{{ $role->name }}</span>
                                            @empty
                                                <span>-</span>
                                            @endforelse
                                        </div>
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
                                <div class="card-footer">
                                    @can('edit-users')
                                        <x-edit-button :url="route('users.edit', $user)" />
                                    @endcan
                                    <x-cancel-button :url="route('users.index')" />
                                    @can('delete-users')
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" style="display: none">
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
