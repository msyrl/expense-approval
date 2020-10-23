<x-app>
    <x-slot name="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-content-header name="Approvals" />

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
                            <!-- Default box -->
                            <div class="card">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-none d-sm-block">
                                        <div class="row">
                                            <div class="col-12 col-sm text-muted">Recipient</div>
                                            <div class="col-12 col-sm text-muted">Source</div>
                                            <div class="col-12 col-sm text-muted">Category</div>
                                            <div class="col-12 col-sm text-muted">Amount</div>
                                            <div class="col-12 col-sm-3 text-muted">Description</div>
                                            <div class="col-12 col-sm text-muted">Approval Status</div>
                                            <div class="col-12 col-sm-1 text-right"></div>
                                        </div>
                                    </li>
                                    @forelse ($collection as $resource)
                                        <li class="list-group-item">

                                            <div class="row">
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none text-muted">Recipient:</div>
                                                    <div>{{ $resource->expense->recipient }}</div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none text-muted">Source:</div>
                                                    <div>{{ $resource->expense->source->name }}</div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none text-muted">Category:</div>
                                                    <div>{{ $resource->expense->category->name }}</div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none text-muted">Amount:</div>
                                                    <div>{{ $resource->expense->amount_with_separator }}</div>
                                                </div>
                                                <div class="col-12 col-sm-3">
                                                    <div class="d-sm-none text-muted">Description:</div>
                                                    <div>{{ $resource->expense->description }}</div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none text-muted">Approval Status:</div>
                                                    <div>
                                                        @switch($resource->approval_status->id)
                                                            @case(App\Models\ApprovalStatus::WAITING)
                                                                <span>{{ $resource->approval_status->name }}</span>
                                                                @break

                                                            @case(App\Models\ApprovalStatus::APPROVED)
                                                                <span class="text-success">{{ $resource->approval_status->name }}</span>
                                                                @break

                                                            @case(App\Models\ApprovalStatus::REJECTED)
                                                                <span class="text-danger">{{ $resource->approval_status->name }}</span>
                                                                @break
                                                        @endswitch
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-1 text-right">
                                                    @if ($resource->approval_status->id == App\Models\ApprovalStatus::WAITING)
                                                        <div class="dropdown">
                                                            <button type="button" class="btn btn-sm btn-outline-secondary border-0 rounded-circle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <form action="{{ route('approvals.update', $resource) }}" method="POST" onsubmit="return confirm('Are you sure want to approve?')">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="approval_status_id" value="{{ App\Models\ApprovalStatus::APPROVED }}">
                                                                    <button type="submit" class="dropdown-item text-success">Approve</button>
                                                                </form>

                                                                <button type="button" class="dropdown-item text-danger" data-toggle="modal" data-target="#rejectModal-{{ $resource->id }}">Reject</button>
                                                            </div>
                                                        </div>

                                                        <div class="modal fade text-left" id="rejectModal-{{ $resource->id }}" tabindex="-1" aria-labelledby="rejectModalLabel-{{ $resource->id }}" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form action="{{ route('approvals.update', $resource) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="approval_status_id" value="{{ App\Models\ApprovalStatus::REJECTED }}">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="rejectModalLabel-{{ $resource->id }}">Are you sure want to reject?</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label for="note">Note <span class="text-danger">*</span></label>
                                                                                <textarea name="note" id="note" rows="4" class="form-control @error('note') is-invalid @enderror">{{ old('note') }}</textarea>
                                                                                @error('note') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endif
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
                                    <x-paginator :paginator="$collection" />
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
