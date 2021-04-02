<?php

namespace App\Models;

use App\Traits\AutoGenerateUuid;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    use AutoGenerateUuid;

    public $incrementing = false;
    public $translatedAttributes = ['name', 'description'];
    protected $keyType = 'string';
}
