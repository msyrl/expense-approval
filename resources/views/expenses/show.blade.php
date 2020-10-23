<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header name="Expense Detail" :backUrl="route('expenses.index')" />

            <section class="content">
                <div class="container-fluid">
                    @if (session()->has('error'))
                        <x-alert-danger>{{ session()->get('error') }}</x-alert-danger>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-primary">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Source</strong>
                                        <div class="text-muted">{{ $expense->source->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Category</strong>
                                        <div class="text-muted">{{ $expense->category->name }}</div>
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
                                                <span>{{ $index + 1 }}. {{ $approval->user->name }} -</span>
                                                @switch($approval->approval_status->id)
                                                    @case(App\Models\ApprovalStatus::WAITING)
                                                        <strong>{{ $approval->approval_status->name }}</strong>
                                                        @break

                                                    @case(App\Models\ApprovalStatus::APPROVED)
                                                        <strong class="text-success">{{ $approval->approval_status->name }} | {{ $approval->updated_at }}</strong>
                                                        @break

                                                    @case(App\Models\ApprovalStatus::REJECTED)
                                                        <strong class="text-danger">{{ $approval->approval_status->name }} ({{ $approval->note }}) | {{ $approval->updated_at }}</strong>
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
                                <div class="card-footer">
                                    @can('edit-expenses')
                                        <x-edit-button :url="route('expenses.edit', $expense)" />
                                    @endcan
                                    <x-cancel-button :url="route('expenses.index')" />
                                    @can('delete-expenses')
                                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" style="display: none">
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
