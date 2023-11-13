<?php

use App\Models\Role;

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	class CreateRolesTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema ::create( 'roles', function ( Blueprint $table ) {
				$table -> increments( 'id' );
				$table -> string( 'name');
                $table -> softDeletes();
				$table -> timestamps();
			} );

			Role ::create([ 
				'name' => ['ar' => 'ادمن' , 'en' => 'admin','kur'=> 'admin'] 
			]);
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema ::dropIfExists( 'roles' );
		}
	}
