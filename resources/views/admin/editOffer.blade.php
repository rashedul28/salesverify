<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">


                <form action="{{ route('offers.ok') }}">
                    @csrf
                    <div class="mb-4">
                        <input type="text" id="offer_source_id" name="offer_source_id" value="{{ $offer->source->id ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" hidden>
                        <label for="offer_source_name" class="block text-sm font-medium text-gray-700 mb-2">Offer Source</label>
                        <input type="text" id="offer_source_name" name="offer_source_name" value="{{ $offer->source->name ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" id="offer_id" name="offer_id" value="{{ $offer->id ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" hidden>
                        <label for="offer_name" class="block text-sm font-medium text-gray-700 mb-2">Offer Name</label>
                        <input type="text" id="offer_name" name="offer_name" value="{{ $offer->name ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Offer</button>
                </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
