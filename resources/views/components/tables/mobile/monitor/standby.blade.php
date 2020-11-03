<div class="w-full table-container md:hidden">
    <table>
        <thead>
            <tr>
                <th>@lang('general.delegates.rank')</th>
                <th>@lang('general.delegates.name')</th>
                <th>@lang('general.delegates.votes')</th>
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
                    <x-tables.rows.mobile.votes :model="$delegate" />
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>