<div class="overflow-hidden rounded-full {{ $avatarSize ?? 'w-6 h-6 md:w-11 md:h-11' }}">
    <div class="object-cover w-full h-full">
        {!! Avatar::make($identifier) !!}
    </div>
</div>
