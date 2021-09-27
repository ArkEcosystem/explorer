<x-ark-metadata :page="$page" detail="{{ $detail ?? null }}" />

@section('title')
    @lang('metatags.'.$page.'.title', ['detail' => $detail ?? null])
@endsection
