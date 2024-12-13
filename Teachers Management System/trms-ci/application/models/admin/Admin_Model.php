<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Model extends CI_Model{

     

public function checkLogin($email,$password)
 {
        //query the table 'users' and get the result count
$this->db->where('email', $email);
$this->db->where('password', $password);
$query = $this->db->get('tbladmin');
if($query!=NULL){
return $query->row();
} 

} 

public function getcurrentpassword($id){
$query=$this->db->where('id',$id)
->get('tbladmin');

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
->update('tbladmin',$data);
}     

public function adminprofile($adminid)
{
$query= $this->db->select('id, name, email, password, contact,create_date')
->from('tbladmin')
->where('tbladmin.id',$adminid)
->get();
return $query->row();
}



public function getusedetails()
{
$query= $this->db->select('tblregistration.id, firstName, lastName, email, contactno, state, city, address,subject, profilephoto, qualification, Joiningdate,
create_date, mstsubject.subjectname as subjectname')
->join('mstsubject','tblregistration.subject=mstsubject.id','left')
->from('tblregistration')
->get();
return $query->result();
}

public function alldetails($id)
{
$query= $this->db->select('tblregistration.id, firstName, lastName, email, contactno, state, city, address,subject, profilephoto, qualification, Joiningdate,
create_date, mstsubject.subjectname as subjectname')
->join('mstsubject','tblregistration.subject=mstsubject.id','left')
->from('tblregistration')
->where('tblregistration.id',$id)
->get();
return $query->row();
}
    



}



