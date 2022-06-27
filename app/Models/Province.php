<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
	
	protected $table = 'provinces';
	protected $primaryKey = 'id';
	protected $fillable = ['code', 'name', 'active_status', 'created_by', 'updated_by'];

	public function cities()
	{
		return $this->hasMany(City::Class);
	}
	
	public function guestbooks()
	{
		return $this->hasMany(Guestbook::Class);
	}

}
