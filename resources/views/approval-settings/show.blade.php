<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header name="Approval Setting Detail" :backUrl="route('approval-settings.index')" />

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>From Amount</strong>
                                        <div class="text-muted">{{ $approval_setting->from_amount_with_separator }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>To Amount</strong>
                                        <div class="text-muted">{{ $approval_setting->to_amount_with_separator }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Guarantors</strong>
                                        @foreach ($approval_setting->guarantors as $index => $user)
                                            <div class="text-muted">{{ $index + 1 . '. ' . $user->name }}</div>
                                        @endforeach
                                    </div>
                                    <div class="mb-3">
                                        <strong>Created At</strong>
                                        <div class="text-muted">{{ $approval_setting->created_at }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Last Updated</strong>
                                        <div class="text-muted">{{ $approval_setting->updated_at }}</div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    @can('edit-approval-settings')
                                        <x-edit-button :url="route('approval-settings.edit', $approval_setting)" />
                                    @endcan
                                    <x-cancel-button :url="route('approval-settings.index')" />
                                    @can('delete-approval-settings')
                                        <form action="{{ route('approval-settings.destroy', $approval_setting) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" style="display: none">
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
