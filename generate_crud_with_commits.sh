#!/bin/bash

# Function to commit changes with a message
commit_changes() {
    local message=$1
    git add .
    git commit -m "$message"
}

# Function to parse the table definition and extract relevant data
parse_table_definition() {
    local table_definition=$1

    # Extract table name
    TABLE_NAME=$(echo "$table_definition" | grep -oP '^Table \K\w+')
    MODEL_NAME=$(echo "$TABLE_NAME" | sed -r 's/(^|_)([a-z])/\U\2/g')

    # Extract column definitions
    COLUMNS=$(echo "$table_definition" | grep -oP '^\s+\K\w+ \w+.*(?=\s|\[)')

    # Extract foreign key relationships
    RELATIONS=$(echo "$table_definition" | grep -oP '\[ref: > \K\w+\.\w+')
}

# Function to generate model content
generate_model() {
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
$(echo "$COLUMNS" | grep -oP '^\w+' | sed "s/^/        '/" | sed "s/$/',/" | sed '$s/,$//')
    ];

    protected \$dates = ['deleted_at'];

    // Relationships
$(for relation in $RELATIONS; do
    RELATED_MODEL=$(echo "$relation" | cut -d. -f1 | sed -r 's/(^|_)([a-z])/\U\2/g')
    RELATED_COLUMN=$(echo "$relation" | cut -d. -f2)
    echo "    public function ${RELATED_MODEL,,}()"
    echo "    {"
    echo "        return \$this->belongsTo($RELATED_MODEL::class, '$RELATED_COLUMN');"
    echo "    }"
    echo ""
done)
}
EOL
    commit_changes "Added content to $MODEL_NAME model"
}

# Function to generate migration content
generate_migration() {
    TIMESTAMP=$(date +"%Y_%m_%d_%H%M%S")
    cat > database/migrations/${TIMESTAMP}_create_${TABLE_NAME}_table.php <<EOL
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
$(echo "$COLUMNS" | while read -r column; do
    COLUMN_NAME=$(echo "$column" | awk '{print $1}')
    COLUMN_TYPE=$(echo "$column" | awk '{print $2}')
    if [[ $column == *"[ref:"* ]]; then
        echo "            \$table->unsignedBigInteger('$COLUMN_NAME');"
    else
        echo "            \$table->$COLUMN_TYPE('$COLUMN_NAME');"
    fi
done)
            \$table->timestamps();
            \$table->softDeletes();
$(for relation in $RELATIONS; do
    RELATED_COLUMN=$(echo "$relation" | cut -d. -f2)
    echo "            \$table->foreign('$RELATED_COLUMN')->references('id')->on('$(echo $relation | cut -d. -f1)');"
done)
        });
    }

    public function down()
    {
        Schema::dropIfExists('$TABLE_NAME');
    }
}
EOL
    commit_changes "Added migration for $TABLE_NAME"
}

