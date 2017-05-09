<?php 

class School
{
	public function SetSchool($values = array())
	{
		$sql = 'UPDATE school 
		SET 
		school_name = ?, 
		school_type_id = ?, 
		school_address = ?, 
		school_email = ?, 
		school_phone = ?, 
		school_contact_person = ?, 
		school_fax = ?, 
		school_mobile = ?, 
		updated_at = ? 
		WHERE school_id = 1';

		$update = DB::dbActive()->query($sql, $values);
		
		if(!$update)
		{
			return false;
		}
		else
		{
			return true;
		}


	}

	public function SetLogo($logo)
	{
		$sql = 'UPDATE school 
		SET 
		school_logo = ?, 
		updated_at = ? 
		WHERE school_id = 1';

		$update = DB::dbActive()->query($sql, $logo);
		
		if(!$update)
		{
			return false;
		}
		else
		{
			return true;
		}

	}

	public static function GetSchoolName()
	{
		$sql = 'SELECT school_name FROM school WHERE school_id = 1';
		$schoolName = DB::dbActive()->single($sql)->result();
		if($schoolName)
		{
			return ucfirst($schoolName->school_name);
		}
		else
		{
			return '@SchoolName';
		}
	}
}

?>