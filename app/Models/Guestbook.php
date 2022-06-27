<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guestbook extends Model
{
    use HasFactory;
	
	protected $table = 'guestbooks';
	protected $primaryKey = 'id';
	protected $fillable = ['first_name', 'last_name', 'organization', 'address', 'phone', 'message', 'province_id', 'city_id', 'active_status', 'created_by', 'updated_by'];
	
	
	public function province()
	{
		return $this->belongsTo(Province::Class);
	}
	
	public function city()
	{
		return $this->belongsTo(City::Class);
	}
}
