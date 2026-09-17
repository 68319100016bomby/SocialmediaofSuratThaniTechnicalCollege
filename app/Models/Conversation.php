<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Conversation extends Model{protected $fillable=['name','is_group'];protected function casts():array{return['is_group'=>'boolean'];}public function users(){return $this->belongsToMany(User::class)->withPivot('last_read_at');}public function messages(){return $this->hasMany(Message::class);}}
