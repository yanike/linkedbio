<div id="link-list" class="grid grid-flow-row gap-4">
    Click and drag to reorder
    @foreach ($links as $link)
    <a href="{{ route('links.edit', $link)}}" class="hover:shadow-sm border border-gray-500 border-opacity-30 hover:border-opacity-80 dark:border dark:border-slate-300 dark:border-opacity-30 dark:hover:border-opacity-80 ease-out duration-300 rounded-lg">

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4" data-id="{{ $link->id }}">
            <h3 class="text-md text-gray-800 dark:text-gray-200 leading-tight">
                {{ $link->title }}
                </h2>
                <p class="text-gray-500 dark:text-gray-400 text-base">
                    {{ $link->url }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                    Clicks: {{ $link->click_count ?? 0 }}
                </p>
                @php
                    $performance = $link->performance_change ?? 0;
                    $colorClass = $performance > 0 ? 'text-green-500' : ($performance < 0 ? 'text-red-500' : 'text-gray-500');
                    $indicator = $performance > 0 ? '▲' : ($performance < 0 ? '▼' : '');
                @endphp
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 {{ $colorClass }}">
                    Weekly performance: {{ abs($performance) }}% {{ $indicator }}
                </p>
        </div>

    </a>

    @endforeach

</div>