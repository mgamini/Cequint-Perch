<?php

    $User = $Users->find($CurrentUser->id());
    
    if (!is_object($User)) {
        PerchUtil::redirect(PERCH_LOGINPATH);
    }
    


    /* --------- Edit User Form ----------- */

    $Form 	= new PerchForm('user', false);

    $req = array();
    $req['userGivenName']  = "Required";
    $req['userFamilyName'] = "Required";
    $req['userEmail']      = "Required";


    $Form->set_required($req);

    $validation = array();
    $validation['userEmail']	= array("email", PerchLang::get("Email incomplete or already in use."), array('userID'=>$User->id()));
    $validation['userPassword']	= array("password", PerchLang::get("Your passwords must match"));

    $Form->set_validation($validation);

    if ($Form->posted() && $Form->validate()) {

		$data		= array();
		$postvars 	= array('userGivenName', 'userFamilyName','userEmail','userPassword');
		$data = $Form->receive($postvars);
		
		if (isset($data['userPassword'])) {
		    if ($data['userPassword'] != '') {
		        $data['userPassword'] = md5($data['userPassword']);
		    }else{
		        unset($data['userPassword']);
		    }
		}

		$User->update($data);
		$Alert->set('success', PerchLang::get('Your details have been successfully updated.'));

    }
    


    $details = $User->to_array();


?>