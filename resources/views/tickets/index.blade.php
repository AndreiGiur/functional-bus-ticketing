<!-- resources/views/tickets/index.blade.php -->

@extends('dashboard')

@section('title', 'Lista de bilete')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de bilete disponibile</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tip bilet</th>
                        <th>Preț (RON)</th>
                        <th>Acțiuni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $index => $ticket)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $ticket['type'] }}</td>
                            <td>{{ $ticket['price'] }} RON</td>
                            <td>
                                <a href="{{ route('tickets.buy') }}" class="btn btn-sm btn-primary">
                                    Cumpără
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
