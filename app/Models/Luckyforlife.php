<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Luckyforlife extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'luckyforlife';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'draw_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'draw_date',
        'draw_time',
        'winning_column',
        'balander'
    ];
}
