<x-app-layout>
    @include('partials.datatables')
    
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Entry Sales Card -->
            <div class="bg-white/90 backdrop-blur-sm shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-100 px-6 py-4">
                    <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Entry Sales
                    </h2>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('salesman.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Offer Source --}}
                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-medium text-slate-700">Offer Source</label>
                            <select id="offer_source" name="offer_source_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 shadow-sm text-sm transition-shadow duration-200" required>
                                <option value="">-- Select Source --</option>
                                @foreach($offerSources as $source)
                                    <option value="{{ $source->id }}" {{ old('offer_source_id') == $source->id ? 'selected' : '' }}>
                                        {{ $source->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Offer Name --}}
                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-medium text-slate-700">Offer Name</label>
                            <select id="offer_name" name="offer_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 shadow-sm text-sm transition-shadow duration-200" required>
                                <option value="">-- Select Offer --</option>
                            </select>
                        </div>

                        {{-- Source ID --}}
                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-medium text-slate-700">Source ID</label>
                            <select id="source_id" name="source_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 shadow-sm text-sm transition-shadow duration-200" required>
                                <option value="">-- Select Source ID --</option> 
                                @foreach($sources as $source)
                                    <option value="{{ $source->source_id }}" {{ old('source_id') == $source->source_id ? 'selected' : '' }}>
                                        {{ $source->source_id ?? 'N/A' }}
                                    </option>   
                                @endforeach
                            </select>
                        </div>

                        {{-- Sales Date --}}
                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-medium text-slate-700">Sales Date</label>
                            <input type="date" id="sales_date" name="sales_date" value="{{ old('sales_date') }}" max="{{ now()->format('Y-m-d') }}" autocomplete="off" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 shadow-sm text-sm transition-shadow duration-200" required>
                        </div>

                        {{-- sales quantity --}}
                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-medium text-slate-700">Sales Quantity</label>
                            <input type="number" name="count" value="1" min="1" step="1" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 shadow-sm text-sm transition-shadow duration-200" required>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex flex-col justify-end lg:col-span-1 md:col-span-2">

                            <button type="submit" class="w-full py-2.5 px-4 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-medium text-sm rounded-lg hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-md transition-all duration-200">
                                Submit Sales Entry
                            </button>
                        </div>
                    </div>
                </form>
                </div>
            </div>

            <!-- Search History Card -->
            <div class="bg-white/90 backdrop-blur-sm shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-100 px-6 py-4">
                    <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search History
                    </h2>
                </div>
                
                <div class="p-6 border-b border-slate-100">
                    <form method="GET" action="{{ route('sales.filter') }}" class="w-full">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                        <!-- Start Date -->
                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-medium text-slate-700">Start Date</label>
                            <input
                                type="date"
                                name="start_date"
                                id="start_date"
                                value="{{ request('start_date') }}"
                                autocomplete="off"
                                class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 shadow-sm text-sm transition-shadow duration-200"
                                required
                            >
                        </div>

                        <!-- End Date -->
                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-medium text-slate-700">End Date</label>
                            <input
                                type="date"
                                name="end_date"
                                id="end_date"
                                value="{{ request('end_date') }}"
                                autocomplete="off"
                                class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 shadow-sm text-sm transition-shadow duration-200"
                                required
                            >
                        </div>

                        <!-- Submit -->
                        <div class="flex flex-col justify-end">
                            <button
                                type="submit"
                                class="w-full py-2.5 px-4 bg-slate-800 text-white font-medium text-sm rounded-lg hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 shadow-sm transition-all duration-200">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
                </div>
                <div class="p-6">    
                    @if (session('success'))
                        <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                            <span class="font-medium">Success!</span> {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table id="datatables" class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Offer Source</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Offer Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Source Id</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date/Time</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                    @foreach ($sales as $sale)  <!-- $offer -> $sale change to avoid confusion -->
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->offer_source_name ?? 'N/A' }}</td>
                            <td>{{ $sale->offer_name ?? 'N/A' }}</td> 
                            <td>{{ $sale->source_id ?? 'N/A' }}</td>
                            <td>{{ $sale->created_at }}</td>
                        </tr>
                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const offers = @json($offers);

    document.getElementById('offer_source').addEventListener('change', function () {
        const sourceId = this.value;
        const offerSelect = document.getElementById('offer_name');
        offerSelect.innerHTML = '<option value="">-- Select Offer --</option>';
        if (!sourceId) return;
        offers.forEach(offer => {
            if (offer.offer_source_id == sourceId) {
                const option = document.createElement('option');
                option.value = offer.id;
                option.text = offer.name;
                offerSelect.appendChild(option);
            }
        });
    });
    </script>


    <script>
        flatpickr("#start_date", {
            dateFormat: "Y-m-d",
            allowInput: true
        });

        flatpickr("#end_date", {
            dateFormat: "Y-m-d",
            allowInput: true
        });

        flatpickr("#sales_date", {
            dateFormat: "Y-m-d",
            allowInput: true,
            maxDate: "today"
        });


    </script>

    @push('datatable-scripts')
    <script>
        $(function () {
            $('#datatables').DataTable({
                dom: 'Bfrtip',
                buttons: []
            });
        });
    </script>
    @endpush
</x-app-layout>