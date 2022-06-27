<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
	
	protected $table = 'cities';
	protected $primaryKey = 'id';
	protected $fillable = ['code', 'province_id', 'name', 'active_status', 'created_by', 'updated_by'];
	
	public function province()
	{
		return $this->belongsTo(Province::Class);
	}
	
	public function guestbooks()
	{
		return $this->hasMany(Guestbook::Class);
	}
}
