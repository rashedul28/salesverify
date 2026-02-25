<x-app-layout>
    {{-- Load DataTables assets --}}
    @include('partials.datatables')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- First Form Card -->
                <div class="bg-white/90 backdrop-blur-sm shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-100 px-6 py-4">
                        <h2 class="text-lg font-semibold text-slate-800">Create Offer Source</h2>
                    </div>
                    <div class="p-6">
                        <h2 class="text-lg font-semibold mb-4">Create Offer Source</h2>
                        <form action="{{ route('admin.offersource') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="offers_source" class="block text-sm font-medium text-slate-700 mb-1.5">Offer Source Name</label>
                                <input type="text" id="offers_source" name="offers_source" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 shadow-sm text-sm transition-shadow duration-200" required>
                            </div>
                            <button type="submit" class="w-full py-2.5 px-4 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-medium text-sm rounded-lg hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-md transition-all duration-200">
                                Create Source
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Second Form Card -->
                <div class="bg-white/90 backdrop-blur-sm shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-100 px-6 py-4">
                        <h2 class="text-lg font-semibold text-slate-800">Create Offer Name</h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.offername') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="source_id" class="block text-sm font-medium text-slate-700 mb-1.5">Select Offer Source</label>
                                <select id="source_id" name="source_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 shadow-sm text-sm transition-shadow duration-200" required>
                                    <option value="">-- Select Source --</option>
                                    @foreach($offerSource as $source)
                                        <option value="{{ $source->id }}">{{ $source->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-6">
                                <label for="offer_names" class="block text-sm font-medium text-slate-700 mb-1.5">Offer Name</label>
                                <input type="text" id="offer_names" name="offer_names" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 shadow-sm text-sm transition-shadow duration-200" required>
                            </div>
                            <button type="submit" class="w-full py-2.5 px-4 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-medium text-sm rounded-lg hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-md transition-all duration-200">
                                Create Offer
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white/90 backdrop-blur-sm shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-100 px-6 py-4">
                    <h2 class="text-lg font-semibold text-slate-800">Existing Offers</h2>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table id="datatables" class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Offer Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Offer Source Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date & Time</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                        @forelse ($offers as $offer)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $offer->name ?? 'N/A'}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $offer->source->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $offer->created_at->format('M d, Y H:i A') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <a href="/offers/edit/{{$offer->source->id ?? 0}}/{{$offer->id}}" class="inline-flex m-1">
                                        <button class="px-3 py-1.5 bg-amber-500 text-white text-xs font-medium rounded-md hover:bg-amber-600 transition-colors shadow-sm">Edit</button>   
                                    </a>
                                    <a href="/offers/delete/{{$offer->source->id ?? 0}}/{{$offer->id}}" class="inline-flex m-1">
                                        <button class="px-3 py-1.5 bg-red-500 text-white text-xs font-medium rounded-md hover:bg-red-600 transition-colors shadow-sm">Delete</button>   
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No offers found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



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
