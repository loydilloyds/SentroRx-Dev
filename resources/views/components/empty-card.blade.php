<div {{ $attributes->merge(['class' => 'bg-white p-8 text-md font-medium text-gray-800']) }}>

    @if(isset($header))
        <div {{ $header->attributes->merge(['class' => 'text-xl font-bold']) }}>
            {{ $header }}
        </div>
    @endif

    {{ $slot }}

    @if(isset($footer))
        <div {{ $footer->attributes->merge(['class' => 'text-sm text-gray-400 font-medium']) }}>
            {{ $footer }}
        </div>
    @endif

</div>
