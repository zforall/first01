<?

class Application_Models_Manager extends Lib_DateBase
{
	//--------------------------------------------------
	function NewKontr($role, $thelogin, $thename, $thepass, $inn, $email)
	{
		$thepassword = md5($thepass);
		return parent::query("INSERT INTO users (login, name, inn, password, email, role_id) VALUES (\"$thelogin\", \"$thename\", \"$inn\", \"$thepassword\", \"$email\", $role)", null);
	}
	
	//--------------------------------------------------
	function UpdateKontr($id, $thelogin, $thename, $thepass, $inn, $email)
	{
		if($thepass=="") return parent::query("UPDATE users SET login=\"$thelogin\", name=\"$thename\", inn=\"$inn\", email=\"$email\" WHERE id = $id", null);
		else 
		{
			$thepassword = md5($thepass);
			return parent::query("UPDATE users SET login=\"$thelogin\", name=\"$thename\", password=\"$thepassword\", inn=\"$inn\", email=\"$email\" WHERE id = $id", null);
		}
	}

	//--------------------------------------------------
	function UpdateRel($uid, $arr)
	  { 
	  
 		// foreach ($arr['ContentItems'] as $key => $value)
 		foreach ($arr as $key => $value)
		{
			if ($value['checked']!=$value['upd'])
			{
				if ($value['upd']==1){
					$id = $value['id'];
					parent::query("insert into relations (uid1, uid2) values ($uid, $id)",null);
					parent::query("insert into relations (uid1, uid2) values ($id, $uid)",null);
				} else
				{
					$id = $value['id'];
					parent::query("DELETE FROM relations WHERE uid1=$uid and uid2=$id",null);
					parent::query("DELETE FROM relations WHERE uid1=$id and uid2=$uid",null);
				}				
			}
			
		}

		return	true;
	}
	
	
	// --------------------------------------------------
	function GetData($rid)
	{
		if (!isset($rid)) return NULL;
		if ($rid==0) {$sql = "SELECT * FROM users WHERE role_id>2";}
		else {$sql = "SELECT * FROM users WHERE role_id=$rid";}
		 
		$result = mysql_query($sql)  or die(mysql_error());
	
		while ($row = mysql_fetch_assoc($result))
		{		 
			$RoleItems[$row['id']]=array(
				"id"=>$row['id'],
				"login"=>$row['login'],
				"name"=>$row['name'],
				"inn"=>$row['inn'],
				"email"=>$row['email'],
				"comment"=>$row['comment'],
				"role_id"=>$row['role_id'],
			);
		  }
		return $RoleItems; 
	}
	// --------------------------------------------------
	function GetRole($uid)
	{
		if (!isset($uid)) return NULL;
		
		$sql = "SELECT role_id FROM users WHERE id=$uid";
		 
		$result = mysql_query($sql)  or die(mysql_error());
	
		$row = mysql_fetch_assoc($result);
		
		return $row["role_id"];
	}
	
	// --------------------------------------------------
	function GetRel($uid)
	{
		if (!isset($uid)) return NULL;
		 

		$sql = "SELECT users.id FROM relations left join users on relations.uid2=users.id where relations.uid1=$uid";
		$result = mysql_query($sql) or die(mysql_error());
	
		$RelItems[]=array();
		while ($row = mysql_fetch_assoc($result))
		{		 
			$RelItems[]=$row['id'];
		}
		
		$role_id = $this->GetRole($uid);
		 
		if ($role_id==3) $role_sel=4;
		else $role_sel=3;
		 
		 $sql = "SELECT users.id, users.login, users.name, users.inn, users.email, users.role_id FROM users where users.role_id=$role_sel";
		 $result = mysql_query($sql)  or die(mysql_error());
	
		 while ($row = mysql_fetch_assoc($result))
		 {	
			if (in_array($row['id'], $RelItems)) $checked=1;
			else $checked=0;
			
			$RoleItems[$row['id']]=array(
				"id"=>$row['id'],
				"login"=>$row['login'],
				"name"=>$row['name'],
				"inn"=>$row['inn'],
				"email"=>$row['email'],
				"role_id"=>$row['role_id'],
				"checked"=>$checked,
			);
		  }
		 // if (!isset($uid)) return NULL;
		 // $sql = "SELECT users.id FROM relations left join users on relations.uid2=users.id where relations.uid1=$uid";
		 // $result = mysql_query($sql)  or die(mysql_error());
	
		 // while ($row = mysql_fetch_assoc($result))
		 // {		 
			// $RoleItems[]=array(
				// "id"=>$row['id'],
				// "name"=>$row['name'],
				// "id"=>$row['id'],
				// "login"=>$row['login'],
				// "name"=>$row['name'],
				// "inn"=>$row['inn'],
				// "email"=>$row['email'],
				// "role_id"=>$row['role_id'],
			// );
		  // }
		 return $RoleItems; 
	}
	
}

?>