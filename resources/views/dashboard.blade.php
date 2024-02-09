<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Welcome, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="p-5 text-center">
        <h2 class="fw-semibold fs-5 text-light mb-0">
            Overall Leaderboards
        </h2>
    </div>

    <div class="mx-auto p-5 row">
        <div class="table-responsive col-lg-6">
            <table class="table w-75 mx-auto my-5">
                <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col" class="text-left">Rank</th>
                        <th scope="col" class="text-left">Candidate</th>
                        <th scope="col" class="text-right">Calls</th>
                    </tr>
                </thead>
                <tbody class="text-secondary">
                    @foreach ($topUsersByCalls as $user)
                        <tr>
                            <td class="text-left">
                                #{{ $loop->iteration }}
                            </td>
                            <td class="text-left">
                                {{ $user->name }}
                            </td>
                            <td class="text-right">
                                {{ $user->calls }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="table-responsive col-lg-6">
            <table class="table w-75 mx-auto my-5">
                <thead class="bg-dark text-light">
                    <tr>
                        <th scope="col" class="text-left">Rank</th>
                        <th scope="col" class="text-left">Candidate</th>
                        <th scope="col" class="text-right">Leads Registered</th>
                    </tr>
                </thead>
                <tbody class="text-secondary">
                    @foreach ($topUsersByDeals as $user)
                        <tr>
                            <td class="text-left">
                                #{{ $loop->iteration }}
                            </td>
                            <td class="text-left">
                                {{ $user->name }}
                            </td>
                            <td class="text-right">
                                {{ $user->registered_leads }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="table-responsive col-lg-6">
            <table class="table w-75 mx-auto my-5">
                <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col" class="text-left">Rank</th>
                        <th scope="col" class="text-left">Candidate</th>
                        <th scope="col" class="text-right">Demonstrations</th>
                    </tr>
                </thead>
                <tbody class="text-secondary">
                    @foreach ($topUsersByDemos as $user)
                        <tr>
                            <td class="text-left">
                                #{{ $loop->iteration }}
                            </td>
                            <td class="text-left">
                                {{ $user->name }}
                            </td>
                            <td class="text-right">
                                {{ $user->demonstrations }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="table-responsive col-lg-6">
            <table class="table w-75 mx-auto my-5">
                <thead class="bg-dark text-light">
                    <tr>
                        <th scope="col" class="text-left">Rank</th>
                        <th scope="col" class="text-left">Candidate</th>
                        <th scope="col" class="text-right">Deals Closed</th>
                    </tr>
                </thead>
                <tbody class="text-secondary">
                    @foreach ($topUsersByDeals as $user)
                        <tr>
                            <td class="text-left">
                                #{{ $loop->iteration }}
                            </td>
                            <td class="text-left">
                                {{ $user->name }}
                            </td>
                            <td class="text-right">
                                {{ $user->deals_closed }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>       
    </div>  
    

    <div class="p-5 text-center">
        <h2 class="fw-semibold fs-5 text-light mb-0">
            Your Statistics
        </h2>
    </div>

    <div class="p-5 row">
        
        <div class="mx-fill p-2 col-6 col-md-2 mb-4">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->visits}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Visits
                </div>
            </div>
        </div>

        <div class="mx-fill p-2 col-6 col-md-2 mb-4">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->calls}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Calls
                </div>
            </div>
        </div>

        <div class="mx-fill p-2 col-6 col-md-2 mb-4">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->leads}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Leads
                </div>
            </div>
        </div>

        <div class="mx-fill p-2 col-6 col-md-2 mb-4">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->registered_leads}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Leads Registered
                </div>
            </div>
        </div>

        <div class="mx-fill p-2 col-6 col-md-2 mb-4">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->phone_calls}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Phone Calls Made
                </div>
            </div>
        </div>

        <div class="mx-fill p-2 col-6 col-md-2 mb-4">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->calls_confirmed}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Calls Confirmed
                </div>
            </div>
        </div>

        <div class="mx-fill p-2 col-6 col-md-2 mb-4">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->presentations}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Presentations Given
                </div>
            </div>
        </div>

        <div class="mx-fill p-2 col-6 col-md-2 mb-4">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->demonstrations}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Demonstrations Given
                </div>
            </div>
        </div>

        <div class="mx-fill p-2 col-6 col-md-2 mb-4">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->letters}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Letters Sent
                </div>
            </div>
        </div>

        <div class="mx-fill p-2 col-6 col-md-2 mb-4">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->second_visits}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Second Visits Made
                </div>
            </div>
        </div>

        <div class="mx-fill p-2 col-6 col-md-2 mb-4">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{$totalTally->proposals}}
                </div>
                <div class="p-2 text-xs text-gray-900 dark:text-gray-100">
                    Proposals
                </div>
            </div>
        </div>

        <div class="mx-fill p-2 col-6 col-md-2 mb-4">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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
