@php
   $agent= new Jenssegers\Agent\Agent();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h1>
    </x-slot>

    <div class="py-12" :class="{'overflow-y-hidden': showModal2}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class='flex flex-row justify-between mb-2'>
                        <div class='text-xl'>{{ __('Product information') }}</div>
                        @if(!$config->running)
                            <form class="max-w-sm">
                                <div class="flex items-center border-b border-gray-500 py-2">
                                <input id="sku-search" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Add product by SKU" aria-label="add by sku" autocomplete="off">
                                <button onclick='searchForProduct()' class="flex-shrink-0 bg-gray-500 hover:bg-gray-700 border-gray-500 hover:border-gray-700 text-sm border-4 text-white py-1 px-2 rounded" type="button">
                                    {{ __('Add') }}
                                </button>
                                </div>
                            </form>
                            {{-- <div onclick='syncProducts()'><x-button>{{ __('Sync Products') }}</x-button></div> --}}
                        @else
                            <div></div>
                        @endif
                    </div>

                    <div class='flex flex-row justify-between mb-5'>
                        <div></div>
                        <div class="relative h-10 input-component mb-5">
                            <input
                              id="searchbox"
                              type="text"
                              class="form-control"
                              placeholder="Search added products"
                            />
                        </div>
                    </div>

                    @if(!$agent->isMobile())
                        <div class='grid grid-cols-3 gap-4 pt-5 mb-5'>
                    @else
                        <div class='grid grid-cols-1 gap-1 pt-2 mb-3'>
                    @endif
                        @foreach(collect($drinks)->where('active', true) as $product)
                            <x-product :product="$product" :config="$config" />
                        @endforeach
                    </div>
                    
                    @if(!$agent->isMobile())
                        <div class='grid grid-cols-3 gap-4 pt-5 mb-3'>
                    @else
                        <div class='grid grid-cols-1 gap-1 pt-2 mb-3'>
                    @endif
                        @foreach(collect($drinks)->where('active', false) as $product)
                            <x-product :product="$product" :config="$config" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('js')
    <script>
        const searchForProduct = async() => {
            var response = await makeGetRequest('/syncbysku/' + $('#sku-search').val());
            if(response.status === 'OK')
            {
                window.location.reload();
            } else
            {
                console.log(response.message);
                console.log(response);
            }
        }

        var drinkIds = {!! json_encode(collect($drinks)->where('active', true)->pluck('id')->all()) !!};
        var isRunning = {!! json_encode($config->running) !!};
        
        const getPrices = async() => {
            for(let id of drinkIds)
            {
                var response = await makeGetRequest('/getdrinkprice/' + id);
                document.getElementById(id+'-pricedisplay').innerHTML = '£' + parseFloat(response.message).toFixed(2).toString();
            }
            await sleep(5000);
        }

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        const initFunction = async() =>{
            while(true)
            {
                await getPrices();
            }
        }

        $('#searchbox').keyup(function() {
            var val = $.trim(this.value).toUpperCase()
            var group = $(this).data('group');
            var $listitems = $('.listitem');
            if(val == "")
            {
                $listitems.show();
            } else
            {
                $listitems.hide();
                $listitems.filter(function() {
                    return -1 != $(this).text().toUpperCase().indexOf(val);
                }).show();
            }
        })

        const updateName = async(el) => {
            var id = el.dataset.id;
            el.remove();
            var inputNode = document.createElement('input');
            inputNode.id = id+'-nameinput';

            var btn = document.createElement('button');
            var textnode = document.createTextNode('Update');
            btn.dataset.id = id;
            btn.setAttribute('onclick', 'submitNewName(this)');
            btn.appendChild(textnode);

            var br = document.createElement('br');
            br.id = id+'br';

            var div = document.getElementById(id + '-namediv');
            div.appendChild(inputNode);
            div.appendChild(br);
            div.appendChild(btn);
        }

        const submitNewName = async(el) => {
            var id = el.dataset.id;
            var nameinput = document.getElementById(id+'-nameinput');
            var name = nameinput.value;
            var data = {name: name};

            makePostRequest('/updatename/' + id, data);

            el.remove();
            nameinput.remove();
            document.getElementById(id+'br').remove();

            var h3 = document.createElement('h3');
            var textnode = document.createTextNode(name);
            h3.setAttribute('onclick', 'updateName(this)');
            h3.dataset.id = id;
            h3.class = 'text-center';
            h3.appendChild(textnode);

            document.getElementById(id+'-namediv').appendChild(h3);
        }

        const updateMin = async(el) => {
            var data = {value: el.value};
            await makePostRequest('/updatemin/' + el.dataset.id, data);
        }

        const updateMax = async(el) => {
            var data = {value: el.value};
            await makePostRequest('/updatemax/' + el.dataset.id, data);
        }

        const updateIncrement = async(el, protocol) => {
            var data = {value: el.value, protocol: protocol};
            await makePostRequest('/updateincrements/' + el.dataset.id, data);
        }

        const updateCrashPrice = async(el) => {
            var data = {value: el.value};
            await makePostRequest('/updatecrashprice/' + el.dataset.id, data);
        }

        const toggleActive = async(el) => {
            await makeGetRequest('/toggleactive/' + el.dataset.id);
            window.location.reload();
        }

        const syncProducts = async() => {
            var response = await makeGetRequest('square/sync');
            if(response.status === 'OK')
            {
                window.location.reload();
            }
        }

        if(isRunning)
        {
            initFunction();
        }
    </script>
    @endsection
</x-app-layout>