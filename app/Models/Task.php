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

    protected $fillable = ['start_date', 'end_date', 'created_by_id', 'project_id'];

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
        return $this->belongsTo("App\Models\Task", "parent_id")->where('parent_id', '=', null)->with('translations');
    }

    public function childs(){
        return $this->hasMany("App\Models\Task","parent_id", "id")->where('parent_id', "<>" ,null)->with('translations');
    }

    public function responsable(){
        return $this->belongsTo("App\Models\User");
    }
    public function creator()
    {
        return $this->belongsTo("App\Models\User", 'created_by_id', 'id');
    }

    public function collaborators()
    {
        return $this->belongsToMany('App\Models\User', 'task_collaborators', 'task_id', 'user_id', 'id', 'id')->withPivot('id', 'permission');
    }

    public function attachments(){
        return $this->morphMany('App\Models\Attachment', 'attachmentable');
    }

    public function findIfCollaboratorHasPermission($collaborator_id, $permission = "all")
    {
        $collaborator = $this->collaborators()->where('users.id', $collaborator_id)->first();

        if (isset($collaborator)) {
            $permissions = $collaborator->pivot->permission;
            if (isset($permissions)) {
                if (in_array($permission, json_decode($permissions)))
                    return true;
            }
        }
        return false;
    }
}
