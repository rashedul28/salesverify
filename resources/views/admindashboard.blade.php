<x-app-layout>
{{-- Load DataTables assets --}}
    @include('partials.datatables')

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="card">
                                <div class="card-header">
                                        <form action="{{ route('dashboard.post') }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('POST') <!-- POST method for regeneration -->  
                                            <label for="start_date">Start Date</label>
                                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                                            <label for="end_date">End Date</label>
                                            <label for="salesman">User</label>
                                            <select name="salesman" id="">
                                                <option value="all">All</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">SUBMIT</button>
                                        </form> 
                                </div>

                                &nbsp;
                                &nbsp;
                                &nbsp;

                                &nbsp;


                                <div class="card-body">
                                    @if (isset($report) && count($report) > 0)
                                    <h2 class="mt-5">Report Results</h2>
                                    <table id="matchesTable" class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Source ID</th>
                                                <th>Offers Source</th>
                                                <th>Offer Name</th>
                                                <th>Sales</th>
                                                <th>Target</th>
                                                <th>Verify</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($report as $row)
                                                <tr>
                                                    <td>{{ $row['no'] }}</td>
                                                    <td>{{ $row['source_id'] }}</td>
                                                    <td>{{ $row['offers_source'] }}</td>
                                                    <td>{{ $row['offer_name'] }}</td>
                                                    <td>{{ $row['sales'] }}</td>
                                                    <td>{{ $row['target'] }}</td>
                                                    <td>{{ $row['verify'] }}</td>
                                                    <td>{{ $row['date'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @elseif (isset($report))
                                    <p class="mt-5">No matching data found for the selected date range.</p>
                                @endif
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