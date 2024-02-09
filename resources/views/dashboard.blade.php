<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Welcome, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="p-10">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Overall Leaderboards
        </h2>
    </div>

    <div class="grid md:grid-cols-3 mx-auto p-5">
        <table class="w-11/12 table-auto p-5">
            <thead>
                <tr class="bg-gray-800 text-gray-100 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Rank</th>
                    <th class="py-3 px-6 text-left">Candidate</th>
                    <th class="py-3 px-6 text-right">Calls</th>
                </tr>
            </thead>
            <tbody class="text-gray-200 text-sm font-light">
                @foreach ($topUsersByCalls as $user)
                    <tr class="border-b border-gray-200">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            #{{ $loop->iteration }}
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $user->name }}
                        </td>
                        <td class="py-3 px-6 text-right">
                            {{ $user->calls }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class="w-11/12 table-auto p-5">
            <thead>
                <tr class="bg-gray-800 text-gray-100 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Rank</th>
                    <th class="py-3 px-6 text-left">Candidate</th>
                    <th class="py-3 px-6 text-right">Demonstrations</th>
                </tr>
            </thead>
            <tbody class="text-gray-200 text-sm font-light">
                @foreach ($topUsersByDemos as $user)
                    <tr class="border-b border-gray-200">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            #{{ $loop->iteration }}
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $user->name }}
                        </td>
                        <td class="py-3 px-6 text-right">
                            {{ $user->demonstrations }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class="w-11/12 table-auto p-5">
            <thead>
                <tr class="bg-gray-800 text-gray-100 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Rank</th>
                    <th class="py-3 px-6 text-left">Candidate</th>
                    <th class="py-3 px-6 text-right">Deals Closed</th>
                </tr>
            </thead>
            <tbody class="text-gray-200 text-sm font-light">
                @foreach ($topUsersByDeals as $user)
                    <tr class="border-b border-gray-200">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            #{{ $loop->iteration }}
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $user->name }}
                        </td>
                        <td class="py-3 px-6 text-right">
                            {{ $user->deals_closed }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>   
    </div>  
    

    <div class="p-10">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Your Statistics
        </h2>
    </div>

    <div class="p-2 grid sm:grid-cols-6">
        
        <div class="mx-fill p-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->visits}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Visits
                </div>
            </div>
        </div>

        <div class="mx-fill p-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->calls}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Calls
                </div>
            </div>
        </div>

        <div class="mx-fill p-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->leads}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Leads
                </div>
            </div>
        </div>

        <div class="mx-fill p-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->registered_leads}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Leads Registered
                </div>
            </div>
        </div>

        <div class="mx-fill p-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->phone_calls}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Phone Calls Made
                </div>
            </div>
        </div>

        <div class="mx-fill p-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->calls_confirmed}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Calls Confirmed
                </div>
            </div>
        </div>

        <div class="mx-fill p-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->presentations}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Presentations Given
                </div>
            </div>
        </div>

        <div class="mx-fill p-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->demonstrations}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Demonstrations Given
                </div>
            </div>
        </div>

        <div class="mx-fill p-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->letters}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Letters Sent
                </div>
            </div>
        </div>

        <div class="mx-fill p-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->second_visits}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Second Visits Made
                </div>
            </div>
        </div>

        <div class="mx-fill p-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->proposals}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Proposals
                </div>
            </div>
        </div>

        <div class="mx-fill p-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->deals_closed}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Deals Closed
                </div>
            </div>
        </div>
            
    </div>
</x-app-layout>
