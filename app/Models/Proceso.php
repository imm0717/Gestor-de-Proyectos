<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoGenerateUuid;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Proceso extends Model implements TranslatableContract
{
    use HasFactory;
    use AutoGenerateUuid;
    use Translatable;

    public $incrementing = false;
    public $translatedAttributes = ['name', 'description'];

    protected $keyType = 'string';
    protected $fillable = ['name', 'description','created_by_id'];

    public function parent()
    {
        return $this->belongsTo("App\Models\Proceso", "parent_id")->where('parent_id', '=', null)->with('translations');
    }

    public function childs()
    {
        return $this->hasMany("App\Models\Proceso", "parent_id", "id")->with('translations')->where('parent_id', "<>", null);
    }

    public function creator()
    {
        return $this->belongsTo("App\Models\User", 'created_by_id', 'id');
    }

    public function attachments()
    {
        return $this->morphMany('App\Models\Attachment', 'attachmentable');
    }
}
