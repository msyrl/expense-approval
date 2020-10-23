<x-app>
    <x-slot name="content">
        <div class="content-wrapper">
            <x-content-header name="Source Detail" :backUrl="route('sources.index')" />

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Name</strong>
                                        <div class="text-muted">{{ $source->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Created At</strong>
                                        <div class="text-muted">{{ $source->created_at }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Last Updated</strong>
                                        <div class="text-muted">{{ $source->updated_at }}</div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    @can('edit-sources')
                                        <x-edit-button :url="route('sources.edit', $source)" />
                                    @endcan
                                    <x-cancel-button :url="route('sources.index')" />
                                    @can('delete-sources')
                                        <form action="{{ route('sources.destroy', $source) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" style="display: none">
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
