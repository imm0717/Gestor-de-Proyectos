<?php

namespace App\Models;

use App\Traits\AutoGenerateUuid;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Project extends Model
{
    use HasFactory;
    use AutoGenerateUuid;
    //use Translatable;

    public $incrementing = false;
    //public $translatedAttributes = ['name', 'description'];

    protected $keyType = 'string';
    protected $fillable = ['name','description', 'start_date', 'end_date', 'created_by_id'];


}
