<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">


                <form action="{{ route('users.assign-source', ['id' => $user->id]) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="source_id" class="block text-sm font-medium text-gray-700 mb-2">Source ID</label>
                        <input type="text" id="source_id" name="source_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Assign Source ID</button>   
                </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
