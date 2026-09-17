<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Group extends Model{protected $fillable=['owner_id','name','description','is_private'];protected function casts():array{return['is_private'=>'boolean'];}public function owner(){return $this->belongsTo(User::class,'owner_id');}public function members(){return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();}public function posts(){return $this->hasMany(Post::class)->latest();}}
