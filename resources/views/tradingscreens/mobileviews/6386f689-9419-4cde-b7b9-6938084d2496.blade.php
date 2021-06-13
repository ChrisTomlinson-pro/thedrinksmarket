<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('The Garrison Stock Exchange', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" integrity="undefined" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="undefined" crossorigin="anonymous"></script>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
        <div 
            class="font-sans text-gray-900 antialiased" 
            style='background: black'
            >

            {{-- Top Banner --}}
            <div id='top-banner' class='flex justify-center p-3' style='height:20vh; background: rgba(0, 0, 0, 0.7);'>
                <div style='max-height: 100%;' class='pt-2'>
                    <img src='/storage/resources/garrisontext.png' style='max-height: 100%'>
                </div>
            </div>
            {{-- End Top Banner --}}

            {{-- Scrolling banner --}}
            <div style='background-color: black; height: 5vh; border-top: 3px solid #a0734b; border-bottom: 3px solid #a0734b'>
                <div class='pt-1 pb-1' style='max-height: 100%;'>
                    <div></div>
                    <div style='max-height: 100%;'>
                        <x-timer></x-timer>
                    </div>
                    <div></div>
                </div>
            </div>
            {{-- End Scrolling Banner --}}

            {{-- Grid --}}
            <div id='prices-grid' class='grid grid-cols-1' style='background: rgba(0, 0, 0, 0.7);'>
                @if($config->running)
                    @foreach($products as $product)
                        <x-price-card :product='$product'>
                        </x-price-card>
                    @endforeach
                @else
                    @foreach($products as $product)
                        <div class='p-5 flex justify-content-center align-items-center' style='border-left: solid 3px #a0734b; border-right: solid 3px #a0734b; border-bottom: solid 3px #a0734b; height: 25vh;'>
                            <img src='/storage/resources/Tiggy.png' style='max-height: 70%;'>
                        </div>
                    @endforeach
                @endif
            </div>
            {{-- End Grid --}}

            {{-- Bottom Banner --}}
            <div id='bottom-banner' class='flex justify-center p-3' style='height:20vh; background: rgba(0, 0, 0, 0.7);'>
                <div style='max-height:100%' class='pt-1'>
                    <img src='/storage/resources/logo.png' style='max-height: 100%;'>
                </div>
            </div>
            {{-- End Bottom Banner --}}
        </div>
        <script>
            const makeGetRequest = async(endpoint) => {
                return axios.get(endpoint)
                .then(function (response) {
                    console.log(response);
                    return response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }

            const makePostRequest = async(endpoint, data) => {
                var laravelToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                await axios.post(endpoint, data)
                .then(function (response) {
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
            }


            var drinkIds = {!! json_encode($products->pluck('id')->all()) !!};
            var isRunning = {!! json_encode($config->running) !!};
            
            const getPrices = async() => {
                for(let id of drinkIds)
                {
                    var response = await makeGetRequest('/getdrinkprice/' + id + '/tradingview');
                    var priceDisplay = document.getElementById(id+'-pricedisplay');
                    var up = document.getElementById(id + '-up');
                    var down = document.getElementById(id + '-down');
                    priceDisplay.innerHTML = '£' + parseFloat(response.message[0]).toFixed(2).toString();
                    

                    if(response.message[1] === 'constant')
                    {
                        priceDisplay.style.color = 'white';
                        $(up).hide();
                        $(down).hide();
                    } else if(response.message[1] === 'up')
                    {
                        priceDisplay.style.color = 'green';
                        $(down).hide();
                        $(up).show();
                    } else
                    {
                        priceDisplay.style.color = 'red';
                        $(down).show();
                        $(up).hide();
                    }
                }
            }

            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }

            // MARKET CRASH FUNCTIONS

            var crashActive = "0";
            var boolAr = ["0", "1"];
            var timertext = $('#timer-text');
            var mcrashtext = $('#mcrash-text');
            var topbanner = $('#top-banner');
            var pricesgrid = $('#prices-grid');
            const checkCrash = async() => {
                var result = await makeGetRequest('/checkcrash/' + {!! json_encode($config->id) !!});
                if(result.message !== crashActive && boolAr.indexOf(result.message) !== -1)
                {
                    crashActive = result.message;
                    switch(result.message)
                    {
                        case "1":
                            await getPrices();
                            $(timertext).hide();
                            $(mcrashtext).show();
                            $(pricesgrid).attr('style', 'background: rgba(117, 0, 0, 0.7);')
                            $(topbanner).attr('style', 'height:20vh; background: rgba(117, 0, 0, 0.7);');
                            break;
                        case "0":
                            await getPrices();
                            $(timertext).show();
                            $(mcrashtext).hide();
                            $(pricesgrid).attr('style', 'background: rgba(0, 0, 0, 0.7);')
                            $(topbanner).attr('style', 'height:20vh; background: rgba(0, 0, 0, 0.7);')
                            distance = await getDistance();
                            startTimer();
                            break;
                        default:
                            console.log('unrecognised message in checkCrash function');
                    }
                }
                await sleep(5000);
            }

            const runCrashCheck = async() =>{
                while(true)
                {
                    await checkCrash();
                }
            }

            // END MARKET CRASH FUNCTIONS

            // COUNTDOWN FUNCTIONS
            var distance = null;

            const getDistance = async() => {
                var result = await makeGetRequest('/getdistance/' + {!! json_encode($user->id) !!});
                return parseInt(result.message);
            }

            const countdown = async() => 
            {

                var minutes = Math.floor(distance / 60);
                var seconds = distance - minutes * 60;

                document.getElementById("timer").innerHTML = minutes + "m " + seconds + "s ";
                distance--;
            }

            const startTimer = async() => 
            {
                if(distance === null)
                {
                    await getPrices();
                    distance = await getDistance();
                }

                while(distance > -1)
                {
                    if(crashActive !== "1")
                    {
                        if (distance !== 0)
                        {
                            countdown();
                            await sleep(1000);
                        } else
                        {
                            document.getElementById("timer").innerHTML = "UPDATING...";
                            await sleep(2500);
                            await getPrices();
                            distance = await getDistance();
                        }
                    } else
                    {
                        break;
                    }
                }
            }
            
            // END COUNTDOWN FUNCTIONS

            startTimer();
            runCrashCheck();
        </script>
        @yield('js')
    </body>
</html>