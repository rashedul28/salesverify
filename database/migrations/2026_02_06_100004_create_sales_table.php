    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    class CreateSalesTable extends Migration
    {
        public function up()
        {
            Schema::create('sales', function ($table) {
                $table->id();
                $table->foreignId('offer_source_id')->constrained('offer_sources')->onDelete('cascade');
                $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
                $table->string('source_id');
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('sales');
        }
    }