<x-app-layout>
    {{-- Load DataTables assets --}}
    @include('partials.datatables')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold mb-4">Upload CSV File</h2>
                        <form action="{{ route('admin.fileupload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="flex gap-4">
                                <input type="file" name="csv_file" accept=".csv" required class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Upload</button>
                            </div>
                            @error('csv_file')
                                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </form>
                    </div>

                   
                        <h2 class="text-2xl font-bold mb-4">Uploaded Files</h2>
                        <table id="datatables" class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Id</th>
                                    <th class="py-2 px-4 border-b">Date & time</th>
                                    <th class="py-2 px-4 border-b">Offer Source</th>
                                    <th class="py-2 px-4 border-b">Offer</th>
                                    <th class="py-2 px-4 border-b">country</th>
                                    <th class="py-2 px-4 border-b">Source Id</th>
                                    <th class="py-2 px-4 border-b">Referrer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $file)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $file->id }}</td>
                                        <td class="py-2 px-4 border-b">{{ $file->date_time }}</td>
                                        <td class="py-2 px-4 border-b">{{ $file->offer_source}}</td>
                                        <td class="py-2 px-4 border-b">{{ $file->offer_name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $file->country }}</td>
                                        <td class="py-2 px-4 border-b">{{ $file->source_id }}</td>
                                        <td class="py-2 px-4 border-b">{{ $file->referrer }}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    
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
