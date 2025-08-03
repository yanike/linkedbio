<div class="grid grid-flow-row gap-4">
    @foreach ($links as $link)
        <a href="{{ route('links.edit', $link)}}" class="hover:shadow-sm border border-gray-500 border-opacity-30 hover:border-opacity-80 dark:border dark:border-slate-300 dark:border-opacity-30 dark:hover:border-opacity-80 ease-out duration-300 rounded-lg">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4">
                <h3 class="text-md text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $link->title }}
                </h2>
                <p class="text-gray-500 dark:text-gray-400 text-base">
                    {{ $link->url }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                    Clicks: {{ $link->clicks_count ?? 0 }}
                </p>
            </div>
        
        </a>
        
    @endforeach

</div>