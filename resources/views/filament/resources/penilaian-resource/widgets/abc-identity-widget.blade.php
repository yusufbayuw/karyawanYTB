<x-filament-widgets::widget>
    <x-filament::section>
        <div>
            <h1 class="font-bold">{{ $name ?? null }}</h1>
            <h2>Unit {{ $unit ?? null }}</h2>
            <h2>Golongan {{ $golongan ?? null }}</h2>
            <h2>Total Angka Kredit Terverifikasi: {{ $total ?? null }}</h2>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
