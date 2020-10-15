<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header title="Detail" :urls="['Expenses' => route('expenses.index'), 'Detail' => route('expenses.show', $expense->id)]" />

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-primary">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Categories</strong>
                                        <div class="text-muted">
                                            @foreach ($expense->categories as $index => $category)
                                                <div>{{ $index + 1 }}. {{ $category->name }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Recipient</strong>
                                        <div class="text-muted">{{ $expense->recipient }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Amount</strong>
                                        <div class="text-muted">{{ $expense->amount_with_separator }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Description</strong>
                                        <div class="text-muted">{{ $expense->description ?? '-' }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Approvals</strong>
                                        @foreach ($expense->approvals as $index => $approval)
                                            <div class="text-muted">
                                                <span>{{ $index + 1 }}. {{ $approval->user->name }} - </span>
                                                @switch($approval->approval_status->id)
                                                    @case(App\Models\ApprovalStatus::WAITING)
                                                        <strong>{{ $approval->approval_status->name }}</strong>
                                                        @break

                                                    @case(App\Models\ApprovalStatus::APPROVED)
                                                        <strong class="text-success">{{ $approval->approval_status->name }} | {{ $approval->approval_status->updated_at }}</strong>
                                                        @break

                                                    @case(App\Models\ApprovalStatus::REJECTED)
                                                        <strong class="text-danger">{{ $approval->approval_status->name }} | {{ $approval->approval_status->updated_at }}</strong>
                                                        @break
                                                @endswitch
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mb-3">
                                        <strong>Created At</strong>
                                        <div class="text-muted">{{ $expense->created_at }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Last Updated</strong>
                                        <div class="text-muted">{{ $expense->updated_at }}</div>
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
