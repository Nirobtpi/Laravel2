<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelConvention extends Model
{
    use HasFactory;
    protected $table = 'my_table';
    protected $primaryKey='my_id';
}
