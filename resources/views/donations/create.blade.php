<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulir Donasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('donations.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <x-input-label for="jumlah" :value="__('Jumlah Donasi (Rp)')" />
                            <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" :value="old('jumlah')" required autofocus />
                            <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="metode_pembayaran" :value="__('Metode Pembayaran')" />
                            <select name="metode_pembayaran" id="metode_pembayaran" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="transfer_bank">Transfer Bank</option>
                                <option value="gopay">GoPay</option>
                                <option value="dana">DANA</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="bukti_transfer" :value="__('Upload Bukti Transfer')" />
                            <x-text-input id="bukti_transfer" class="block mt-1 w-full" type="file" name="bukti_transfer" required />
                            <x-input-error :messages="$errors->get('bukti_transfer')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Kirim Donasi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
