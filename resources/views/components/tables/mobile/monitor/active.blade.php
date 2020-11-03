<div class="w-full table-container md:hidden">
    <table class="divide-y-0">
        <thead class="divide-y-0">
            <tr class="divide-y-0">
                <th>@lang('general.delegates.rank')</th>
                <th><span class="pl-14">@lang('general.delegates.name')</span></th>
                <th><span class="pl-14">@lang('general.delegates.status')</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($delegates as $delegate)
                <tr>
                    <td>
                        <x-tables.rows.mobile.rank :model="$delegate" />
                    </td>
                    <td>
                        <x-tables.rows.mobile.username-with-avatar :model="$delegate" />
                    </td>
                    <td>
                        <x-tables.rows.mobile.round-status-history :model="$delegate" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
