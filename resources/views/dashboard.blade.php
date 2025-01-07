@extends('layouts.app')

@section('title', 'Portofel')

@section('content')
<div class="min-h-screen bg-gray-900">
    <!-- Header Section -->
    <div class="bg-gray-800 text-white py-4 px-8">
        <div class="flex items-center justify-between">
            <div class="text-lg">
                <p class="font-semibold" style="color: white;">{{ auth()->user()->name }}</p>
                <p class="text-sm" style="color: white;">Portofelul tau!</p>
            </div>
            <div class="text-center text-xl font-bold">
                <p style="color: white;">Your Balance</p>
                <p>{{ $balance }} RON</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <!-- Ticket Purchase Section -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-white">Cumpara un bilet</h2>
                <div class="mt-4">
                    <form action="{{ route('tickets.buy') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="ticketType" class="block text-sm font-medium text-white">Selecteaza un bilet</label>
                            <select id="ticketType" name="ticketType" class="w-full p-2 mt-2 border border-gray-300 rounded-md" required>
                                <option value="" disabled selected>Select Ticket Type</option>
                                <option value="1">90-minute Ticket (3 RON)</option>
                                <option value="2">1-Day Subscription (15 RON)</option>
                                <option value="3">Monthly Subscription (80 RON)</option>
                            </select>
                        </div>

                        <!-- Proceed to Payment button (only visible when ticket is selected) -->
                        <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md mt-4" id="paymentButton" style="display: none;">
                            Proceed to Payment
                        </button>
                    </form>
                </div>
            </div>

            <!-- Add Balance Section (Always visible) -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-white">Adauga fonduri</h2>
                <div class="mt-4">
                    <form action="{{ route('balance.add') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-white">Enter amount to add</label>
                            <input
                                type="number"
                                name="amount"
                                id="amount"
                                min="1"
                                class="w-full p-2 mt-2 border border-gray-300 rounded-md"
                                placeholder="Enter amount in RON"
                                required>
                        </div>
                        <button
                            type="submit"
                            class="w-full py-2 px-4 bg-green-600 text-white rounded-md">
                            Add Balance
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Show the "Proceed to Payment" button only if a ticket is selected
    document.getElementById('ticketType').addEventListener('change', function() {
        var paymentButton = document.getElementById('paymentButton');
        if (this.value) {
            paymentButton.style.display = 'block';
        } else {
            paymentButton.style.display = 'none';
        }
    });
</script>
@endsection
