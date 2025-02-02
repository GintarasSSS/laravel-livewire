<div>
    <div class="p-4 bg-gray-900 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4 text-white">Pending Expenses</h1>

        @if(session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 rounded">
                {{ session('message') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 table-fixed">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="py-3 px-4 text-left text-gray-300 font-semibold border-b border-gray-600">Employee</th>
                        <th class="py-3 px-4 text-left text-gray-300 font-semibold border-b border-gray-600">Description</th>
                        <th class="py-3 px-4 text-left text-gray-300 font-semibold border-b border-gray-600">Amount</th>
                        <th class="py-3 px-4 text-left text-gray-300 font-semibold border-b border-gray-600">Receipt</th>
                        <th class="py-3 px-4 text-left text-gray-300 font-semibold border-b border-gray-600 text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($expenses as $expense)
                    <tr>
                        <td class="py-3 px-4 border-b border-gray-700 text-gray-300">{{ $expense->user->name }}</td>
                        <td class="py-3 px-4 border-b border-gray-700 text-gray-300">{{ $expense->description }}</td>
                        <td class="py-3 px-4 border-b border-gray-700 text-gray-300">{{ number_format($expense->amount / 100, 2) }}</td>
                        <td class="py-3 px-4 border-b border-gray-700 text-gray-300">
                            @if($expense->receipt_path)
                                <!-- Display small receipt image -->
                                <img src="{{ asset('storage/' . $expense->receipt_path) }}" alt="Receipt" class="w-20 h-20 object-contain">
                            @else
                                No Receipt
                            @endif
                        </td>
                        <td class="py-3 px-4 border-b border-gray-700 text-gray-300">
                            <div class="flex justify-end space-x-3.5">
                                <button wire:click="updateStatus({{ $expense->id }}, 'approved')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">Approve</button>
                                <button wire:click="updateStatus({{ $expense->id }}, 'rejected')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">Reject</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4">No pending expenses.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

