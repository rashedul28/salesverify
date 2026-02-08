<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- First Form -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold mb-4">Create Offer Source</h2>
                        <form action="{{ route('admin.offersource') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="offers_source" class="block text-sm font-medium text-gray-700 mb-2">Offer Source</label>
                                <input type="text" id="offers_source" name="offers_source" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                            </div>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Source</button>
                        </form>
                    </div>

                    <!-- Second Form -->
                    <div>
                        <h2 class="text-lg font-semibold mb-4">Create Offer Name</h2>
                        <form action="{{ route('admin.offername') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="source_id" class="block text-sm font-medium text-gray-700 mb-2">Select Offer Source</label>
                                <select id="source_id" name="source_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                                    <option value="">-- Select Source --</option>
                                    @foreach($offerSource as $source)
                                        <option value="{{ $source->id }}">{{ $source->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="offer_names" class="block text-sm font-medium text-gray-700 mb-2">Offer Name</label>
                                <input type="text" id="offer_names" name="offer_names" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                            </div>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Offer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
