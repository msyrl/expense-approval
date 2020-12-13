<x-app>
    <x-slot name="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-content-header name="Expenses" />

            <!-- Main content -->
            <section class="content">

                <div class="container-fluid">
                    @if (session()->has('success'))
                        <x-alert-success>{{ session()->get('success') }}</x-alert-success>
                    @endif
                    @if (session()->has('error'))
                        <x-alert-danger>{{ session()->get('error') }}</x-alert-danger>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <div class="row px-1 mb-2">
                                <div class="col-12 col-sm-4 px-1 mb-2">
                                    <x-list-search />
                                </div>
                                <div class="col-auto px-1 ml-auto">
                                    <x-filter-modal :paginator="$expenses">
                                        <x-slot name="body">
                                            <x-sortables :sortables="$sortables" />
                                        </x-slot>
                                    </x-filter-modal>
                                </div>
                                <div class="col-auto px-1">
                                    <a href="{{ route('expenses.export', request()->all())  }}" target="_blank" class="btn btn-outline-primary">
                                        <i class="fas fa-download fa-fw"></i>
                                        <span class="d-none d-sm-inline">EXPORT</span>
                                    </a>
                                </div>
                                <div class="col-auto px-1">
                                    @can('create-expenses')
                                        <x-create-button :url="route('expenses.create')" />
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-none d-sm-block">
                                        <div class="row">
                                            <div class="col-12 col-sm text-muted">
                                                <x-list-header name="Recipient" asc="recipient|asc" desc="recipient|desc" />
                                            </div>
                                            <div class="col-12 col-sm text-muted">
                                                <x-list-header name="Source" asc="source_id|asc" desc="source_id|desc" />
                                            </div>
                                            <div class="col-12 col-sm text-muted">
                                                <x-list-header name="Category" asc="category_id|asc" desc="category_id|desc" />
                                            </div>
                                            <div class="col-12 col-sm text-muted">
                                                <x-list-header name="Amount" asc="amount|asc" desc="amount|desc" />
                                            </div>
                                            <div class="col-12 col-sm text-muted">Approvals</div>
                                            <div class="col-12 col-sm text-muted">Created At</div>
                                            <div class="col-12 col-sm-1 text-right"></div>
                                        </div>
                                    </li>
                                    @forelse ($expenses as $expense)
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none text-muted">Recipient:</div>
                                                    <div>{{ $expense->recipient }}</div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none text-muted">Source:</div>
                                                    <div>{{ $expense->source->name }}</div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none text-muted">Category:</div>
                                                    <div>{{ $expense->category->name }}</div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none text-muted">Amount</div>
                                                    <div>{{ $expense->amount_with_separator }}</div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none text-muted">Approvals</div>
                                                    <div>
                                                        @foreach ($expense->approvals as $approval)
                                                            @switch($approval->approval_status->id)
                                                                @case(App\Models\ApprovalStatus::WAITING)
                                                                    <span class="badge badge-secondary">{{ $approval->user->name }}</span>
                                                                    @break

                                                                @case(App\Models\ApprovalStatus::APPROVED)
                                                                    <span class="badge badge-success">{{ $approval->user->name }}</span>
                                                                    @break

                                                                @case(App\Models\ApprovalStatus::REJECTED)
                                                                    <span class="badge badge-danger">{{ $approval->user->name }}</span>
                                                                    @break
                                                            @endswitch
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none text-muted">Created At</div>
                                                    <div>{{ $expense->created_at }}</div>
                                                </div>
                                                <div class="col-12 col-sm-1 text-right">
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary border-0 rounded-circle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="{{ route('expenses.print', $expense) }}" target="_blank" class="dropdown-item">Print</a>
                                                            <a href="{{ route('expenses.show', $expense) }}" class="dropdown-item">Detail</a>
                                                            @can('edit-expenses')
                                                                <a href="{{ route('expenses.edit', $expense) }}" class="dropdown-item">Edit</a>
                                                            @endcan
                                                            @can('delete-expenses')
                                                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" style="display: none">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="submit" id="btn-delete-{{ $expense->id }}" style="display: none" />
                                                                </form>
                                                                <a href="javascript:void(0)" class="dropdown-item" onclick="document.getElementById('btn-delete-{{ $expense->id }}').click()">Delete</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col text-center">Not found.</div>
                                            </div>
                                        </li>
                                    @endforelse
                                </ul>
                                <div class="card-footer">
                                    <x-paginator :paginator="$expenses" />
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
