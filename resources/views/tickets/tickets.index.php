@extends('dashboard')

@section('title', 'Lista de bilete')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">Lista de bilete disponibile</h3>
        </div>
        <div class="card-body">
            @if (!empty($tickets) && count($tickets) > 0)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tip bilet</th>
                            <th scope="col">Preț (RON)</th>
                            <th scope="col">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $index => $ticket)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ticket['type'] }}</td>
                                <td>{{ number_format($ticket['price'], 2) }} RON</td>
                                <td>
                                    <a href="{{ route('tickets.buy') }}" class="btn btn-sm btn-primary" title="Cumpără acest bilet">
                                        Cumpără
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-muted">Momentan nu există bilete disponibile.</p>
            @endif
        </div>
    </div>
@endsection
