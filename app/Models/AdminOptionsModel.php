<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminOptionsModel extends Model
{
    use HasFactory;

    protected $table = 'admin_options';

    protected $fillable = ['name','value'];

    public $timestamps = false;
}
