@if (Network::usesMarketSquare())
    <div>
        @lang('labels.marketsquare_profile')

        <a href="{{ $model->profileUrl() }}">
            {{-- @TODO: Blue MSQ Icon --}}
        </a>
    </div>
@endif
