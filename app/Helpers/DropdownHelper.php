<?php
	namespace App\Helpers;

	class DropdownHelper
	{
		public static function numToActiveStatusName(int $num)
		{
			$activeStatus = self::activeStatus();
			
			if(array_key_exists($num, $activeStatus))
				return $activeStatus[$num];
			else	
				return '';
		}
		
		public static function activeStatus(){
			return array(
				'' => '', 
				config('constants.ACTIVE_STATUS_ACTIVE') => 'Active', 
				config('constants.ACTIVE_STATUS_INACTIVE') => 'Inactive', 
			);
		}
	}