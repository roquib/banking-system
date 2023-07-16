<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto p-6 lg:p-8">

            <div class="p-4 sm:p-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-start items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Withdraws') }}
                    </h2>
                    <x-link :href="route('withdrawal.create')">
                        {{ __('New Withdraw') }}
                    </x-link>
                </div>
                @include('partials.transaction-table')

            </div>

        </div>
    </div>
</x-app-layout>
