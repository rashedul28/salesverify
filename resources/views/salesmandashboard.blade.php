<x-app-layout>
    {{-- Load DataTables assets --}}
    @include('partials.datatables')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                
                <form action="{{ route('salesman.store') }}" method="POST">
                    @csrf

                    {{-- Offer Source --}}
                    <div class="mb-4">
                        <label class="block mb-2">Offer Source</label>
                        <select id="offer_source" name="offer_source_id" class="w-full border p-2" required>
                            <option value="">-- Select Source --</option>
                            @foreach($offerSources as $source)
                                <option value="{{ $source->id }}">
                                    {{ $source->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Offer Name --}}
                    <div class="mb-4">
                        <label class="block mb-2">Offer Name</label>
                        <select id="offer_name" name="offer_id" class="w-full border p-2" required>
                            <option value="">-- Select Offer --</option>
                        </select>
                    </div>

                    <button class="bg-blue-600 text-white px-6 py-2 rounded">
                        Submit
                    </button>
                </form>

                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;

                 <table id="datatables" class="min-w-full bg-white border border-gray-200">
                     <thead>
                         <tr>
                             <th>No</th>
                             <th>Offer Source</th>
                             <th>Offre Name</th>
                             <th>Source Id</th>
                             <th>Date/Time</th>
                         </tr>
                     </thead>
                     <tbody>
                     @forelse ($sales as $offer)
                         <tr>
                             <td>{{ $offer->id }}</td>
                             <td>{{ $offer->offer_source_name ?? 'N/A'}}</td>
                             <td>{{ $offer->offer_name }}</td> 
                             <td>{{ $offer->source_id ?? 'N/A' }}</td>  <!-- Safe access if no source -->
                             <td>{{ $offer->created_at }}</td>
                             
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


        <script>
        const offers = @json($offers);

        document.getElementById('offer_source').addEventListener('change', function () {
            const sourceId = this.value;
            const offerSelect = document.getElementById('offer_name');

            // reset dropdown
            offerSelect.innerHTML = '<option value="">-- Select Offer --</option>';

            if (!sourceId) return;

            offers.forEach(offer => {
                if (offer.offer_source_id == sourceId) {
                    const option = document.createElement('option');
                    option.value = offer.id;      // offer id
                    option.text  = offer.name;    // offer name
                    offerSelect.appendChild(option);
                }
            });
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
