<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header title="Detail" :urls="['Approvals' => route('approvals.index'), 'Detail' => route('approvals.show', $approval->id)]" />

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-primary">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Recipient</strong>
                                        <div class="text-muted">{{ $approval->expense->recipient }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Amount</strong>
                                        <div class="text-muted">{{ $approval->expense->amount_with_separator }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Description</strong>
                                        <div class="text-muted">{{ $approval->expense->description ?? '-' }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Status</strong>
                                        @switch($approval->approval_status->id)
                                            @case(App\Models\ApprovalStatus::WAITING)
                                                <div class="text-muted">{{ $approval->approval_status->name }}</div>
                                                @break

                                            @case(App\Models\ApprovalStatus::APPROVED)
                                                <div class="text-success">{{ $approval->approval_status->name }} | {{ $approval->approval_status->updated_at }}</div>
                                                @break

                                            @case(App\Models\ApprovalStatus::REJECTED)
                                                <div class="text-danger">{{ $approval->approval_status->name }} | {{ $approval->approval_status->updated_at }}</div>
                                                @break
                                        @endswitch
                                    </div>
                                    <div class="mb-3">
                                        <strong>Created At</strong>
                                        <div class="text-muted">{{ $approval->created_at }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Last Updated</strong>
                                        <div class="text-muted">{{ $approval->updated_at }}</div>
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
