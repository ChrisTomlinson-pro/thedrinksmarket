<div
    class="fixed inset-0 w-full h-full z-20 bg-black bg-opacity-50 duration-300 overflow-y-auto"
    x-show="showModal2"
    x-transition:enter="transition duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3 mx-2 sm:mx-auto my-10 opacity-100">
    <div
        class="relative bg-white shadow-lg rounded-lg text-gray-900 z-20"
        @click.away="showModal2 = false"
        x-show="showModal2"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="scale-0"
        x-transition:enter-end="scale-100"
        x-transition:leave="transition transform duration-300"
        x-transition:leave-start="scale-100"
        x-transition:leave-end="scale-0"
    >
        {{ $slot }}
    </div>
    </div>
</div>