
@php
   $agent= new Jenssegers\Agent\Agent();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Top Bar --}}
                    @if(!$agent->isMobile())
                    <div class='flex flex-row justify-between mb-5'>
                    @else
                    <div class='mb-5'>
                    @endif
                        <div>
                            <div class='text-xl mb-3'>{{ __('Logged in as ' . auth()->user()->name) }}</div>
                            <div class='mb-3'>
                                <div class='mr-2'>{{ __('Your trading screen url: ') }}</div>
                                @php
                                    $url = url('/') . '/tradingscreen/' . auth()->user()->guid;
                                    $moburl = url('/') . '/tradingscreen/' . auth()->user()->guid . '/mobileview';
                                @endphp
                                @if(!$agent->isMobile())
                                    <a href='{{ $url }}' target='_blank'><div class='inline-block align-text-bottom text-blue-500'>{{ __($url) }}</div></a>
                                @else
                                    <a href='{{ $moburl }}' target='_blank'><div class='inline-block align-text-bottom text-blue-500'>{{ __($moburl) }}</div></a>
                                @endif
                            </div>
                        </div>
                        @if($agent->isMobile())
                        <div>
                                <div class='mr-2'>{{ __('Your mobile trading screen QR code: ') }}</div>
                                @if($qrCodes->isNotEmpty())
                                    <a href='/storage/resources/qrcodes/{{ $qrCodes->first()->url }}' target='_blank'><div class='inline-block align-text-bottom text-blue-500'>{{ __('Download') }}</div></a>
                                @else
                                    <div class='mr-2 text-sm'>{{ __('No QR codes found') }}</div>
                                @endif
                        </div>
                        @endif
                        <div>
                            @if(!$agent->isMobile())
                            <div class='text-right'>
                            @else
                            <div class='text-center mt-3'>
                            @endif
                                <div class='mb-1'>Stock Exchange Status:</div>
                                @if($config->running)
                                <button onclick='toggleRunning()' class='relative inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150'>
                                    <div class='absolute -top-px -right-px'>
                                        <span class="flex h-3 w-3 relative">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                        </span>
                                    </div>
                                    {{ __('Running') }}
                                </button></a>
                                @else
                                <button onclick='toggleRunning()' class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'>{{ __('Deactivated') }}</button>
                                @endif
                            </div>
                        </div>
                    </div>


                    @if(!$agent->isMobile())
                    <div class='flex flex-row justify-between mb-5'>
                    @else
                    <div class='mb-5'>
                    @endif
                        @if(!$agent->isMobile())
                        <div>
                                <div class='mr-2'>{{ __('Your mobile trading screen QR code: ') }}</div>
                                @if($qrCodes->isNotEmpty())
                                    <a href='/storage/resources/qrcodes/{{ $qrCodes->first()->url }}' target='_blank'><div class='inline-block align-text-bottom text-blue-500'>{{ __('Download') }}</div></a>
                                @else
                                    <div class='mr-2 text-sm'>{{ __('No QR codes found') }}</div>
                                @endif
                        </div>
                        @endif
                        @if(!$agent->isMobile())
                        <div class='text-right'>
                        @else
                        <div class='text-center mt-3'>
                        @endif
                            <div class='mb-1'>Market Crash Status:</div>
                            @if($config->crash)
                            <button onclick='toggleCrash()' class='relative inline-flex items-center px-4 py-2 bg-red-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150'>
                                <div class='absolute -top-px -right-px'>
                                    <span class="flex h-3 w-3 relative">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                    </span>
                                </div>
                                {{ __('Active') }}
                            </button></a>
                            @else
                            <button onclick='toggleCrash()' class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'>{{ __('Inactive') }}</button>
                            @endif
                        </div>
                    </div>
                    {{-- End Top Bar --}}

                </div>
            </div>
        </div>
    </div>

    @section('js')
    <script>

        const toggleRunning = async() =>
        {
            var response = await makeGetRequest('/togglerunning');
            if(response.status === 'OK')
            {
                window.location.reload();
            }
        }

        const toggleCrash = async() => 
        {
            var response = await makeGetRequest('/togglecrash');
            if(response.status === 'OK')
            {
                window.location.reload();
            }
        }

    </script>
    @endsection
</x-app-layout>
