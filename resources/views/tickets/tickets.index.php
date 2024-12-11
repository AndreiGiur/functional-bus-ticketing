@extends('dashboard')

@section('title', 'Lista de bilete')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">Lista de bilete disponibile</h3>
        </div>
        <div class="card-body">
            <h4>Bilete Disponibile</h4>
            @if (!empty($availableTickets) && count($availableTickets) > 0)
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tip Bilet</th>
                            <th>Preț</th>
                            <th>Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($availableTickets as $index => $ticket)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ticket->type }}</td>
                                <td>{{ number_format($ticket->price, 2) }} RON</td>
                                <td>c
                                    <a href="{{ route('tickets.buy', ['id' => $ticket->id]) }}" class="btn btn-sm btn-success">
                                        Cumpără
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Nu există bilete disponibile în acest moment.</p>
            @endif

            <h4 class="mt-4">Achiziții Anterioare</h4>
            @if (!empty($purchasedTickets) && count($purchasedTickets) > 0)
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tip Bilet</th>
                            <th>Cantitate</th>
                            <th>Dată Achiziție</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchasedTickets as $index => $purchase)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $purchase->ticket->type }}</td>
                                <td>{{ $purchase->quantity }}</td>
                                <td>{{ $purchase->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Nu există achiziții anterioare.</p>
            @endif
        </div>
    </div>
@endsection
