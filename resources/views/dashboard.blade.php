{{-- @dd($stats) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{-- Content --}}
                <div class="sm:flex flex-row">
                    <section class="sm:w-[50%] px-4 sm:p-0 flex flex-col-reverse sm:flex-col">
                        
                        <div class="mt-4 sm:mt-0">
                            <x-link-form 
                                title='Create a new link'
                                action="{{ route('links.store') }}"
                                method="POST"
                            />
                            
                            <div class="flex justify-end">
                                <a href="{{ route('user.index', auth()->user()->username) }}" class="text-gray-600 dark:text-gray-400 text-center underline mt-3 inline-block">
                                    Preview
                                </a>
                            </div>
                        </div>

                        <div class="sm:mt-4">
                            <x-stats 
                                views="{{ $stats['views'] }}"
                                clicks="{{ $stats['clicks'] }}"
                                ctr="{{ $stats['ctr'] }}"
                                linksImpressions="{{ $stats['linksImpressions'] }}"
                            />
                        </div>

                    </section>

                    <section class="sm:w-[50%] px-4 sm:px-20 mt-6 sm:m-0 ">
                        <x-link-list :links="$links"/>
                    </section>
                </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>

{{-- Add the JavaScript for drag and drop --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const linkList = document.getElementById('link-list');

        if (linkList) { // Check if the element exists
            Sortable.create(linkList, {
                animation: 150,
                ghostClass: 'sortable-ghost', // Class name for the drop placeholder
                onEnd: function (evt) {
                    const order = [];
                    linkList.querySelectorAll('[data-id]').forEach(item => {
                        order.push(item.dataset.id);
                    });

                    // Send the new order to the server
                    fetch('{{ route("links.updateOrder") }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ order: order })
                    })
                    .then(response => response.json())
                    .then(data => console.log('Order updated:', data))
                    .catch(error => console.error('Error updating order:', error));
                },
            });
        }
    });
</script>