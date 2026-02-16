<x-app-layout>
    @include('partials.datatables')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                
                <form action="/dashboard2/create" method="POST" class="mb-6">
                    @csrf

                    {{-- Offer Source --}}
                    <div class="mb-4">
                        <label class="block mb-2">Offer Source</label>
                        <select id="offer_source" name="offer_source_id" class="w-full border p-2" required>
                            <option value="">-- Select Source --</option>
                            @foreach($offerSources as $source)
                                <option value="{{ $source->id }}" {{ old('offer_source_id') == $source->id ? 'selected' : '' }}>
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

                    {{-- Source ID --}}
                    <div class="mb-4">
                        <label class="block mb-2">Source ID</label>
                        <select id="source_id" name="source_id" class="w-full border p-2" required>
                            <option value="">-- Select Source ID --</option> 
                            @foreach($sources as $source)
                                <option value="{{ $source->source_id }}" {{ old('source_id') == $source->source_id ? 'selected' : '' }}>
                                    {{ $source->source_id ?? 'N/A' }}
                                </option>   
                            @endforeach
                        </select>
                    </div>

                    {{-- Sales Date --}}
                    <div class="mb-4 mt-4">
                        <label class="block mb-2">Sales Date</label>
                        <input type="date" name="sales_date" value="{{ old('sales_date') }}" max="{{ now()->format('Y-m-d') }}" class="w-full border p-2" required>
                    </div>

                    {{-- sales quantity --}}
                    <div class="mb-4 mt-4">
                        <label class="block mb-2">Sales Quantity</label>
                        <input type="number" name="count" value="1" min="1" step="1" class="w-full border p-2" required>
                    </div>


                    {{-- Submit Button --}}

                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
                        Submit
                    </button>
                </form>

                <br><br>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table id="datatables" class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Offer Source</th>
                            <th>Offer Name</th>
                            <th>Source Id</th>
                            <th>Date/Time</th>
                        </tr>
                    </thead>
                    <tbody>
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