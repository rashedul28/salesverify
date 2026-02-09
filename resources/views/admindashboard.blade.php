<x-app-layout>
    {{-- Load DataTables assets --}}
    @include('partials.datatables')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                        <table id="datatables" class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Offer Name</th>
                                    <th>Offre Source Name</th>
                                    <th>Date & time</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($offers as $offer)
                                <tr>
                                    <td>{{ $offer->id }}</td>
                                    <td>{{ $offer->name ?? 'N/A'}}</td>
                                    <!-- <td>{{ $offer->offer_source_id }}</td>  -->
                                    <td>{{ $offer->source->name ?? 'N/A' }}</td>  <!-- Safe access if no source -->
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
