<x-app-layout>
    {{-- Load DataTables assets --}}
    @include('partials.datatables')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Upload Card -->
            <div class="bg-white/90 backdrop-blur-sm shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-100 px-6 py-4">
                    <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Upload CSV File
                    </h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.fileupload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="flex flex-col sm:flex-row gap-4 items-center">
                            <input type="file" name="csv_file" accept=".csv" required class="w-full sm:flex-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors border-slate-200 border rounded-lg cursor-pointer bg-white focus:outline-none">
                            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-medium text-sm rounded-lg hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-md transition-all duration-200">
                                Upload Data
                            </button>
                        </div>
                        @error('csv_file')
                            <span class="text-red-500 text-sm mt-2 block font-medium">{{ $message }}</span>
                        @enderror
                    </form>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white/90 backdrop-blur-sm shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-100 px-6 py-4">
                    <h2 class="text-lg font-semibold text-slate-800">Uploaded Records</h2>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table id="datatables" class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Id</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date & Time</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Offer Source</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Offer Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Country</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Source Id</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Referrer</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @foreach($files as $file)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $file->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $file->date_time }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $file->offer_source}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $file->offer_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $file->country }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-mono">{{ $file->source_id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $file->referrer }}</td>   
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
            $(function () {
                $('#datatables').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                });
            });
        </script>
        @endpush
    

</x-app-layout>
