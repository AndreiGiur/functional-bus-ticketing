namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        // Exemplu de date pentru bilete (în practică, ar trebui să le preiei dintr-o bază de date)
        $tickets = [
            ['type' => 'Autobuz', 'price' => 2.5],
            ['type' => 'Tramvai', 'price' => 2.0],
            ['type' => 'Metrou', 'price' => 3.0],
        ];

        return view('tickets.index', compact('tickets'));
    }
}
