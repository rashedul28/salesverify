<x-app-layout>
    @include('partials.datatables')

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/90 backdrop-blur-sm border border-slate-200 overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-8 text-slate-800">

                    @if (session('success'))
                        <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                            <span class="font-medium">Success!</span> {{ session('success') }}
                        </div>
                    @endif

                    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden mb-8">
                        <div class="bg-slate-50 border-b border-slate-100 px-6 py-4">
                            <h5 class="mb-0 text-lg font-semibold text-slate-800 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Sales Performance Filter
                            </h5>
                        </div>

                        <div class="p-6">
                            <form action="{{ route('dashboard.post') }}" method="POST" class="w-full">
                                @csrf
                                @method('POST')

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5 items-end">
                                    <!-- Start Date -->
                                    <div class="flex flex-col">
                                        <label for="start_date" class="mb-1.5 text-sm font-medium text-gray-700">
                                            Start Date
                                        </label>
                                        <input 
                                            type="date" 
                                            name="start_date" 
                                            id="start_date" 
                                            max="{{ now()->format('Y-m-d') }}" 
                                            value="{{ old('start_date') }}" 
                                            autocomplete="off"
                                            class="form-control border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-lg shadow-sm"
                                            required
                                        >
                                    </div>

                                    <!-- End Date -->
                                    <div class="flex flex-col">
                                        <label for="end_date" class="mb-1.5 text-sm font-medium text-gray-700">
                                            End Date
                                        </label>
                                        <input 
                                            type="date" 
                                            name="end_date" 
                                            id="end_date" 
                                            max="{{ now()->format('Y-m-d') }}" 
                                            value="{{ old('end_date') }}" 
                                            autocomplete="off"
                                            class="form-control border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-lg shadow-sm"
                                            required
                                        >
                                    </div>

                                    <!-- User / Salesman -->
                                    <div class="flex flex-col">
                                        <label for="username" class="mb-1.5 text-sm font-medium text-gray-700">
                                            User
                                        </label>
                                        <select 
                                            name="username" 
                                            id="username" 
                                            class="w-full mt-1 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 shadow-sm text-sm transition-shadow duration-200"
                                        >
                                            <option value="">— Select User —</option>
                                            @foreach($saleuser as $sale)
                                                <option value="{{ $sale->user->name }}" {{ old('username') == $sale->user->name ? 'selected' : '' }}>
                                                    {{ $sale->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex flex-col">
                                        <label class="mb-1.5 text-sm font-medium text-gray-700 invisible">Action</label>
                                        <button 
                                            type="submit" 
                                            class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-medium text-sm rounded-lg hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg w-full sm:w-auto flex justify-center items-center"
                                        >
                                            Generate Report
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Results Section -->
                    <div>
                        @if (isset($data) && $data->isNotEmpty())
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-bold tracking-tight text-slate-800">Report Results</h2>
                            </div>
                            <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                                <table id="matchesTable" class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider rounded-tl-xl text-center">#</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">User Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Source ID</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Offer Source</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Offer Name</th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Sales</th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Target</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider rounded-tr-xl">Matched?</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($data as $row)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $row->username }}</td>
                                            <td>{{ $row->source_id }}</td>
                                            <td>{{ $row->offer_source_name }}</td>
                                            <td>{{ $row->offer_name }}</td>
                                            <td class="text-right">{{ $row->total_sales }}</td>
                                            <td class="text-right">{{ $row->target }}</td>
                                            <td class="text-center font-medium">
                                                @if($row->matched == 'Yes')
                                                    <span class="text-green-600">Yes</span>
                                                @else
                                                    <span class="text-red-600">No</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        @elseif (isset($data))
                            <div class="mt-6 p-4 rounded-xl bg-amber-50 border border-amber-200 flex items-center gap-3 text-amber-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium">No matching data found for the selected date range.</span>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

@push('datatable-scripts')
<script>
$(document).ready(function() {
    $('#matchesTable').DataTable({
        order: [[0, 'desc']],
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100, 250],
        responsive: true,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});

flatpickr("#start_date", {
    dateFormat: "Y-m-d",
    allowInput: true,
    maxDate: "today"
});

flatpickr("#end_date", {
    dateFormat: "Y-m-d",
    allowInput: true,
    maxDate: "today"
});
</script>
@endpush

</x-app-layout>