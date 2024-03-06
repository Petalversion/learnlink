<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateImagesTable extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('image_id', 9)->unique()->default(Str::random(9));
            $table->foreignId('lesson_id')->constrained('lessons');
            $table->string('image_path');
            $table->timestamps();
        });

        // Set default values for existing records
        $images = \App\Models\Image::all();
        foreach ($images as $image) {
            $image->update(['image_id' => $this->generateImageId()]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }

    public static function generateImageId()
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 9);
    }    
}

