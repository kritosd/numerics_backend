<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        <form action="{{ route('importtemplate') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="col-md-4 control-label" for="service_status">Service Status</label>
                <div class="col-md-4">
                <select id="service_status" name="service_status" class="form-control">
                </select>
                </div>
            </div>
            
            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>
            <!-- Begin from -->
            <div>
                <x-label for="begin_from" :value="__('Begin from line')" />

                <x-input id="begin_from" class="block mt-1 w-full" type="number" min="1" name="begin_from" :value="old('email')" required />

                <select id="dropdown" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="dropdown" >
                        <option value="0">none</option>
                        <option value="0">none2</option>
                </select>
            </div>

            <!-- Date -->
            <div>
                <x-label for="date_column" :value="__('Date Column')" />

                <x-input id="date_column" class="block mt-1 w-full" type="number" min="1" name="date_column" :value="1" required />
            </div>
            <!-- Winning Numbers -->
            <div>
                <x-label for="winning_numbers_column" :value="__('Winning Numbers Column')" />

                <x-input id="winning_numbers_column" class="block mt-1 w-full" type="number" min="1" name="winning_numbers_column" :value="1" required />
            </div>

            <button type="submit">Create Template</button>
        </form>
    </x-auth-card>
</x-guest-layout>