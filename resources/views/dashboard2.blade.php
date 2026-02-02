<x-app-layout>
    @include('partials.datatables')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <table id="adminTable" class="display w-full">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>admin</td>
                            <td>admin</td>
                            <td>admin</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    @push('datatable-scripts')
    <script>
        $(function () {
            $('#adminTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy','csv','excel','pdf','print']
            });
        });
    </script>
    @endpush
</x-app-layout>
