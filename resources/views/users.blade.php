<x-app-layout>
{{-- Load DataTables assets --}}
    @include('partials.datatables')

    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Salesmen Management') }}
        </h2>
    </x-slot>

    <div class="py-12 relative z-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/90 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-2xl border border-slate-100/50">
                <div class="p-6 sm:p-8">
                    
                    <!-- Table Section -->
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold tracking-tight text-slate-800">
                            Salesmen List
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="usertable" class="w-full text-sm text-left text-slate-600 rounded-xl overflow-hidden shadow-sm">
                            <thead class="text-xs text-slate-50 uppercase bg-gradient-to-r from-indigo-500 to-purple-600">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">User Id</th>
                                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider w-64">Source Id</th>
                                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($u as $data)
                                    <tr class="bg-white border-b border-slate-100 hover:bg-slate-50/80 transition-colors">
                                        <td class="px-6 py-4 font-medium text-slate-900">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $data->id }}</td>
                                        <td class="px-6 py-4 font-medium text-slate-800">{{ $data->name }}</td>
                                        <td class="px-6 py-4">{{ $data->email }}</td>

                                        <td class="px-6 py-4">
                                            <form action="/users/assign-source/{{ $data->id }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <div class="w-full">
                                                    <input type="text"
                                                        name="source_ids"
                                                        value="{{ $data->sourceIds->pluck('source_id')->implode(', ') }}"
                                                        class="w-full text-sm bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none py-2 px-3"
                                                        placeholder="e.g. 4,5,7">
                                                </div>

                                                <button type="submit" class="shrink-0 flex items-center justify-center p-2 rounded-lg text-black bg-indigo-500 hover:bg-indigo-600 focus:outline-none border border-rose-200 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-all hover:scale-105 active:scale-95" title="Update Source IDs">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Update
                                                </button>
                                            </form>
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <a href="/users/delete/{{ $data->id }}" onclick="return confirm('Are you sure you want to delete this user?')" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-rose-600 bg-rose-50 border border-rose-200 rounded-lg hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
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