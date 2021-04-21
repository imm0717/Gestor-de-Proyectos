<div>
    <table class="table table-striped table-bordered table-hover table-checkable table-sm">
        <thead class="thead-inverse">
            <tr>
                <th width="15%">@lang('view.livewire.logs.index.table.header-type')</th>
                <th>@lang('view.livewire.logs.index.table.header-description')</th>
                <th width="20%">@lang('view.livewire.logs.index.table.header-date')</th>
            </tr>
            </thead>
            <tbody>
                @foreach ( $logs as $log )
                <tr>
                    <td scope="row">{{ $log->log_name }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $log->created_at)->format('d-m-Y H:i:s') }}</td>
                </tr>
                @endforeach
            </tbody>
    </table>
    {{ $logs->links() }}
</div>
