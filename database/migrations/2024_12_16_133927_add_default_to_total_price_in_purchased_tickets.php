use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
Schema::table('purchased_tickets', function (Blueprint $table) {
$table->decimal('total_price', 8, 2)->default(0)->nullable()->change();
});
}

public function down(): void
{
Schema::table('purchased_tickets', function (Blueprint $table) {
$table->decimal('total_price', 8, 2)->nullable(false)->change();
});
}
};
