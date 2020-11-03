<div class="w-full table-container md:hidden">
    <table>
        <thead>
            <tr>
                <th><span class="pl-14">@lang('general.delegates.name')</span></th>
                <th><span class="pl-14">@lang('general.delegates.votes')</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($delegates as $delegate)
            <tr>
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