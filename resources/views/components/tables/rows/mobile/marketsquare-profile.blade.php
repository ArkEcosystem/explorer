@if (Network::usesMarketSquare())
    <div>
        @lang('labels.marketsquare_profile')

        <a href="{{ $model->profileUrl() }}">
            <x-icon name="marketsquare" size="sm" />
        </a>
    </div>
@endif
