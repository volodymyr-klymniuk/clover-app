<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\App;

class Company extends Model
{
    use Prunable;
    use HasFactory;

    public const TABLE_NAME = 'company';

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

    protected $fillable = [
        'user_id',
        'title',
        'phone',
        'description',
    ];

    /**
     * @var string The table associated with the model.
     */
    protected $table = self::TABLE_NAME;

    public static function boot(): void
    {
        parent::boot();
        Company::preventLazyLoading(App::isProduction());
    }
}
