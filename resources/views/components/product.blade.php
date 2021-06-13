<div class='relative p-5 shadow-lg rounded-md bg-gray-100 listitem'>
    <div>
        <div class='flex justify-between align-center mb-4'>
            <div id='{{ $product->id }}-namediv'>
                <h3 onclick='updateName(this)' data-id='{{ $product->id }}'>{{ $product->name }}</h3>
            </div>
            @if($product->active)
                <button data-active='{{ $product->active }}' data-id='{{ $product->id }}' onclick='toggleActive(this)' class="relative py-2 px-4 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-100 focus:ring-opacity-75">
                    @if($config->running)
                    <div class='absolute -top-px -right-px'>
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                    </div>
                    @endif
                    {{__('Active..')}}
                </button>
            @else
                <button data-active='{{ $product->active }}' data-id='{{ $product->id }}' onclick='toggleActive(this)' class="py-2 px-4 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75">
                    {{__('Inactive')}}
                </button>
            @endif
        </div>
        <div class='mb-3'>
            @if($product->active)
                <div class='flex justify-between'>
                    <div class='text-sm'>Live Price:</div>
                    <div class='text-right text-sm' id='{{ $product->id }}-pricedisplay'>£{{ number_format($product->prices->sortByDesc('created_at')->first()->value / 100, 2)}}</div>
                </div>
            @endif
            <div class='flex justify-between'>
                <div class='text-sm'>Base price:</div>
                <div class='text-right text-sm'>£{{ number_format($product->base_price / 100, 2)}}</div>
            </div>
            <div class='flex justify-between'>
                <div class='text-sm'>Item SKU:</div>
                <div class='text-right text-sm'>{{ $product->sku }}</div>
            </div>
        </div>
    </div>

    <div>
        <label class="block">
            <span class="text-gray-700">Min Price</span>
        </label>
        <div class="relative flex w-full flex-wrap items-stretch mb-3">
            <span
                class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-2 py-1">
                <span>£</span>
            </span>
            <input data-id='{{ $product->id }}' onchange='updateMin(this)' type="number" value={{ number_format($product->min_price / 100, 2) }} step='0.01' class="px-2 py-1 placeholder-gray-400 text-gray-600 relative bg-white bg-white rounded text-sm border border-gray-400 outline-none focus:outline-none focus:ring w-full pl-10" />
        </div>
    </div>

    <div>
        <label class="block">
            <span class="text-gray-700">Max Price</span>
        </label>
        <div class="relative flex w-full flex-wrap items-stretch mb-3">
            <span
                class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-2 py-1">
                <span>£</span>
            </span>
            <input data-id='{{ $product->id }}' onchange='updateMax(this)' type="number" value={{ number_format($product->max_price / 100, 2) }} step='0.01' class="px-2 py-1 placeholder-gray-400 text-gray-600 relative bg-white bg-white rounded text-sm border border-gray-400 outline-none focus:outline-none focus:ring w-full pl-10" />
        </div>
    </div>
    
    <div>
        <label class="block">
            <span class="text-gray-700">Increments Up</span>
        </label>
        <div class="relative flex w-full flex-wrap items-stretch mb-3">
            <span
                class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-2 py-1">
                <span>£</span>
            </span>
            <input data-id='{{ $product->id }}' onchange="updateIncrement(this, 'up')" type="number" value={{ number_format($product->increments_up / 100, 2) }} step='0.01' class="px-2 py-1 placeholder-gray-400 text-gray-600 relative bg-white bg-white rounded text-sm border border-gray-400 outline-none focus:outline-none focus:ring w-full pl-10" />
        </div>
    </div>

    <div>
        <label class="block">
            <span class="text-gray-700">Increments Down</span>
        </label>
        <div class="relative flex w-full flex-wrap items-stretch mb-3">
            <span
                class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-2 py-1">
                <span>£</span>
            </span>
            <input data-id='{{ $product->id }}' onchange="updateIncrement(this, 'down')" type="number" value={{ number_format($product->increments_down / 100, 2) }} step='0.01' class="px-2 py-1 placeholder-gray-400 text-gray-600 relative bg-white bg-white rounded text-sm border border-gray-400 outline-none focus:outline-none focus:ring w-full pl-10" />
        </div>
    </div>

    <div>
        <label class="block">
            <span class="text-gray-700">Market Crash Price</span>
        </label>
        <div class="relative flex w-full flex-wrap items-stretch mb-3">
            <span
                class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-2 py-1">
                <span>£</span>
            </span>
            <input data-id='{{ $product->id }}' onchange="updateCrashPrice(this)" type="number" value={{ number_format($product->crash_price / 100, 2) }} step='0.01' class="px-2 py-1 placeholder-gray-400 text-gray-600 relative bg-white bg-white rounded text-sm border border-gray-400 outline-none focus:outline-none focus:ring w-full pl-10" />
        </div>
    </div>
</div>