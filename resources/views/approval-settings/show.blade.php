<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header title="Detail" :urls="['Approval Settings' => route('approval-settings.index'), 'Detail' => route('approval-settings.show', $approval_setting->id)]" />

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-primary">
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
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </x-slot>
</x-app>
