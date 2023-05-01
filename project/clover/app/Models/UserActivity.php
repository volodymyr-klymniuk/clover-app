<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\App;

class UserActivity extends Model
{
    use Prunable;
    use HasFactory;

    public const TABLE_NAME = 'user_activity';

    /**
     * @var bool Indicates if the model's ID is auto-incrementing.
     */
    public $incrementing = true;

    /**
     * @var string The primary key associated with the table.
     */
    protected $primaryKey = 'id';

    /**
     * @var string The data type of the auto-incrementing ID.
     */
     protected $keyType = 'string';

    /**
     * @var string The table associated with the model.
     */
    protected $table = self::TABLE_NAME;

    protected $fillable = [ 'user_id', 'event', 'created_id', ];

    public static function boot(): void
    {
        parent::boot();
        UserActivity::preventLazyLoading( App::isProduction());
    }

     public function scopeNew(Builder $query): void
     {
          // Scope a query to only include popular users.
          $query->where('event', '=', 'new');
     }

     public function apply(Builder $builder, Model $model): void
     {
          // Apply the scope to a given Eloquent query builder.
          $builder->where('created_at', '<',
              (new \DateTime())->sub(\strtotime('- 1000 years'))
          );
     }

     public function prunable(): Builder
     {
          // Get the prunable model query.
          return static::where('created_at', '<=',
              (new \DateTime())->sub(\strtotime('-1 day'))
          );
     }
}
