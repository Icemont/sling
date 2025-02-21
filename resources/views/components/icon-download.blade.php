<svg width="24" height="24" {{ $attributes->merge(['class' => 'icon']) }}>
    <use xlink:href="#download-icon"></use>
</svg>
@pushOnce('body-end')
    <svg style="display: none;">
        <symbol id="download-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
            <path d="M7 11l5 5l5 -5" />
            <path d="M12 4l0 12" />
        </symbol>
    </svg>
@endPushOnce