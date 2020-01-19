<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('image_id');
            $table->integer('category')->unsigned();
            $table->foreign('category')->references('id')->on('categories');
            $table->string('link');
            $table->timestamps();
        });

        DB::table('images')->insert([
            ['category' => 1, 'link' => 'https://images.pexels.com/photos/66898/elephant-cub-tsavo-kenya-66898.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 1, 'link' => 'https://images.pexels.com/photos/39629/tiger-tiger-baby-tigerfamile-young-39629.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 1, 'link' => 'https://images.pexels.com/photos/37833/rainbow-lorikeet-parrots-australia-rainbow-37833.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 1, 'link' => 'https://images.pexels.com/photos/52961/antelope-nature-flowers-meadow-52961.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 1, 'link' => 'https://images.pexels.com/photos/213399/pexels-photo-213399.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 2, 'link' => 'https://images.pexels.com/photos/102127/pexels-photo-102127.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 2, 'link' => 'https://images.pexels.com/photos/1209843/pexels-photo-1209843.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 2, 'link' => 'https://images.pexels.com/photos/566641/pexels-photo-566641.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 2, 'link' => 'https://images.pexels.com/photos/1532704/pexels-photo-1532704.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 2, 'link' => 'https://images.pexels.com/photos/45258/ballet-production-performance-don-quixote-45258.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 3, 'link' => 'https://images.pexels.com/photos/2280571/pexels-photo-2280571.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 3, 'link' => 'https://images.pexels.com/photos/220989/pexels-photo-220989.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 3, 'link' => 'https://images.pexels.com/photos/248152/pexels-photo-248152.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 3, 'link' => 'https://images.pexels.com/photos/2280549/pexels-photo-2280549.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 3, 'link' => 'https://images.pexels.com/photos/143654/pexels-photo-143654.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 4, 'link' => 'https://images.pexels.com/photos/408503/pexels-photo-408503.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 4, 'link' => 'https://images.pexels.com/photos/697662/pexels-photo-697662.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 4, 'link' => 'https://images.pexels.com/photos/335393/pexels-photo-335393.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 4, 'link' => 'https://images.pexels.com/photos/414916/pexels-photo-414916.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 4, 'link' => 'https://images.pexels.com/photos/1098515/pexels-photo-1098515.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 5, 'link' => 'https://images.pexels.com/photos/36006/renaissance-schallaburg-figures-facade.jpg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 5, 'link' => 'https://images.pexels.com/photos/135018/pexels-photo-135018.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 5, 'link' => 'https://images.pexels.com/photos/951531/pexels-photo-951531.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 5, 'link' => 'https://images.pexels.com/photos/208674/pexels-photo-208674.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
            ['category' => 5, 'link' => 'https://images.pexels.com/photos/2402926/pexels-photo-2402926.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
