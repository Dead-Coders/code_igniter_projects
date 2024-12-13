<?php

namespace App\Controllers;
use App\Models\Auth;
class Main extends BaseController
{   
    protected $request;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->auth_model = new Auth;
        $this->data = ['session' => $this->session];
    }

    public function index()
    {
        $this->data['page_title']="Home";
        return view('pages/home', $this->data);
    }

    public function users(){
        if($this->session->login_type != 1){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->data['page_title']="Users";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        $this->data['total'] =  $this->auth_model->where("id != '{$this->session->login_id}'")->countAllResults();
        $this->data['users'] = $this->auth_model->where("id != '{$this->session->login_id}'")->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['users'])? count($this->data['users']) : 0;
        $this->data['pager'] = $this->auth_model->pager;
        return view('pages/users/list', $this->data);
    }
    public function user_edit($id=''){
        if($this->session->login_type != 1){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if(empty($id))
        return redirect()->to('Main/users');
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            if($password !== $cpassword){
                $this->session->setFlashdata('error',"Password does not match.");
            }else{
                $udata= [];
                $udata['name'] = $name;
                $udata['email'] = $email;
                $udata['type'] = $type;
                $udata['status'] = $status;
                if(!empty($password))
                $udata['password'] = password_hash($password, PASSWORD_DEFAULT);
                $update = $this->auth_model->where('id',$id)->set($udata)->update();
                if($update){
                    $this->session->setFlashdata('success',"User Details has been updated successfully.");
                    return redirect()->to('Main/user_edit/'.$id);
                }else{
                    $this->session->setFlashdata('error',"User Details has failed to update.");
                }
            }
        }

        $this->data['page_title']="Users";
        $this->data['user'] = $this->auth_model->where("id ='{$id}'")->first();
        return view('pages/users/edit', $this->data);
    }
    
    public function user_delete($id=''){
        if($this->session->login_type != 1){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if(empty($id)){
                $this->session->setFlashdata('main_error',"user Deletion failed due to unknown ID.");
                return redirect()->to('Main/users');
        }
        $delete = $this->auth_model->where('id', $id)->delete();
        if($delete){
            $this->session->setFlashdata('main_success',"User has been deleted successfully.");
        }else{
            $this->session->setFlashdata('main_error',"user Deletion failed due to unknown ID.");
        }
        return redirect()->to('Main/users');
    }
}
