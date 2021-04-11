<?php

namespace App\Models;

use App\Traits\AutoGenerateUuid;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
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

    public function setStartDateAttribute($value){
        if (isset($value))
            $this->attributes['start_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function setEndDateAttribute($value){
        if (isset($value))
            $this->attributes['end_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getStartDateAttribute($value){
        return (isset($value)) ? Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y') : $value;
    }

    public function getEndDateAttribute($value){
        return (isset($value)) ? Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y') : $value;
    }


}
