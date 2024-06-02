<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Concerns\BuildsQueries;

class BaseModel extends Model
{
    use BuildsQueries, HasFactory;
}
