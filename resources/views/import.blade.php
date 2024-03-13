<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <!-- <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a> -->
        </x-slot>
        @if (session('success_message'))
            <div class="alert alert-success rounded-md" style="background-color: #d4edda; border-color: #c3e6cb; color: #155724; padding: 10px; margin-bottom: 15px;">
                {{ session('success_message') }}
            </div>
        @endif

        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Game -->
            <div>
                <x-label for="game" :value="__('Choose Game')" />

                <select id="game" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="game" >
                        <option value="powerball" selected>Powerball</option>
                        <option value="luckyforlife">Lucky For Life</option>
                        <option value="megamillions">Megamillions</option>
                </select>
            </div>
            <!-- File -->
            <div class="flex items-center justify-start py-4">
                <div>
                    <x-label for="file" :value="__('Choose .CSV File')" />

                    <x-input id="file" type="file" name="file" :value="old('file')"  accept=".csv" required  />
                </div>
            </div>
            <x-button>
                Import CSV
            </x-button>
        </form>
    </x-auth-card>
</x-guest-layout>