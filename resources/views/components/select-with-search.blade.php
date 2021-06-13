<div x-data="{ showOptions: false }">
    <p class="p-4">Select Drink {{ ucfirst($slot) }}: </p>
    <div class="mr-8 ml-4">
        <div class="relative">
            <button 
                class="bg-gray-500 p-3 rounded text-white shadow-inner w-full"
                @click="showOptions = !showOptions"
                id='{{ $slot }}-btn'
            >
            <span class="float-left">---Please Select---</span>
            <svg class="h-4 float-right fill-current text-white" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                <g>
                <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"/>
                </g>
            </svg>
            </button>
            <div 
                class="rounded shadow-md my-2 relative pin-t pin-l"
                x-show="showOptions"
            >
                <ul class="list-reset">
                    <li  class="p-2"><input data-group='{{ $slot }}' class="searchbox border-2 rounded h-8 w-full"><br></li>
                    @if($includeNone)
                        <li class="{{ $slot }}-listitems listitems" data-group='{{ $slot }}' data-sku='none' @click="showOptions = false"><p class="p-2 block text-black hover:bg-grey-light cursor-pointer">
                            None
                        </p></li>
                    @endif
                    @foreach($listItems as $item)
                        <li class="{{ $slot }}-listitems listitems" data-group='{{ $slot }}' data-sku='{{ $item->id }}' @click="showOptions = false"><p class="p-2 block text-black hover:bg-grey-light cursor-pointer">
                            {{ $item->name }} - £{{ $item->base_price / 100 }}
                        </p></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>