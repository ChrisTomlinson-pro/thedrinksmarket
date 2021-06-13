<div style='max-height: 100%;'>
    <div>
        @if($config->running)
            <h3 id='timer-text' style='width:100%;' class='text-white text-center'>Next Price Update: <b><span id='timer'></span></b></h3>
            <h3 id='mcrash-text' style='display: none; max-height:100%; color:red;' class='animate-pulse text-center'><b>MARKET CRASH</b></h3>
        @else
            <h3 id='mcrash-text' style='max-height:100%; color:gray;' class='animate-pulse text-center'><b>Market Closed...</b></h3>
        @endif
    </div>
</div>