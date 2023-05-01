<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // B-trees
        // B-trees can handle equality and range queries on data that can be sorted into some ordering.
        // In particular, the PostgreSQL query planner will consider using a B-tree index whenever an indexed column is involved in a comparison using one of these operators:
        // <   <=   =   >=   >

        // Hash
        // Hash indexes store a 32-bit hash code derived from the value of the indexed column. Hence, such indexes can only handle simple equality comparisons.
        // The query planner will consider using a hash index whenever an indexed column is involved in a comparison using the equal operator:
        // =

        // GiST
        // GiST indexes are not a single kind of index, but rather an infrastructure within which many different indexing strategies can be implemented.
        // Accordingly, the particular operators with which a GiST index can be used vary depending on the indexing strategy (the operator class).
        // As an example, the standard distribution of PostgreSQL includes GiST operator classes for several two-dimensional geometric data types, which support indexed queries using these operators:
        // <<   &<   &>   >>   <<|   &<|   |&>   |>>   @>   <@   ~=   &&
        // GiST indexes are also capable of optimizing “nearest-neighbor” searches, such as
        // SELECT * FROM places ORDER BY location <-> point '(101,456)' LIMIT 10;

        // SP-GiST
        // SP-GiST indexes, like GiST indexes, offer an infrastructure that supports various kinds of searches.
        // SP-GiST permits implementation of a wide range of different non-balanced disk-based data structures, such as quadtrees, k-d trees, and radix trees (tries).
        // As an example, the standard distribution of PostgreSQL includes SP-GiST operator classes for two-dimensional points, which support indexed queries using these operators:
        // <<   >>   ~=   <@   <<|   |>>

        // GIN
        // GIN indexes are “inverted indexes” which are appropriate for data values that contain multiple component values, such as arrays.
        // An inverted index contains a separate entry for each component value, and can efficiently handle queries that test for the presence of specific component values.
        // <@   @>   =   &&

        // BRIN
        // BRIN indexes (a shorthand for Block Range INdexes) store summaries about the values stored in consecutive physical block ranges of a table.
        // Thus, they are most effective for columns whose values are well-correlated with the physical order of the table rows.
        // Like GiST, SP-GiST and GIN, BRIN can support many different indexing strategies, and the particular operators with which a BRIN index can be used vary depending on the indexing strategy.
        // For data types that have a linear sort order, the indexed data corresponds to the minimum and maximum values of the values in the column for each block range. This supports indexed queries using these operators:
        // <   <=   =   >=   >

        Schema::create("user", function (Blueprint $table) {
            $table
                ->id()
                ->autoIncrement()
                ->nullable(false);

            $table
                ->string('first_name', 255)
                ->nullable(false, 255);

            $table
                ->string('last_name', 255)
                ->nullable(false, 255);

            $table
                ->string('email', 255)
                ->index('idx_b29c3308a76de395')
                ->nullable(false, 255);

            $table
                ->string('password', 84)
                ->nullable(false, 255);

            $table->string('phone', 24);

            $table
                ->string('api_token', 64)
                ->default(null);

            $table
                ->string('reset_password_token', 64)
                ->nullable(true)
                ->default(null);

            $table
                ->boolean('active')
                ->nullable(true)
                ->default(true);

            $table->datetimes();
        });

        Schema::create("user_activity", function (Blueprint $table) {
            $table
                ->id()
                ->autoIncrement()
                ->nullable(false);

            $table
                ->foreignId('user_id')
                ->constrained('user')
                ->onDelete('cascade');

            $table
                ->string('event', 255)
                ->default('new');

            $table->datetimes();
        });

        Schema::create("company", function (Blueprint $table) {
            $table
                ->id()
                ->autoIncrement()
                ->nullable(false);

            $table
                ->foreignId('user_id')
                ->constrained('user')
                ->onDelete('cascade');

            $table
                ->string('title', 255)
                ->nullable(false);

            $table
                ->string('phone', 64)
                ->nullable(false);

            $table
                ->string("description")
                ->default(null);

            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::drop("user");
        Schema::drop("user_activity");
        Schema::drop("company");
    }
};
