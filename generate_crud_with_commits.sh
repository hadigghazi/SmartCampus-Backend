#!/bin/bash

# Define your table and model names
TABLE_NAME="library_books"
MODEL_NAME="LibraryBook"
FACTORY_NAME="${MODEL_NAME}Factory"
SEEDER_NAME="${MODEL_NAME}Seeder"
CONTROLLER_NAME="${MODEL_NAME}Controller"
REQUEST_STORE="Store${MODEL_NAME}"
REQUEST_UPDATE="Update${MODEL_NAME}"

# Function to commit changes with a message
commit_changes() {
    local message=$1
    git add .
    git commit -m "$message"
}

# Generate Model and Migration
php artisan make:model $MODEL_NAME -m
commit_changes "Adding $MODEL_NAME model and migration"

# Generate Controller, Factory, Seeder, and Requests
php artisan make:controller $CONTROLLER_NAME --resource
php artisan make:factory $FACTORY_NAME --model=$MODEL_NAME
php artisan make:seeder $SEEDER_NAME
php artisan make:request Store$MODEL_NAME
php artisan make:request Update$MODEL_NAME
commit_changes "Generating $CONTROLLER_NAME, $FACTORY_NAME, $SEEDER_NAME, and request classes"

# Write content to Model
cat > app/Models/$MODEL_NAME.php <<EOL
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class $MODEL_NAME extends Model
{
    use HasFactory, SoftDeletes;

    protected \$fillable = [
        'title',
        'author',
        'isbn',
        'copies',
        'publication_year',
        'campus_id',
    ];

    protected \$dates = ['deleted_at'];
}
EOL
commit_changes "Adding content to $MODEL_NAME model"

# Write content to Migration
cat > database/migrations/*_create_${TABLE_NAME}_table.php <<EOL
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create${MODEL_NAME}Table extends Migration
{
    public function up()
    {
        Schema::create('$TABLE_NAME', function (Blueprint \$table) {
            \$table->id();
            \$table->string('title', 100);
            \$table->string('author', 100);
            \$table->string('isbn', 20);
            \$table->integer('copies');
            \$table->integer('publication_year');
            \$table->foreignId('campus_id')->constrained('campuses')->onDelete('cascade');
            \$table->timestamps();
            \$table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('$TABLE_NAME');
    }
}
EOL
commit_changes "Adding migration for $TABLE_NAME"

# Write content to Controller
cat > app/Http/Controllers/$CONTROLLER_NAME.php <<EOL
<?php

namespace App\Http\Controllers;

use App\Models\\$MODEL_NAME;
use App\Http\Requests\Store$MODEL_NAME;
use App\Http\Requests\Update$MODEL_NAME;

class $CONTROLLER_NAME extends Controller
{
    public function index()
    {
        \$items = $MODEL_NAME::withTrashed()->get();
        return response()->json(\$items);
    }

    public function store(Store$MODEL_NAME \$request)
    {
        \$item = $MODEL_NAME::create(\$request->validated());
        return response()->json(\$item, 201);
    }

    public function show(\$id)
    {
        \$item = $MODEL_NAME::withTrashed()->findOrFail(\$id);
        if (\$item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json(\$item);
    }

    public function update(Update$MODEL_NAME \$request, \$id)
    {
        \$item = $MODEL_NAME::withTrashed()->findOrFail(\$id);
        \$item->update(\$request->validated());
        return response()->json(\$item);
    }

    public function destroy(\$id)
    {
        \$item = $MODEL_NAME::withTrashed()->findOrFail(\$id);
        \$item->delete();
        return response()->json(null, 204);
    }

    public function restore(\$id)
    {
        \$item = $MODEL_NAME::withTrashed()->findOrFail(\$id);
        \$item->restore();
        return response()->json(\$item);
    }

    public function forceDelete(\$id)
    {
        \$item = $MODEL_NAME::withTrashed()->findOrFail(\$id);
        \$item->forceDelete();
        return response()->json(null, 204);
    }
}
EOL
commit_changes "Adding CRUD methods to $CONTROLLER_NAME"

# Write content to Factory
cat > database/factories/$FACTORY_NAME.php <<EOL
<?php

namespace Database\Factories;

use App\Models\\$MODEL_NAME;
use App\Models\Campus; // Reference to Campus factory
use Illuminate\Database\Eloquent\Factories\Factory;

class $FACTORY_NAME extends Factory
{
    protected \$model = $MODEL_NAME::class;

    public function definition()
    {
        return [
            'title' => \$this->faker->sentence(),
            'author' => \$this->faker->name(),
            'isbn' => \$this->faker->isbn13(),
            'copies' => \$this->faker->numberBetween(1, 100),
            'publication_year' => \$this->faker->year(),
            'campus_id' => Campus::factory(), // Reference the Campus factory
        ];
    }
}
EOL
commit_changes "Adding factory for $MODEL_NAME"

# Write content to Seeder
cat > database/seeders/$SEEDER_NAME.php <<EOL
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\\$MODEL_NAME;

class $SEEDER_NAME extends Seeder
{
    public function run()
    {
        $MODEL_NAME::factory()->count(10)->create();
    }
}
EOL
commit_changes "Adding seeder for $MODEL_NAME"

# Write content to Store Request
cat > app/Http/Requests/Store$MODEL_NAME.php <<EOL
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Store$MODEL_NAME extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'author' => 'required|string|max:100',
            'isbn' => 'required|string|max:20',
            'copies' => 'required|integer',
            'publication_year' => 'required|integer',
            'campus_id' => 'required|exists:campuses,id',
        ];
    }
}
EOL
commit_changes "Adding store request for $MODEL_NAME"

# Write content to Update Request
cat > app/Http/Requests/Update$MODEL_NAME.php <<EOL
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Update$MODEL_NAME extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:100',
            'author' => 'sometimes|string|max:100',
            'isbn' => 'sometimes|string|max:20',
            'copies' => 'sometimes|integer',
            'publication_year' => 'sometimes|integer',
            'campus_id' => 'sometimes|exists:campuses,id',
        ];
    }
}
EOL
commit_changes "Adding update request for $MODEL_NAME"

# Add API resource routes to routes/api.php
cat >> routes/api.php <<EOL
Route::apiResource('$TABLE_NAME', $CONTROLLER_NAME::class);
Route::post('$TABLE_NAME/{id}/restore', [$CONTROLLER_NAME::class, 'restore']);
Route::delete('$TABLE_NAME/{id}/force-delete', [$CONTROLLER_NAME::class, 'forceDelete']);
EOL
commit_changes "Adding routes for $MODEL_NAME to routes/api.php"

echo "CRUD operations for $MODEL_NAME have been created and committed."
