<x-app-layout>
{{-- Load DataTables assets --}}
    @include('partials.datatables')

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                            

                            <div class="card">
                                <div class="card-header">
                                    <h1 class="mb-0">SALESMEN LIST</h1>
                                </div>
                                <div class="card-body">
                                    <table id="usertable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>User Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Source Id</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($u as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->id }}</td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>{{ $data->email }}</td>

                                                    <td>
                                                        <form action="/users/assign-source/{{ $data->id }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')   <!-- optional – more RESTful -->

                                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                                Source IDs (comma separated)
                                                            </label>
                                                            <input type="text"
                                                                name="source_ids"
                                                                value="{{ $data->sourceIds->pluck('source_id')->implode(', ') }}"
                                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                                                placeholder="e.g. 4,5,7">

                                                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                                                Update
                                                            </button>
                                                        </form>
                                                    </td>

                                                    <td>
                                                        <a href="/users/delete/{{ $data->id }}">
                                                            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                                                Delete
                                                            </button>
                                                        </a>
                                                    </td>
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
    $('#usertable').DataTable({
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