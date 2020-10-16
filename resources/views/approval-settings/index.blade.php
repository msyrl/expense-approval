<x-app>
    <x-slot name="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-content-header title="Approval Settings" :urls="['Approval Settings' => route('approval-settings.index')]" />

            <!-- Main content -->
            <section class="content">

                <div class="container-fluid">
                    @if (session()->has('alert-success'))
                        <x-alert-success>
                            {!! session()->get('alert-success') !!}
                        </x-alert-success>
                    @endif
                    @if (session()->has('alert-danger'))
                        <x-alert-danger>
                            {!! session()->get('alert-danger') !!}
                        </x-alert-danger>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            @can('create-approval-settings') <a href="{{ route('approval-settings.create') }}" class="btn btn-primary my-2">Create</a> @endcan
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
                                                <input type="hidden" name="page" value="{{ $collection->currentPage() }}">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="container-fluid">
                                        <div class="row p-3 border-top border-bottom d-none d-sm-flex">
                                            <div class="col-12 col-sm">Approval Setting</div>
                                            <div class="col-12 col-sm">Guarantors</div>
                                            <div class="col-12 col-sm">Last Updated</div>
                                            <div class="col-12 col-sm-2 text-right"></div>
                                        </div>
                                        @forelse ($collection as $resource)
                                        <div class="row p-3 border-top border-bottom">
                                            <div class="mb-2 col-12 col-sm">
                                                <div class="d-sm-none">Approval Setting:</div>
                                                <a href="{{ route('approval-settings.show', $resource->id) }}"><strong>{{ ($resource->from_amount_with_separator) }} - {{ $resource->to_amount_with_separator }}</strong></a>
                                            </div>
                                            <div class="mb-2 col-12 col-sm">
                                                <div class="d-sm-none">Guarantors: </div>
                                                @foreach ($resource->guarantors as $index => $user)
                                                    <div class="text-muted">{{ $index + 1 . '. ' . $user->name }}</div>
                                                @endforeach
                                            </div>
                                            <div class="mb-2 col-12 col-sm">
                                                <div class="d-sm-none">Last Updated: </div>
                                                <strong>{{ $resource->updated_at }}</strong>
                                                <div class="text-muted">{{ $resource->updated_at->diffForHumans() }}</div>
                                            </div>
                                            <div class="mb-2 col-12 col-sm-2 text-right">
                                                <div class="btn-group" role="group">
                                                    @can('edit-approval-settings')
                                                        <a href="{{ route('approval-settings.edit', $resource->id) }}" class="btn btn-sm btn-light" tooltip data-placement="bottom" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete-approval-settings')
                                                        <form action="{{ route('approval-settings.destroy', $resource->id) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')">
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
                                            <div class="text-muted my-2">{{ "Showing {$collection->firstItem()}-{$collection->lastItem()} of {$collection->total()}" }}</div>
                                        </div>
                                        <div class="col-auto ml-auto">
                                            {{ $collection->links() }}
                                        </div>
                                    </div>
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
