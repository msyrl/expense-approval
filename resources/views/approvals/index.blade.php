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
                                                        <form action="{{ route('approvals.update', $resource->id) }}" method="POST" onsubmit="return confirm('Are you sure want to reject?')">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="approval_status_id" value="{{ App\Models\ApprovalStatus::REJECTED }}">
                                                            <button type="submit" class="btn btn-sm btn-danger" tooltip data-placement="bottom" title="Reject">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
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
