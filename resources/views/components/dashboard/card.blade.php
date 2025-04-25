@props(['title', 'value', 'icon', 'color'])

@php
    $colorClasses = [
        'blue' => 'bg-blue-500 text-white',
        'green' => 'bg-green-500 text-white',
        'yellow' => 'bg-yellow-500 text-white',
        'red' => 'bg-red-500 text-white',
    ][$color ?? 'blue'];

    $iconClasses = [
        'document-text' => 'fas fa-file-alt',
        'currency-dollar' => 'fas fa-dollar-sign',
        'clock' => 'fas fa-clock',
    ][$icon ?? 'document-text'];
@endphp

<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="py-2 px-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="rounded-md p-3 {{ $colorClasses }}">
                    <i class="{{ $iconClasses }} fa-lg"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl class="">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        {{ $title }}
                    </dt>
                    <dd class="text-lg font-semibold text-gray-900">
                        {{ $value }}
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div> 