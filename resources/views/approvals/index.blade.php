<x-app>
    <x-slot name="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-content-header title="Approvals" :urls="['Approvals' => route('approvals.index')]" />

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
                                <div class="card-body p-0">
                                    <div class="container-fluid">
                                        <div class="row p-3 border-top border-bottom d-none d-sm-flex">
                                            <div class="col-12 col-sm">Expense</div>
                                            <div class="col-12 col-sm">Source</div>
                                            <div class="col-12 col-sm">Amount</div>
                                            <div class="col-12 col-sm-3">Description</div>
                                            <div class="col-12 col-sm">Approval Status</div>
                                            <div class="col-12 col-sm-2 text-right"></div>
                                        </div>
                                        @forelse ($collection as $resource)
                                            <div class="row p-3 border-top border-bottom">
                                                <div class="mb-2 col-12 col-sm">
                                                    <div class="d-sm-none">Expense:</div>
                                                    <a href="{{ route('approvals.show', $resource->id) }}"><strong>{{ $resource->expense->id }} - {{ $resource->expense->recipient }}</strong></a>
                                                </div>
                                                <div class="mb-2 col-12 col-sm">
                                                    <div class="d-sm-none">Source:</div>
                                                    <strong>{{ $resource->expense->source->name }}</strong>
                                                </div>
                                                <div class="mb-2 col-12 col-sm">
                                                    <div class="d-sm-none">Amount:</div>
                                                    <strong>{{ $resource->expense->amount_with_separator }}</strong>
                                                </div>
                                                <div class="mb-2 col-12 col-sm-3">
                                                    <div class="d-sm-none">Description:</div>
                                                    <strong>{{ $resource->expense->description }}</strong>
                                                </div>
                                                <div class="mb-2 col-12 col-sm">
                                                    <div class="d-sm-none">Approval Status:</div>
                                                    @switch($resource->approval_status->id)
                                                        @case(App\Models\ApprovalStatus::WAITING)
                                                            <strong>{{ $resource->approval_status->name }}</strong>
                                                            @break

                                                        @case(App\Models\ApprovalStatus::APPROVED)
                                                            <strong class="text-success">{{ $resource->approval_status->name }}</strong>
                                                            @break

                                                        @case(App\Models\ApprovalStatus::REJECTED)
                                                            <strong class="text-danger">{{ $resource->approval_status->name }}</strong>
                                                            @break
                                                    @endswitch
                                                </div>
                                                <div class="mb-2 col-12 col-sm-2 text-right">
                                                    <div class="btn-group" role="group">
                                                        @if ($resource->approval_status->id == App\Models\ApprovalStatus::WAITING)
                                                            <form action="{{ route('approvals.update', $resource->id) }}" method="POST" onsubmit="return confirm('Are you sure want to approve?')">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="approval_status_id" value="{{ App\Models\ApprovalStatus::APPROVED }}">
                                                                <button type="submit" class="btn btn-sm btn-success" tooltip data-placement="bottom" title="Approve">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                            <div class="text-left">
                                                                <button type="button" class="btn btn-sm btn-danger" tooltip data-placement="bottom" title="Reject" data-toggle="modal" data-target="#rejectModal-{{ $resource->id }}">
                                                                    <i class="fas fa-times"></i>
                                                                </button>

                                                                <div class="modal fade" id="rejectModal-{{ $resource->id }}" tabindex="-1" aria-labelledby="rejectModalLabel-{{ $resource->id }}" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <form action="{{ route('approvals.update', $resource->id) }}" method="POST">
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
                                                            </div>
                                                        @endif
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
