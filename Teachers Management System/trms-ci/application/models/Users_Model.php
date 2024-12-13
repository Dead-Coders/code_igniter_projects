<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Model extends CI_Model{

      public function AddReg($firstName,$lastName,$email,$contactno,$state,$city,$address,$subject,$profilephoto,$qualification,$Joiningdate,$password)
      {
      $data = array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'contactno' => $contactno,
            'state' => $state,
            'city' => $city,
            'address' => $address,
            'subject' => $subject,
            'profilephoto' => $profilephoto,
            'qualification' => $qualification,
            'Joiningdate' => $Joiningdate,
            'password' => $password
            
        );
        $query=$this->db->insert('tblregistration',$data);
     
      if($query){
$this->session->set_flashdata('success','<div class="alert alert-success alert-dismissible fade show"><strong>success!</strong> Registration Successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>');  
    
redirect('user/Registration');
} else {
$this->session->set_flashdata('error', '<div class="alert alert-warning alert-dismissible fade show"><strong>error!</strong>Something went wrong. Please try again.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>');   
redirect('user/Registration');    
}
    
}

public function checkLogin($email,$password)
 {
        //query the table 'users' and get the result count
        $this->db->where('email', $email);
        $this->db->where('password', $password);
         $query = $this->db->get('tblregistration');
         if($query!=NULL){
    return $query->row();
          } 

} 

public function getcurrentpassword($id){
$query=$this->db->where('id',$id)
->get('tblregistration');

if($query->num_rows()>0)
{
return $query->row();
} 
}
   

// For updating Password
public function updatepassword($id,$newpassword)
{
$data=array('password' =>$newpassword );    
return $this->db->where(['id'=>$id])
                ->update('tblregistration',$data);
}     


public function getusedetails($userid)
     {

        $query= $this->db->select('tblregistration.id, firstName, lastName, email, contactno, state, city, address,
 subject, profilephoto, qualification, Joiningdate, password,
 create_date, mstsubject.subjectname as subjectname')

        ->join('mstsubject','tblregistration.subject=mstsubject.id','left')
       
        ->from('tblregistration')
        ->where('tblregistration.id',$userid)
        ->get();
         return $query->row();
     }

     public function updateuserprofile($id,$firstName,$lastName,$email,$contactno,$state,$city, $address,$subject,$profilephoto,$qualification,$Joiningdate){
$data=array(
'firstName'=>$firstName,
'lastName'=>$lastName,
'email'=>$email,
'contactno'=>$contactno,
'state'=>$state,
'city'=>$city,
'address'=>$address,
'subject'=>$subject,
'profilephoto'=>$profilephoto,
'qualification'=>$qualification,
'Joiningdate'=>$Joiningdate

);  
$query=$this->db->where('id',$id)
                ->update('tblregistration',$data);
               

}



}



