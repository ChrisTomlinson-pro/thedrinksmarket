<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Next step: Contact Support') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Contact Support Message --}}
                    <div class='text-center'>
                        <p class="font-semibold text-1xl text-gray-800 leading-tight">
                            To activate your account and begin using The Drinks Market, please contact the support team so we can integrate our infrastructure with your till system.
                        </p>
                    </div>
                    {{-- End Contact Support Message --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>