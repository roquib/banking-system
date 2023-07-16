<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Withdraw
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (session('success'))
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600">{{ session('success') }}</p>
                @elseif(session('error'))
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-red-600">{{ session('error') }}</p>
                @endif
                <form method="post" action="{{ route('withdrawal.store') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('post')
                    <div>
                        <x-input-label for="user_id" :value="__('User')" />
                        <x-select id="user_id" name="user_id" type="text" class="mt-1 block w-full" required
                            autofocus autocomplete="user_id" :options="$options" />
                        <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                    </div>
                    <div>
                        <x-input-label for="amount" :value="__('Amount')" />
                        <x-text-input id="amount" name="amount" type="number" min="0"
                            class="mt-1 block w-full" required autofocus autocomplete="amount" />
                        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
