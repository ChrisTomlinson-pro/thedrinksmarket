<div class='relative flex align-items-center justify-content-center p-1' style='border-left: solid 3px #a0734b; border-right: solid 3px #a0734b; border-bottom: solid 3px #a0734b; height: 25vh;'>
    <div class='text-center'>
        <h1 class='text-white mb-5'>
            {{ $product->name }}
        </h1>
        <div class='absolute' style='width:100%; bottom: 0.5rem; left:0;'><h2><b><span id='{{ $product->id }}-pricedisplay' style='color:white'>£{{ $product->prices->sortByDesc('created_at')->first()->value }}</span></b>
            
            <span style='position: relative; bottom: 0.5rem; left: 0.3rem;'>
                {{-- Up Arrow --}}
                <i style="border: solid red;
                    border-width: 0 3px 3px 0;
                    display: inline-block;
                    padding: 3px; transform: rotate(45deg);
                    -webkit-transform: rotate(45deg);"
                    class='animate-pulse'
                    id='{{ $product->id }}-down'
                ></i>

                {{-- Up Arrow --}}
                <i style="border: solid green;
                    border-width: 0 3px 3px 0;
                    display: inline-block;
                    padding: 3px; transform: rotate(-135deg);
                    -webkit-transform: rotate(-135deg);"
                    class='animate-pulse'
                    id='{{ $product->id }}-up'
                ></i>
            </span>
        </h2>
        </div>
    </div>
</div>