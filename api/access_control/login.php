<?php
	//Start session


	require('../conn.php');
	session_start();
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;

	//Sanitize the POST values

	$login = ($_POST['username']);
	$password = ($_POST['password']);
	
	if(empty($login) || empty($password)){
        $message = 'All field are required';echo $message;
	}
	 
   else{
		
        $qry = $db->prepare("SELECT * From users WHERE username =? AND password=?");
        $result=($qry);

		 $qry-> execute(array($login,$password));
		 $row = $qry->fetch(PDO::FETCH_ASSOC);

		// $member = ($result);	
			if($qry ->rowCount() >0){
				//$state=$qry->prepare("SELECT * FROM user WHERE username=? AND password=?");
					$qry->execute(array($login,$password));
					$position=$qry->fetchAll();
				foreach ($position as $account){
					$account_type=$account["position"];
				}
				
				session_regenerate_id();
					$_SESSION['username'] = $login;
					$_SESSION['pass'] = $password;
					$_SESSION['SESS_MEMBER_ID'] =  $row['id'];
					$_SESSION['SESS_BRANCH'] =  $row['branch'];
					//$_SESSION['SESS_BRANCH_ID'] =  $row['branch_id'];
					$_SESSION['SESS_FULL_NAME'] = $row['name']; 
					$_SESSION['SESS_POSITION'] =   $account_type;
			
						if($account_type=='director'){
							 echo 1;
							exit(); 
						}
                       
						elseif($account_type=='ops_manager'){
							echo 2;
							exit();
						}
                        elseif($account_type=='admin'){
							echo 3;
							exit();
						}
                        elseif($account_type=='counselor'){
							echo 4;
							exit();
						}
                        elseif($account_type=='tutor'){
							echo 5;
							exit();
						}
						else{
							echo 6;
							exit();
						}
			}
			else{
					$message ="password is wrong";
					$_SESSION['message'] = $message;
					echo 0;
			}

     }
?>