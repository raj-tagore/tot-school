<x-app-layout>
    @if ($submitted == true )
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Data submitted for today.
        </h2>
    </x-slot>
    @else
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Form for {{date('d-m-y')}}
        </h2>
    </x-slot>
    <div class="p-6 max-w-7xl mx-auto">
        <form method="POST" action="{{ route('log-tally') }}"> <!-- Update this route to the correct one for storing daily tally entries -->
            @csrf
            <!-- Number of Visits -->
            <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="">
                <x-input-label for="visits" :value="__('Number of Visits')" />
                <x-text-input id="visits" class="block mt-1 w-full" type="number" name="visits" :value="old('visits')" />
                <x-input-error :messages="$errors->get('visits')" class="mt-2" />
            </div>
    
            <!-- Number of Calls -->
            <div class="">
                <x-input-label for="calls" :value="__('Number of Calls')" />
                <x-text-input id="calls" class="block mt-1 w-full" type="number" name="calls" :value="old('calls')" />
                <x-input-error :messages="$errors->get('calls')" class="mt-2" />
            </div>
    
            <!-- Number of Leads -->
            <div class="">
                <x-input-label for="leads" :value="__('Number of Leads')" />
                <x-text-input id="leads" class="block mt-1 w-full" type="number" name="leads" :value="old('leads')" />
                <x-input-error :messages="$errors->get('leads')" class="mt-2" />
            </div>
    
            <!-- Number of Registered Leads -->
            <div class="">
                <x-input-label for="registered_leads" :value="__('Number of Registered Leads')" />
                <x-text-input id="registered_leads" class="block mt-1 w-full" type="number" name="registered_leads" :value="old('registered_leads')" />
                <x-input-error :messages="$errors->get('registered_leads')" class="mt-2" />
            </div>
    
            <!-- Number of Phone Calls -->
            <div class="">
                <x-input-label for="phone_calls" :value="__('Number of Phone Calls')" />
                <x-text-input id="phone_calls" class="block mt-1 w-full" type="number" name="phone_calls" :value="old('phone_calls')" />
                <x-input-error :messages="$errors->get('phone_calls')" class="mt-2" />
            </div>
    
            <!-- Number of Calls Confirmed -->
            <div class="">
                <x-input-label for="calls_confirmed" :value="__('Number of Calls Confirmed')" />
                <x-text-input id="calls_confirmed" class="block mt-1 w-full" type="number" name="calls_confirmed" :value="old('calls_confirmed')" />
                <x-input-error :messages="$errors->get('calls_confirmed')" class="mt-2" />
            </div>
    
            <!-- Number of Agenda Sheet Presentations -->
            <div class="">
                <x-input-label for="presentations" :value="__('Number of Agenda Sheet Presentations')" />
                <x-text-input id="presentations" class="block mt-1 w-full" type="number" name="presentations" :value="old('presentations')" />
                <x-input-error :messages="$errors->get('presentations')" class="mt-2" />
            </div>
    
            <!-- Number of Demonstrations -->
            <div class="">
                <x-input-label for="demonstrations" :value="__('Number of Demonstrations')" />
                <x-text-input id="demonstrations" class="block mt-1 w-full" type="number" name="demonstrations" :value="old('demonstrations')" />
                <x-input-error :messages="$errors->get('demonstrations')" class="mt-2" />
            </div>
    
            <!-- Number of Follow Up Letters -->
            <div class="">
                <x-input-label for="letters" :value="__('Number of Follow Up Letters')" />
                <x-text-input id="letters" class="block mt-1 w-full" type="number" name="letters" :value="old('letters')" />
                <x-input-error :messages="$errors->get('letters')" class="mt-2" />
            </div>
    
            <div class="">
                <x-input-label for="second_visits" :value="__('Number of Second Visits')" />
                <x-text-input id="second_visits" class="block mt-1 w-full" type="number" name="second_visits" :value="old('second_visits')" />
                <x-input-error :messages="$errors->get('second_visits')" class="mt-2" />
            </div>
    
            <div class="">
                <x-input-label for="proposals" :value="__('Number of proposals')" />
                <x-text-input id="proposals" class="block mt-1 w-full" type="number" name="proposals" :value="old('proposals')" />
                <x-input-error :messages="$errors->get('proposals')" class="mt-2" />
            </div>
    
            <div class="">
                <x-input-label for="deals_closed" :value="__('Number of deals closed')" />
                <x-text-input id="deals_closed" class="block mt-1 w-full" type="number" name="deals_closed" :value="old('deals_closed')" />
                <x-input-error :messages="$errors->get('deals_closed')" class="mt-2" />
            </div>
            </div>
    
            <!-- Add fields for all the other metrics in a similar manner -->
            <!-- Number of Leads, Registered Leads, Phone Calls, Calls Confirmed, Presentations, Demonstrations, Letters, Second Visits, Proposals, Deals Closed -->
    
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Submit') }}
                </x-primary-button>
            </div>
        </form>
    </div>
    @endif
</x-app-layout>
