<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header title="Roles" :urls="['Roles' => route('roles.index')]" />

            <section class="content">

                <div class="container-fluid">
                    @if (session()->has('alert-success'))
                        <x-alert-success>{!! session()->get('alert-success') !!}</x-alert-success>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            @can('create-roles') <a href="{{ route('roles.create') }}" class="btn btn-primary my-2">Create</a> @endcan
                                        </div>
                                        <div class="col-auto ml-auto">
                                            <form action="" method="GET" autocomplete="off">
                                                <div class="form-group row mb-0">
                                                    <label for="sort_by" class="col-form-label col-auto">Sort By</label>
                                                    <div class="col">
                                                        <select name="sort_by" id="sort_by" class="form-control" onchange="this.form.submit()">
                                                            <option value="" hidden>Sort By</option>
                                                            @foreach ($sortables as $name => $sortable)
                                                                <option value="{{ $sortable }}" @if(request()->get('sort_by') === $sortable) selected @endif>{{ $name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="page" value="{{ $roles->currentPage() }}">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="container-fluid">
                                        <div class="row p-3 border-top border-bottom d-none d-sm-flex">
                                            <div class="col-12 col-sm">Role</div>
                                            <div class="col-12 col-sm">Last Updated</div>
                                            <div class="col-12 col-sm-2 text-right"></div>
                                        </div>
                                        @forelse ($roles as $role)
                                        <div class="row p-3 border-top border-bottom">
                                            <div class="col-12 col-sm">
                                                <div class="d-sm-none">Role:</div>
                                                <a href="{{ route('roles.show', $role->id) }}"><strong>{{ $role->name }}</strong></a>
                                                <div class="text-muted">{{ $role->slug }}</div>
                                            </div>
                                            <div class="col-12 col-sm">
                                                <div class="d-sm-none">Last Updated: </div>
                                                <strong>{{ $role->updated_at }}</strong>
                                                <div class="text-muted">{{ $role->updated_at->diffForHumans() }}</div>
                                            </div>
                                            <div class="col-12 col-sm-2 text-right">
                                                <div class="btn-group" role="group">
                                                    @can('edit-roles')
                                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-light" tooltip data-placement="bottom" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete-roles')
                                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-light" tooltip data-placement="bottom" title="Delete">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="row p-3 border-top border-bottom">
                                            <div class="col text-center">Not found.</div>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="text-muted my-2">{{ "Showing {$roles->firstItem()}-{$roles->lastItem()} of {$roles->total()}" }}</div>
                                        </div>
                                        <div class="col-auto ml-auto">
                                            {{ $roles->links() }}
                                        </div>
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
