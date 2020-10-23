<x-app>
    <x-slot name="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-content-header name="Approval Settings" />

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
                                <div class="col-6 col-sm-4 px-1 mr-auto">
                                    <x-list-search />
                                </div>
                                <div class="col-auto px-1">
                                    <x-filter-modal :paginator="$approval_settings">
                                        <x-slot name="body">
                                            <x-sortables :sortables="$sortables" />
                                        </x-slot>
                                    </x-filter-modal>
                                </div>
                                <div class="col-auto px-1">
                                    @can('create-approval-settings')
                                        <x-create-button :url="route('approval-settings.create')" />
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
                                                <x-list-header name="From Amount" asc="from_amount|asc" desc="from_amount|desc" />
                                            </div>
                                            <div class="col-12 col-sm text-muted">
                                                <x-list-header name="To Amount" asc="to_amount|asc" desc="to_amount|desc" />
                                            </div>
                                            <div class="col-12 col-sm text-muted">Guarantors</div>
                                            <div class="col-12 col-sm-1 text-right"></div>
                                        </div>
                                    </li>
                                    @forelse ($approval_settings as $approval_setting)
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none">From Amount:</div>
                                                    <div>{{ $approval_setting->from_amount_with_separator }}</div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none">To Amount:</div>
                                                    <div>{{ $approval_setting->to_amount_with_separator }}</div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="d-sm-none">Guarantors:</div>
                                                    @foreach ($approval_setting->guarantors as $user)
                                                        <span class="badge badge-primary">{{ $user->name }}</span>
                                                    @endforeach
                                                </div>
                                                <div class="col-12 col-sm-1 text-right">
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary border-0 rounded-circle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="{{ route('approval-settings.show', $approval_setting) }}" class="dropdown-item">Detail</a>
                                                            @can('edit-approval-settings')
                                                                <a href="{{ route('approval-settings.edit', $approval_setting) }}" class="dropdown-item">Edit</a>
                                                            @endcan
                                                            @can('delete-approval-settings')
                                                                <form action="{{ route('approval-settings.destroy', $approval_setting) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" style="display: none">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="submit" id="btn-delete-{{ $approval_setting->id }}" style="display: none" />
                                                                </form>
                                                                <a href="javascript:void(0)" class="dropdown-item" onclick="document.getElementById('btn-delete-{{ $approval_setting->id }}').click()">Delete</a>
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
                                    <x-paginator :paginator="$approval_settings" />
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
