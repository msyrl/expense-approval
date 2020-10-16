<x-app>
    <x-slot name="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-content-header title="Expenses" :urls="['Expenses' => route('expenses.index')]" />

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
                                            @can('create-expenses') <a href="{{ route('expenses.create') }}" class="btn btn-primary my-2">Create</a> @endcan
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
                                            <div class="col-12 col-sm">Recipient</div>
                                            <div class="col-12 col-sm">Source</div>
                                            <div class="col-12 col-sm">Category</div>
                                            <div class="col-12 col-sm">Amount</div>
                                            <div class="col-12 col-sm">Last Updated</div>
                                            <div class="col-12 col-sm-2 text-right"></div>
                                        </div>
                                        @forelse ($collection as $resource)
                                        <div class="row p-3 border-top border-bottom">
                                            <div class="col-12 col-sm">
                                                <div class="d-sm-none">Recipient:</div>
                                                <a href="{{ route('expenses.show', $resource->id) }}"><strong>{{ $resource->recipient }}</strong></a>
                                            </div>
                                            <div class="col-12 col-sm">
                                                <div class="d-sm-none">Source:</div>
                                                <strong>{{ $resource->Source->name }}</strong>
                                            </div>
                                            <div class="col-12 col-sm">
                                                <div class="d-sm-none">Category:</div>
                                                <strong>{{ $resource->category->name }}</strong>
                                            </div>
                                            <div class="col-12 col-sm">
                                                <div class="d-sm-none">Amount</div>
                                                <strong>{{ $resource->amount_with_separator }}</strong>
                                            </div>
                                            <div class="col-12 col-sm">
                                                <div class="d-sm-none">Last Updated: </div>
                                                <strong>{{ $resource->updated_at }}</strong>
                                                <div class="text-muted">{{ $resource->updated_at->diffForHumans() }}</div>
                                            </div>
                                            <div class="col-12 col-sm-2 text-right">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('expenses.print', $resource->id) }}" target="_blank" class="btn btn-sm btn-light" tooltip data-placement="bottom" title="Print">
                                                        <div class="fas fa-print"></div>
                                                    </a>
                                                    @can('edit-expenses')
                                                        <a href="{{ route('expenses.edit', $resource->id) }}" class="btn btn-sm btn-light" tooltip data-placement="bottom" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete-expenses')
                                                        <form action="{{ route('expenses.destroy', $resource->id) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')">
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
