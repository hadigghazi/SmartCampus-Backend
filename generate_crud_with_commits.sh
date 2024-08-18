#!/bin/bash

# Define your table and model names
TABLE_NAME="registrations"
MODEL_NAME="Registration"
FACTORY_NAME="${MODEL_NAME}Factory"
SEEDER_NAME="${MODEL_NAME}Seeder"
CONTROLLER_NAME="${MODEL_NAME}Controller"
REQUEST_STORE="${MODEL_NAME}StoreRequest"
REQUEST_UPDATE="${MODEL_NAME}UpdateRequest"

# Initialize Git repository if not already done
if [ ! -d ".git" ]; then
    git init
fi

# Function to commit changes with a message
commit_changes() {
    local message=$1
    git add .
    git commit -m "$message"
}

# Generate Model and Migration
php artisan make:model $MODEL_NAME -m
commit_changes "Added $MODEL_NAME model and migration"

# Generate Controller, Factory, Seeder, and Requests
php artisan make:controller $CONTROLLER_NAME --resource
php artisan make:factory $FACTORY_NAME --model=$MODEL_NAME
php artisan make:seeder $SEEDER_NAME
php artisan make:request Store$MODEL_NAME
php artisan make:request Update$MODEL_NAME
commit_changes "Generated $CONTROLLER_NAME, $FACTORY_NAME, $SEEDER_NAME, and request classes"

# Define the table columns
declare -A COLUMNS
COLUMNS=(
    ["student_id"]="integer"
    ["course_id"]="integer"
    ["instructor_id"]="integer"
    ["semester_id"]="integer"
    ["status"]="enum"
)

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
        'student_id',
        'course_id',
        'instructor_id',
        'semester_id',
        'status',
    ];

    protected \$dates = ['deleted_at'];

    // Add relationships if needed
}
EOL
commit_changes "Added content to $MODEL_NAME model"

# Write content to Migration
cat > database/migrations/*_create_${TABLE_NAME}_table.php <<EOL
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create${TABLE_NAME}Table extends Migration
{
    public function up()
    {
        Schema::create('$TABLE_NAME', function (Blueprint \$table) {
            \$table->id();
            \$table->unsignedBigInteger('student_id');
            \$table->unsignedBigInteger('course_id');
            \$table->unsignedBigInteger('instructor_id');
            \$table->unsignedBigInteger('semester_id');
            \$table->enum('status', ['Registered', 'Completed', 'Failed'])->default('Registered');
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
commit_changes "Added migration for $TABLE_NAME"

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

    public function show($MODEL_NAME \$item)
    {
        return response()->json(\$item);
    }

    public function update(Update$MODEL_NAME \$request, $MODEL_NAME \$item)
    {
        \$item->update(\$request->validated());
        return response()->json(\$item);
    }

    public function destroy($MODEL_NAME \$item)
    {
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
commit_changes "Added CRUD methods to $CONTROLLER_NAME"

# Write content to Factory
cat > database/factories/$FACTORY_NAME.php <<EOL
<?php

namespace Database\Factories;

use App\Models\\$MODEL_NAME;
use Illuminate\Database\Eloquent\Factories\Factory;

class $FACTORY_NAME extends Factory
{
    protected \$model = $MODEL_NAME::class;

    public function definition()
    {
        return [
            'student_id' => \App\Models\Student::inRandomOrder()->first()->id,
            'course_id' => \App\Models\Course::inRandomOrder()->first()->id,
            'instructor_id' => \App\Models\Instructor::inRandomOrder()->first()->id,
            'semester_id' => \App\Models\Semester::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['Registered', 'Completed', 'Failed']),
        ];
    }
}
EOL
commit_changes "Added factory for $MODEL_NAME"

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
        $items = [
            // Add sample data here
        ];

        foreach (\$items as \$item) {
            $MODEL_NAME::create(\$item);
        }
    }
}
EOL
commit_changes "Added seeder for $MODEL_NAME"

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
            'student_id' => 'required|integer',
            'course_id' => 'required|integer',
            'instructor_id' => 'required|integer',
            'semester_id' => 'required|integer',
            'status' => 'required|in:Registered,Completed,Failed',
        ];
    }
}
EOL
commit_changes "Added store request for $MODEL_NAME"

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
            'student_id' => 'sometimes|integer',
            'course_id' => 'sometimes|integer',
            'instructor_id' => 'sometimes|integer',
            'semester_id' => 'sometimes|integer',
            'status' => 'sometimes|in:Registered,Completed,Failed',
        ];
    }
}
EOL
commit_changes "Added update request for $MODEL_NAME"

# Add API resource routes to routes/api.php
cat >> routes/api.php <<EOL
Route::apiResource('$TABLE_NAME', $CONTROLLER_NAME::class);
Route::post('$TABLE_NAME/{id}/restore', [$CONTROLLER_NAME::class, 'restore']);
Route::delete('$TABLE_NAME/{id}/force-delete', [$CONTROLLER_NAME::class, 'forceDelete']);
EOL
commit_changes "Added routes for $MODEL_NAME to routes/api.php"

echo "CRUD operations for $MODEL_NAME have been created and committed."
