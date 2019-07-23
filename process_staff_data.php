<?php
  include "connection.php";
  session_start();
  if(!isset($_SESSION['user']['id'])) header("Location: login.php");
  $final_update = 0;
  $msg = '';
  $query = "SELECT * FROM users WHERE id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
  }
  function findPM($conn){
      //$admin_id = $_SESSION['user']['admin_id'];
      $query = "SELECT * FROM users WHERE id = '".$pm_email."'";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result)> 0){
          while($row = mysqli_fetch_assoc($result)) {
            $admin_id = $row['id'];
          }
      }
      return $admin_id;
  }
  function createManagers($conn,$leaveflow,$all_leave_approvals_phone,$all_leave_approvals_name,$admin_id,$company_name){
      if($leaveflow == '') return true;
      $approvals = [];
      $approvals = explode(";",$leaveflow);
      $approvals_phone = explode(";",$all_leave_approvals_phone);
      $approvals_name = explode(";",$all_leave_approvals_name);
      
      for($e = 0;$e < count($approvals); $e++){
          if($approvals[$e] != ''){
              $each_approvals = explode(":", $approvals[$e]);
              $each_approvals_name = explode(":", $approvals_name[$e]);
              $each_approvals_phone = explode(":", $approvals_phone[$e]);
              $title = $each_approvals[0];
              $email = trim($each_approvals[1]);
              $flow = trim($each_approvals[0]);
              $name = isset($each_approvals_name[1]) ? $each_approvals_name[1] : '';
              $phone = isset($each_approvals_phone[1]) ? $each_approvals_phone[1] : '';
              $query = "SELECT * FROM users WHERE email = '".$email."'";
              //$password = 'SelfServ17';
              $password = password_hash('selfserv17', PASSWORD_DEFAULT);
              $result = mysqli_query($conn, $query);
              if(mysqli_num_rows($result)> 0){
                 $sql = "Update users set name = '".$name."', phone_number = '".$phone."' WHERE employee_ID = '".$email."'";
                 if(mysqli_query($conn,$sql)){
                     
                 }
              }
              else {
                  $sql = "INSERT INTO users (name, email, password,cpassword, role, company_name, category,first_time_loggin,department,employee_ID,profile_image,admin_id,lManager,bManager, position,phone_number,user_company)
                  VALUES ('".$name."', '".$email."', '".$password."','SelfServ17','".$flow."','".$company_name."','staff','0','','".$email."','user_profile.png','".$admin_id."','','', '".$title."','".$phone."','".$company_name."')";
                  if (mysqli_query($conn,$sql ) === TRUE) {
                      //$_SESSION['msg'] = "Account created successfully, kindly login";
                      //header("Location: login.php");
                  } else {
                      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                      //$_SESSION['msg'] = "Error creating account";
                      //header("Location: register.php");
                  }
              }
          }
      }
      return true;
  }
  if(isset($_POST['submit'])){
      
      $pm_name = mysqli_real_escape_string($conn, $_POST['pm_name']);
      $pm_number = mysqli_real_escape_string($conn, $_POST['pm_number']);
      $pm_email = mysqli_real_escape_string($conn, $_POST['pm_email']);
      
      $admin_id = $_SESSION['user']['admin_id'];
      //echo $admin_id;
      //return $admin_id;

      $pension = mysqli_real_escape_string($conn, $_POST['pension']);
      $pension_number = mysqli_real_escape_string($conn, $_POST['pension_number']);


      $religion = mysqli_real_escape_string($conn, $_POST['religion']);
      $children = mysqli_real_escape_string($conn, $_POST['children']);
      $sname = mysqli_real_escape_string($conn, $_POST['sname']);
      $degree = mysqli_real_escape_string($conn, $_POST['degree']);
      $town = mysqli_real_escape_string($conn, $_POST['town']);
      $lga = mysqli_real_escape_string($conn, $_POST['lga']);
      $sorigin = mysqli_real_escape_string($conn, $_POST['sorigin']);
      $sresidence = mysqli_real_escape_string($conn, $_POST['sresidence']);
      $kname = mysqli_real_escape_string($conn, $_POST['kname']);
      $kphnumber = mysqli_real_escape_string($conn, $_POST['kphnumber']);
      $kaddress = mysqli_real_escape_string($conn, $_POST['kaddress']);
      $kdob = mysqli_real_escape_string($conn, $_POST['kdob']);


      $kgender = mysqli_real_escape_string($conn, $_POST['kgender']);
      $relationship_kin = mysqli_real_escape_string($conn, $_POST['relationship_kin']);
      $email_kin = mysqli_real_escape_string($conn, $_POST['email_kin']);
      $kin_is_beneficiary = mysqli_real_escape_string($conn, $_POST['kin_is_beneficiary']);
      $kin_is_dependent = mysqli_real_escape_string($conn, $_POST['kin_is_dependent']);
      $nysc_cert = mysqli_real_escape_string($conn, $_POST['nysc_cert']);

      $on_hmo = mysqli_real_escape_string($conn, $_POST['on_hmo']);
      $hmo = mysqli_real_escape_string($conn, $_POST['hmo']);
      $hmo_number = mysqli_real_escape_string($conn, $_POST['hmo_number']);
      $hmo_plan = mysqli_real_escape_string($conn, $_POST['hmo_plan']);
      $hmo_hospital = mysqli_real_escape_string($conn, $_POST['hmo_hospital']);
      $hmo_remarks = mysqli_real_escape_string($conn, $_POST['hmo_remarks']);
      $hmo_status = mysqli_real_escape_string($conn, $_POST['hmo_status']);


      
      $sgrade = mysqli_real_escape_string($conn, $_POST['sgrade']);
      $scourse_of_study = mysqli_real_escape_string($conn, $_POST['scourse_of_study']);
      $sinstitution = mysqli_real_escape_string($conn, $_POST['sinstitution']);
      $sdegree = mysqli_real_escape_string($conn, $_POST['sdegree']);
      $tgrade = mysqli_real_escape_string($conn, $_POST['tgrade']);
      $tcourse_of_study = mysqli_real_escape_string($conn, $_POST['tcourse_of_study']);
      $tinstitution = mysqli_real_escape_string($conn, $_POST['tinstitution']);
      $tdegree = mysqli_real_escape_string($conn, $_POST['tdegree']);
      $award_year_one = mysqli_real_escape_string($conn, $_POST['award_year_one']);
      $award_body_one = mysqli_real_escape_string($conn, $_POST['award_body_one']);
      $professional_qualification_one = mysqli_real_escape_string($conn, $_POST['professional_qualification_one']);
      
      $award_year_two = mysqli_real_escape_string($conn, $_POST['award_year_two']);
      $award_body_two = mysqli_real_escape_string($conn, $_POST['award_body_two']);
      $professional_qualification_two = mysqli_real_escape_string($conn, $_POST['professional_qualification_two']);
      
      $award_year_three = mysqli_real_escape_string($conn, $_POST['award_year_three']);
      $award_body_three = mysqli_real_escape_string($conn, $_POST['award_body_three']);
      $professional_qualification_three = mysqli_real_escape_string($conn, $_POST['professional_qualification_three']);
      
      
      
      
      
      
      
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
      $employee_ID = mysqli_real_escape_string($conn, $_POST['employee_ID']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $role = mysqli_real_escape_string($conn, $_POST['role']);
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
      $employee_ID = mysqli_real_escape_string($conn, $_POST['employee_ID']);
      $leaveflow = mysqli_real_escape_string($conn, $_POST['all_leave_approvals']);
      $appraisalflow = mysqli_real_escape_string($conn, $_POST['all_appraisal_approvals']);
      $requisitionflow = mysqli_real_escape_string($conn, $_POST['all_requisition_approvals']);
      $cashflow = mysqli_real_escape_string($conn, $_POST['all_cash_approvals']);
      $role = mysqli_real_escape_string($conn, $_POST['role']);
      //$position = mysqli_real_escape_string($conn, $_POST['position']);
      $position = '';
      $department = mysqli_real_escape_string($conn, $_POST['department']);
      $user_company = mysqli_real_escape_string($conn, $_POST['user_company']);
      $branch = mysqli_real_escape_string($conn, $_POST['branch']);
      $user_company = mysqli_real_escape_string($conn, $_POST['user_company']);

      $gender = mysqli_real_escape_string($conn, $_POST['gender']);
      $marital_status = mysqli_real_escape_string($conn, $_POST['marital_status']);
      $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
      $institution = mysqli_real_escape_string($conn, $_POST['institution']);      
      $course_of_study = mysqli_real_escape_string($conn, $_POST['course_of_study']);
      $date_of_employment = mysqli_real_escape_string($conn, $_POST['date_of_employment']);
      $confirmed = mysqli_real_escape_string($conn, $_POST['confirmed']);

      $dob = mysqli_real_escape_string($conn, $_POST['dob']);
      $grade = mysqli_real_escape_string($conn, $_POST['grade']);

      $all_leave_approvals_phone = mysqli_real_escape_string($conn, $_POST['all_leave_approvals_phone']);
      $all_leave_approvals_name = mysqli_real_escape_string($conn, $_POST['all_leave_approvals_name']);      
      //createManagers($conn,$leaveflow,$all_leave_approvals_phone,$all_leave_approvals_name);
      $address = mysqli_real_escape_string($conn, $_POST['address']);
      $fname = mysqli_real_escape_string($conn, $_POST['fname']);
      $mname = mysqli_real_escape_string($conn, $_POST['mname']);
      $role = $role != '' ? $role : $data[0]['role'];
      $branch = $branch != '' ? $branch : $data[0]['branch'];
      $position = $position != '' ? $position : $data[0]['position'];
      $user_company = $user_company != '' ? $user_company : $data[0]['user_company'];
        $department = $department != '' ? $department : $data[0]['department'];
        $leaveflow = $leaveflow != '' ? $leaveflow : $data[0]['leave_flow'];
        $appraisalflow = $appraisalflow != '' ? $appraisalflow : $data[0]['appraisal_flow'];
        $requisitionflow = $requisitionflow != '' ? $requisitionflow : $data[0]['requisition_flow'];
        $cashflow = $cashflow != '' ? $cashflow : $data[0]['cash_flow'];
        $admin_id = $_SESSION['user']['admin_id'];
      $msg = finalupdateUser($conn,$name, $phone_number, $employee_ID, $admin_id,$role,$position,$department,$leaveflow,$appraisalflow, $requisitionflow, $branch, $cashflow,$user_company, $address,$fname,$mname,$gender,$marital_status,$nationality,$institution,$course_of_study,$date_of_employment,$all_leave_approvals_name,$all_leave_approvals_phone,$confirmed,$dob,$grade,$email,$religion,$sname,$town,$lga,$sorigin,$sresidence,$kname,$kphnumber,$kaddress,$kdob,$kgender,$relationship_kin,$email_kin,$kin_is_beneficiary,$kin_is_dependent,$nysc_cert,$sgrade, $scourse_of_study,$sinstitution,$sdegree,$tdegree,$tgrade,$tcourse_of_study,$tinstitution,$award_year_one,$award_body_one,$professional_qualification_one,$award_year_two,$award_body_two,$professional_qualification_two,$award_year_three,$award_body_three,$professional_qualification_three,$children,$degree,$on_hmo,$hmo,$hmo_number,$hmo_hospital,$hmo_plan,$hmo_remarks,$hmo_status,$pension,$pension_number);
      $admin_id = $_SESSION['user']['admin_id'];
        //$admin_id = findPM($conn,);
        $msg = createManagers($conn,$leaveflow,$all_leave_approvals_phone,$all_leave_approvals_name,$admin_id,$_SESSION['user']['company_name']);
       if(isset($_FILES['image'])) processImage($conn,$_FILES['image'],$admin_id,$msg);
       else {
           echo $msg;
       }
  }
  function getAdmin($conn,$admin_email){
        if($admin_email  == ''){$admin_id = '';}
        else {
          $query = "SELECT * from users WHERE email = '$admin_email'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0){
          $row = mysqli_fetch_assoc($result);
          $admin_id = $row['id'];
            } 
        return $admin_id;
        }
  }      
  function updateUser($conn, $name, $phone_number,$employee_ID,$admin_id,$role,$department,$leaveflow,$appraisalflow,$requisitionflow,$branch){
        $sql = "UPDATE users SET name = '".$name."',phone_number = '".$phone_number."', employee_ID = '".$employee_ID."',admin_id = '".$admin_id."', role = '".$role."', branch = '".$branch."',department ='".$department."', leave_flow = '".$leaveflow."', appraisal_flow = '".$appraisalflow."', requisition_flow = '".$requisitionflow."'   WHERE email = '".$_SESSION['user']['email']."'";
        if (mysqli_query($conn, $sql)) {
          if($admin_id != ''){
            if($_SESSION['user']['department'] == '' || $_SESSION['branch'] == ''){
              $_SESSION['msg'] = 'Updated noted, kindly input other details';
            }
          }else {
            $_SESSION['msg'] = 'Updated noted, please input the admin email to continue with the update.';
          }
            //$_SESSION['msg'] = "Record updated successfully";
            $_SESSION['user']['phone_number'] = $phone_number;
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['role'] = $role;
            $_SESSION['user']['employee_ID'] = $employee_ID;
            $_SESSION['user']['admin_id'] = $admin_id;

        } else {
            echo "Error updating record: " . mysqli_error($conn);
            //header("Location: settings.php");
        }
  }
  function finalupdateUser($conn, $name, $phone_number,$employee_ID,$admin_id,$role,$position,$department,$leaveflow,$appraisalflow,$requisitionflow,$branch,$cashflow,$user_company,$address,$fname,$mname,$gender,$marital_status,$nationality,$institution,$course_of_study,$date_of_employment,$all_leave_approvals_name,$all_leave_approvals_phone,$confirmed,$dob,$grade,$email,$religion,$sname,$town,$lga,$sorigin,$sresidence,$kname,$kphnumber,$kaddress,$kdob,$kgender,$relationship_kin,$email_kin,$kin_is_beneficiary,$kin_is_dependent,$nysc_cert,$sgrade, $scourse_of_study,$sinstitution,$sdegree,$tdegree,$tgrade,$tcourse_of_study,$tinstitution,$award_year_one,$award_body_one,$professional_qualification_one,$award_year_two,$award_body_two,$professional_qualification_two,$award_year_three,$award_body_three,$professional_qualification_three,$children,$degree,$on_hmo,$hmo,$hmo_number,$hmo_hospital,$hmo_plan,$hmo_remarks,$hmo_status, $pension,$pension_number){
        $sql = "UPDATE users SET name = '".$name."',phone_number = '".$phone_number."', employee_ID = '".$employee_ID."',admin_id = '".$admin_id."',position = '".$position."', role = '".$role."', branch = '".$branch."',department ='".$department."',leave_flow = '".$leaveflow."', first_time_loggin = '0', requisition_flow = '".$requisitionflow."', cash_flow = '".$cashflow."', appraisal_flow = '".$appraisalflow."', user_company = '".$user_company."', address = '".$address."', fname = '".$fname."', mname = '".$mname."',gender = '".$gender."', marital_status = '".$marital_status."', nationality = '".$nationality."', institution = '".$institution."', course = '".$course_of_study."', cdate_of_employeement = '".$date_of_employment."', flow_name = '".$all_leave_approvals_name."', flow_phone = '".$all_leave_approvals_phone."', confirmed = '".$confirmed."', dob = '".$dob."', grade = '".$grade."', email = '".$email."', religion='".$religion."', sname = '".$sname."', town = '".$town."', lga = '".$lga."', sorigin = '".$sorigin."', sresidence = '".$sresidence."', kname = '".$kname."', kphnumber = '".$kphnumber."', kaddress = '".$kaddress."', kdob = '".$kdob."', kgender = '".$kgender."', relationship_kin = '".$relationship_kin."', email_kin = '".$email_kin."', kin_is_beneficiary = '".$kin_is_beneficiary."', kin_is_dependent = '".$kin_is_dependent."', nysc_cert = '".$nysc_cert."', sgrade = '".$sgrade."', scourse_of_study = '".$scourse_of_study."',sinstitution = '".$sinstitution."', sdegree = '".$sdegree."', tdegree = '".$tdegree."', tgrade = '".$tgrade."', tcourse_of_study = '".$tcourse_of_study."',tinstitution = '".$tinstitution."', award_year_one = '".$award_year_one."', award_body_one = '".$award_body_one."', professional_qualification_one = '".$professional_qualification_one."', award_year_two = '".$award_year_two."', award_body_two = '".$award_body_two."', professional_qualification_two = '".$professional_qualification_two."',award_year_three = '".$award_year_three."', award_body_three = '".$award_body_three."', professional_qualification_three = '".$professional_qualification_three."', degree = '".$degree."', children = '".$children."', on_hmo = '".$on_hmo."', hmo = '".$hmo."', hmo_plan = '".$hmo_plan."', hmo_number = '".$hmo_number."', hmo_status = '".$hmo_status."', hmo_hospital = '".$hmo_hospital."',hmo_remarks = '".$hmo_remarks."', pension = '".$pension."', pension_pin = '".$pension_number."'    WHERE employee_ID = '".$_SESSION['user']['employee_ID']."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['user']['phone_number'] = $phone_number;
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['role'] = $role;
            $_SESSION['user']['position'] = $position;
            //$_SESSION['user']['employee_ID'] = $employee_ID;
            $_SESSION['user']['admin_id'] = $admin_id;
            $_SESSION['user']['branch'] = $branch;
            $_SESSION['user']['department'] = $department;
            $_SESSION['user']['leave_flow'] = $leaveflow;
            $_SESSION['user']['appraisal_flow'] = $appraisalflow;
            $_SESSION['user']['requisition_flow'] = $requisitionflow;
            $_SESSION['user']['cash_flow'] = $cashflow;
            $_SESSION['user']['user_company'] = $user_company;
            $_SESSION['user']['gender'] = $gender;
            $_SESSION['user']['marital_status'] = $marital_status;
            $_SESSION['user']['nationality'] = $nationality;
            $_SESSION['user']['institution'] = $institution;
            $_SESSION['user']['course'] = $course_of_study;
            $_SESSION['user']['cdate_of_employeement'] = $date_of_employment;
            $_SESSION['user']['flow_name'] = $all_leave_approvals_name;
            $_SESSION['user']['flow_phone'] = $all_leave_approvals_phone;
            $_SESSION['user']['confirmed'] = $confirmed;
            $_SESSION['user']['address'] = $address;
            $_SESSION['user']['fname'] = $fname;
            $_SESSION['user']['mname'] = $mname;
            $_SESSION['user']['dob'] = $dob;
            $_SESSION['user']['grade'] = $grade;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['children'] = $children;
            $_SESSION['user']['sname'] = $sname;
            $_SESSION['user']['degree'] = $degree;
            
            $_SESSION['user']['religion'] = $religion;
            $_SESSION['user']['sorigin'] = $sorigin;
            $_SESSION['user']['town'] = $town;
            $_SESSION['user']['lga'] = $lga;
            $_SESSION['user']['sresidence'] = $sresidence;
            $_SESSION['user']['kname'] = $kname;
            
            $_SESSION['user']['kphnumber'] = $kphnumber;
            $_SESSION['user']['kaddress'] = $kaddress;
            $_SESSION['user']['kdob'] = $kdob;
            $_SESSION['user']['kgender'] = $kgender;
            $_SESSION['user']['relationship_kin'] = $relationship_kin;
            $_SESSION['user']['email_kin'] = $email_kin;
            
            $_SESSION['user']['kin_is_beneficiary'] = $kin_is_beneficiary;
            $_SESSION['user']['kin_is_dependent'] = $kin_is_dependent;
            $_SESSION['user']['nysc_cert'] = $nysc_cert;
            $_SESSION['user']['sgrade'] = $sgrade;
            $_SESSION['user']['scourse_of_study'] = $scourse_of_study;
            $_SESSION['user']['sinstitution'] = $sinstitution;
            
            $_SESSION['user']['sdegree'] = $sdegree;
            $_SESSION['user']['tdegree'] = $tdegree;
            $_SESSION['user']['tgrade'] = $tgrade;
            $_SESSION['user']['tcourse_of_study'] = $tcourse_of_study;
            $_SESSION['user']['tinstitution'] = $tinstitution;
            $_SESSION['user']['award_year_one'] = $award_year_one;
            
            $_SESSION['user']['award_body_one'] = $award_body_one;
            $_SESSION['user']['professional_qualification_one'] = $professional_qualification_one;
            
            $_SESSION['user']['award_year_two'] = $award_year_two;
            
            $_SESSION['user']['award_body_two'] = $award_body_two;
            $_SESSION['user']['professional_qualification_two'] = $professional_qualification_two;
            
            $_SESSION['user']['award_year_three'] = $award_year_three;
            
            $_SESSION['user']['award_body_three'] = $award_body_three;
            $_SESSION['user']['professional_qualification_three'] = $professional_qualification_three;

            $_SESSION['user']['on_hmo'] = $on_hmo;
            $_SESSION['user']['hmo'] = $hmo;
            $_SESSION['user']['hmo_plan'] = $hmo_plan;
            $_SESSION['user']['hmo_hospital'] = $hmo_hospital;
            $_SESSION['user']['hmo_number'] = $hmo_number;
            $_SESSION['user']['hmo_status'] = $hmo_status;
            $_SESSION['user']['hmo_remarks'] = $hmo_remarks;

            $_SESSION['user']['pension'] = $pension;
            $_SESSION['user']['pension_pin'] = $pension_number;

            //$_SESSION['user']['profile_image'] = $grade;
            return true;

        } else {
          //return false;
            echo "Error updating record: " . mysqli_error($conn);
            return false;
            //header("Location: settings.php");
        }
        $final_update = 1;
  }
  function processImage($conn,$image,$admin_id,$msg){
    if(isset($image)){
       if($image['name'] == null) {
          
            if($final_update == 1) echo $msg;
            else
            echo $msg;
       }else {
       
       $error = array(); 
       $file_ext = explode('.',$image['name'])[1];
       //$img = explode('.',$image['name'])[0].'_'.strtotime(date('Y-m-d'));
       $img = str_replace('/','',$_SESSION['user']['employee_ID']);
       $file_name = $img.'.'.$file_ext;
       $file_size = $image['size'];
       $file_tmp = $image['tmp_name'];
       $file_type = $image['type'];
       //$file_ext = explode('.',$_FILES['image']['name'])[1];
       $extensions = array('jpeg','jpg','png');
       if(in_array($file_ext,$extensions) === false){
        $errors[] = "extension not allowed, please select a JPEG or PNG file.";
       }
       if($file_size > 209752){
        $errors[] = "File size too large";
       }
       if(empty($errors)==true){
         move_uploaded_file($file_tmp,"images/".$file_name);
          $sql = "UPDATE users SET profile_image = '".$file_name."' Where id = '".$_SESSION['user']['id']."'";
          if (mysqli_query($conn, $sql)) {
            $_SESSION['user']['profile_image'] = $file_name;
            echo $msg; 
          }else {$_SESSION['msg'] = 'Error updating data';echo $msg; return false;}
          /*if($final_update == 1) return true;
          else
           header("Location: staff_settings.php");*/
       }else {
         $msg = $errors[0];
         $_SESSION['msg'] = $msg;
         if($final_update == 1) echo $msg;
         else
           echo $msg;
       }
       }
    }
  }
?>