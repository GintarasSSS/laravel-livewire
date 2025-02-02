<div class="max-w-lg mx-auto p-6 rounded-lg">
    <h2 class="text-xl font-semibold mb-4">Submit Expense</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block">Description</label>
            <input type="text" wire:model="description" class="w-full px-3 py-2 border rounded text-gray-700">
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block">Amount</label>
            <input type="number" min="0" step="0.01" wire:model="amount" class="w-full px-3 py-2 border rounded text-gray-700">
            @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block">Category</label>
            <input type="text" wire:model="category" class="w-full px-3 py-2 border rounded text-gray-700">
            @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <div class="mb-6">
                <label class="block">Receipt <span class="text-xs">PNG, JPG (MAX 1MB)</span></label>
                <div class="relative">
                    <input
                        type="file"
                        id="file"
                        name="file"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        wire:model="receipt"
                        wire:key="receipt-file-input"
                    />

                    <div class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 flex items-center justify-between">
                        <span id="file-name" class="truncate">Choose a file...</span>
                        <span class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">Browse</span>
                    </div>
                </div>

                @error('receipt') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                @if ($receipt)
                    <p class="mt-2 text-sm">Preview:</p>

                    @php
                        $extension = strtolower($receipt->getClientOriginalExtension());
                    @endphp

                    @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                        <img src="{{ $receipt->temporaryUrl() }}" class="w-32 h-32 object-cover mt-2">
                    @else
                        <p class="text-red-500 text-sm mt-2">Only JPG and PNG images are allowed.</p>
                    @endif
                @endif
            </div>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">Submit Expense</button>
    </form>

    <div class="mt-6">
        <h3 class="text-xl font-semibold">Your Submitted Expenses</h3>

        @forelse($userExpenses as $expense)
            <div class="mt-4 p-4 border rounded-lg shadow-sm flex items-center justify-between">
                <div class="w-3/4 pr-4">
                    <p><strong>Description:</strong> {{ $expense->description }}</p>
                    <p><strong>Amount:</strong> {{ $expense->amount / 100 }}</p>
                    <p><strong>Category:</strong> {{ $expense->category }}</p>
                    <p><strong>Status:</strong> {{ $expense->status->name }}</p>
                </div>

                @if($expense->receipt_path)
                    <div>
                        <img src="{{ asset('storage/' . $expense->receipt_path) }}" alt="Receipt" class="mt-2 w-32 h-32 object-cover">
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-500 mt-4">No expenses submitted yet.</p>
        @endforelse
    </div>
</div>