# Function to generate controller content
generate_controller() {
    cat > app/Http/Controllers/$MODEL_NAME"Controller".php <<EOL
<?php

namespace App\Http\Controllers;

use App\Models\\$MODEL_NAME;
use App\Http\Requests\Store$MODEL_NAME;
use App\Http\Requests\Update$MODEL_NAME;

class ${MODEL_NAME}Controller extends Controller
{
    public function index()
    {
        \$items = $MODEL_NAME::withTrashed()->get();
        return response()->json(\$items);
    }

    public function store(Store${MODEL_NAME} \$request)
    {
        \$item = $MODEL_NAME::create(\$request->validated());
        return response()->json(\$item, 201);
    }

    public function show(${MODEL_NAME} \$item)
    {
        return response()->json(\$item);
    }

    public function update(Update${MODEL_NAME} \$request, ${MODEL_NAME} \$item)
    {
        \$item->update(\$request->validated());
        return response()->json(\$item);
    }

    public function destroy(${MODEL_NAME} \$item)
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
    commit_changes "Added CRUD methods to ${MODEL_NAME}Controller"
}

# Function to generate factory content
generate_factory() {
    cat > database/factories/$MODEL_NAME"Factory".php <<EOL
<?php

namespace Database\Factories;

use App\Models\\$MODEL_NAME;
use Illuminate\Database\Eloquent\Factories\Factory;

class ${MODEL_NAME}Factory extends Factory
{
    protected \$model = $MODEL_NAME::class;

    public function definition()
    {
        return [
$(echo "$COLUMNS" | while read -r column; do
    COLUMN_NAME=$(echo "$column" | awk '{print $1}')
    COLUMN_TYPE=$(echo "$column" | awk '{print $2}')
    if [[ $COLUMN_TYPE == "integer" || $COLUMN_TYPE == "unsignedBigInteger" ]]; then
        echo "            '$COLUMN_NAME' => \App\Models\$(echo "$RELATIONS" | grep "$COLUMN_NAME" | cut -d. -f1)::inRandomOrder()->first()->id,"
    elif [[ $COLUMN_TYPE == "decimal" ]]; then
        echo "            '$COLUMN_NAME' => \$this->faker->randomFloat(2, 0, 100),"
    elif [[ $COLUMN_TYPE == "char" ]]; then
        echo "            '$COLUMN_NAME' => \$this->faker->randomElement(['A', 'B', 'C', 'D', 'F']),"
    else
        echo "            '$COLUMN_NAME' => \$this->faker->$COLUMN_TYPE,"
    fi
done)
        ];
    }
}
EOL
    commit_changes "Added factory for $MODEL_NAME"
}

# Function to generate seeder content
generate_seeder() {
    cat > database/seeders/$MODEL_NAME"Seeder".php <<EOL
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\\$MODEL_NAME;

class ${MODEL_NAME}Seeder extends Seeder
{
    public function run()
    {
        ${MODEL_NAME}::factory()->count(10)->create();
    }
}
EOL
    commit_changes "Added seeder for $MODEL_NAME"
}

# Function to generate request content
generate_request() {
    local request_type=$1
    cat > app/Http/Requests/${request_type}${MODEL_NAME}.php <<EOL
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ${request_type}${MODEL_NAME} extends FormRequest
{
    public function rules()
    {
        return [
$(echo "$COLUMNS" | while read -r column; do
    COLUMN_NAME=$(echo "$column" | awk '{print $1}')
    COLUMN_TYPE=$(echo "$column" | awk '{print $2}')
    RULE=""
    if [[ $COLUMN_TYPE == "integer" || $COLUMN_TYPE == "unsignedBigInteger" ]]; then
        RULE="required|integer"
    elif [[ $COLUMN_TYPE == "decimal" ]]; then
        RULE="required|numeric"
    elif [[ $COLUMN_TYPE == "char" ]]; then
        RULE="required|string|max:2"
    elif [[ $COLUMN_TYPE == "enum" ]]; then
        RULE="required|in:$(echo $column | grep -oP '\(\K[^\)]+')"
    else
        RULE="required|string"
    fi
    echo "            '$COLUMN_NAME' => '$RULE',"
done)
        ];
    }
}
EOL
    commit_changes "Added $request_type request for $MODEL_NAME"
}

# Function to add routes to api.php
add_routes() {
    cat >> routes/api.php <<EOL
Route::apiResource('$TABLE_NAME', ${MODEL_NAME}Controller::class);
Route::post('$TABLE_NAME/{id}/restore', [${MODEL_NAME}Controller::class, 'restore']);
Route::delete('$TABLE_NAME/{id}/force-delete', [${MODEL_NAME}Controller::class, 'forceDelete']);
EOL
    commit_changes "Added API routes for $TABLE_NAME"
}

# Main function
main() {
    # Accept table definition as input
    TABLE_DEFINITION=$1

    # Parse the table definition
    parse_table_definition "$TABLE_DEFINITION"

    # Create necessary directories
    mkdir -p app/Models app/Http/Controllers app/Http/Requests database/migrations database/factories database/seeders

    # Initialize Git
    initialize_git

    # Generate files
    generate_model
    generate_migration
    generate_controller
    generate_factory
    generate_seeder
    generate_request "Store"
    generate_request "Update"
    add_routes

    # Run migration
    php artisan migrate
}

# Run the main function with the table definition passed as an argument
main "$1"
