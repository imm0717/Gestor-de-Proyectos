<?php

namespace App\Models;

use App\Traits\AutoGenerateUuid;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use App\Models\ProjectTranslation;

class Project extends Model implements TranslatableContract
{
    use HasFactory;
    use AutoGenerateUuid;
    use Translatable;

    public $incrementing = false;
    public $translatedAttributes = ['name', 'description'];

    protected $keyType = 'string';
    protected $fillable = ['name','description', 'start_date', 'end_date', 'created_by_id'];


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

    public function parent(){
        return $this->belongsTo("App\Models\Project", "parent_id")->where('parent_id', '=', null)->with('translations');
    }

    public function childs(){
        return $this->hasMany("App\Models\Project","parent_id", "id")->where('parent_id', "<>" ,null)->with('translations');
    }

    public function owner(){
        return $this->belongsTo("App\Models\User");
    }
}
