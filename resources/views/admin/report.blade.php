<x-app-layout>
{{-- Load DataTables assets --}}
    @include('partials.datatables')

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                            <h1 class="mt-4 mb-4">Daily Sales – File Match Summary</h1>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="card">
                                <div class="card-header">
                                        <form action="{{ route('sales.generate-file-matches') }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('POST') <!-- POST method for regeneration -->   
                                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Regenarate Summary</button>
                                        </form> 
                                </div>

                                <div class="card-body">
                                    <table id="matchesTable" class="table table-striped table-hover table-bordered" style="width:100%">
                                        <thead class="table-dark">
                                            <tr>
                                
                                                <th>Source ID</th>
                                                <th>Offer Source</th>
                                                <th>Offer Name</th>
                                                <th>Sales Count</th>
                                                <th>Last Updated</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($matches as $row)
                                            <tr>
                                            
                                                <td>{{ $row->source_id }}</td>
                                                <td>{{ $row->offer_source_name }}</td>
                                                <td>{{ $row->offer_name }}</td>
                                                <td class="text-end">{{ number_format($row->sales_count) }}</td>
                                                <td>{{ $row->updated_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            



@push('datatable-scripts')
<script>
$(document).ready(function() {
    $('#matchesTable').DataTable({
        order: [[0, 'desc']],           // newest date first
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100, 250],
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>
@endpush

</x-app-layout> 