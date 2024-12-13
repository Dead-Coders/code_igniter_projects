<?php

namespace App\Controllers;
use App\Models\Auth;
use App\Models\Categories;
use App\Models\Posts;
class Main extends BaseController
{   
    protected $request;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->db = db_connect();
        $this->auth_model = new Auth;
        $this->category_model = new Categories;
        $this->post_model = new Posts;
        $this->data = ['session' => $this->session,'request'=>$this->request];
    }

    public function index()
    {
        $this->data['page_title']="Home";
        $this->data['categories']=$this->category_model->countAll();
        if($this->session->login_type == 2){
            $this->post_model->where("posts.user_id = '{$this->session->login_id}' ");
        }
        $this->data['posts']=$this->post_model->countAllResults();
        $this->data['authors']=$this->auth_model->where('type', 2)->countAllResults();
        return view('pages/home', $this->data);
    }

    public function users(){
        $this->data['page_title']="Users";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        $this->data['total'] =  $this->auth_model->where("id != '{$this->session->login_id}'")->countAllResults();
        $this->data['users'] = $this->auth_model->where("id != '{$this->session->login_id}'")->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['users'])? count($this->data['users']) : 0;
        $this->data['pager'] = $this->auth_model->pager;
        return view('pages/users/list', $this->data);
    }
    public function user_add(){
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            if($password !== $cpassword){
                $this->session->setFlashdata('error',"Password does not match.");
            }else{
                $udata= [];
                $udata['name'] = $name;
                $udata['email'] = $email;
                $udata['type'] = $type;
                if(!empty($password))
                $udata['password'] = password_hash($password, PASSWORD_DEFAULT);
                $checkMail = $this->auth_model->where('email',$email)->countAllResults();
                if($checkMail > 0){
                    $this->session->setFlashdata('error',"User Email Already Taken.");
                }else{
                    $save = $this->auth_model->save($udata);
                    if($save){
                        $this->session->setFlashdata('main_success',"User Details has been updated successfully.");
                        return redirect()->to('Main/users');
                    }else{
                        $this->session->setFlashdata('error',"User Details has failed to update.");
                    }
                }
            }
        }

        $this->data['page_title']="Add User";
        return view('pages/users/add', $this->data);
    }
    public function user_edit($id=''){
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
                if(!empty($password))
                $udata['password'] = password_hash($password, PASSWORD_DEFAULT);
                $checkMail = $this->auth_model->where('email',$email)->where('id!=',$id)->countAllResults();
                if($checkMail > 0){
                    $this->session->setFlashdata('error',"User Email Already Taken.");
                }else{
                    $update = $this->auth_model->where('id',$id)->set($udata)->update();
                    if($update){
                        $this->session->setFlashdata('success',"User Details has been updated successfully.");
                        return redirect()->to('Main/user_edit/'.$id);
                    }else{
                        $this->session->setFlashdata('error',"User Details has failed to update.");
                    }
                }
            }
        }

        $this->data['page_title']="Edit User";
        $this->data['user'] = $this->auth_model->where("id ='{$id}'")->first();
        return view('pages/users/edit', $this->data);
    }
    
    public function user_delete($id=''){
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


    // category
    public function categories(){
        $this->data['page_title']="Categories";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        $this->data['total'] =  $this->category_model->countAllResults();
        $this->data['categories'] = $this->category_model->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['categories'])? count($this->data['categories']) : 0;
        $this->data['pager'] = $this->category_model->pager;
        return view('pages/categories/list', $this->data);
    }
    public function category_add(){
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            $udata= [];
            $udata['name'] = htmlspecialchars($this->db->escapeString($name));
            $udata['description'] = htmlspecialchars($this->db->escapeString($description));
            $checkCode = $this->category_model->where('name',$name)->countAllResults();
            if($checkCode){
                $this->session->setFlashdata('error',"Category Already Taken.");
            }else{
                $save = $this->category_model->save($udata);
                if($save){
                    $this->session->setFlashdata('main_success',"Category Details has been updated successfully.");
                    return redirect()->to('Main/categories/');
                }else{
                    $this->session->setFlashdata('error',"Category Details has failed to update.");
                }
            }
        }

        $this->data['page_title']="Add New Category";
        return view('pages/categories/add', $this->data);
    }
    public function category_edit($id=''){
        if(empty($id))
        return redirect()->to('Main/categories');
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            $udata= [];
            $udata['name'] = htmlspecialchars($this->db->escapeString($name));
            $udata['description'] = htmlspecialchars($this->db->escapeString($description));
            $checkCode = $this->category_model->where('name',$name)->where("id!= '{$id}'")->countAllResults();
            if($checkCode){
                $this->session->setFlashdata('error',"Category Already Taken.");
            }else{
                $update = $this->category_model->where('id',$id)->set($udata)->update();
                if($update){
                    $this->session->setFlashdata('success',"Category Details has been updated successfully.");
                    return redirect()->to('Main/category_edit/'.$id);
                }else{
                    $this->session->setFlashdata('error',"Category Details has failed to update.");
                }
            }
        }

        $this->data['page_title']="Edit Category";
        $this->data['category'] = $this->category_model->where("id ='{$id}'")->first();
        return view('pages/categories/edit', $this->data);
    }
    
    public function category_delete($id=''){
        if(empty($id)){
                $this->session->setFlashdata('main_error',"Category Deletion failed due to unknown ID.");
                return redirect()->to('Main/categories');
        }
        $delete = $this->category_model->where('id', $id)->delete();
        if($delete){
            $this->session->setFlashdata('main_success',"Category has been deleted successfully.");
        }else{
            $this->session->setFlashdata('main_error',"Category Deletion failed due to unknown ID.");
        }
        return redirect()->to('Main/categories');
    }

    // Posts
    public function posts(){
        $this->data['page_title']="Posts";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        if($this->session->login_type == 2){
            $this->post_model->where("posts.user_id = '{$this->session->login_id}' ");
        }
        if(!empty($this->request->getVar('search'))){
            $search = $this->request->getVar('search');
            $this->post_model->where(" `posts`.title LIKE '%{$search}%' or `posts`.short_description LIKE '%{$search}%' or `posts`.content LIKE '%{$search}%' or `posts`.tags LIKE '%{$search}%' or `posts`.user_id in (SELECT id from users where email LIKE '%{$search}%') or category_id in (SELECT id FROM `categories` where name LIKE '%{$search}%') ");
        }
        $this->data['total'] =  $this->post_model->countAllResults();
        if(!empty($this->request->getVar('search'))){
            $search = $this->request->getVar('search');
            $this->post_model->where(" `posts`.title LIKE '%{$search}%' or `posts`.short_description LIKE '%{$search}%' or `posts`.content LIKE '%{$search}%' or `posts`.tags LIKE '%{$search}%' or `users`.email LIKE '%{$search}%' or category_id in (SELECT id FROM `categories` where name LIKE '%{$search}%') ");
        }
        if($this->session->login_type == 2){
            $this->post_model->where("posts.user_id = '{$this->session->login_id}' ");
        }
        $this->data['posts'] = $this->post_model
                                ->select("posts.*, users.email as author ")
                                ->join("users", "posts.user_id = users.id", 'inner')
                                ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['posts'])? count($this->data['posts']) : 0;
        $this->data['pager'] = $this->post_model->pager;
        return view('pages/posts/list', $this->data);
    }
    public function post_add(){
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            if($this->request->getFile('banner_img')->getSize() > 0){
                $file = $this->request->getFile('banner_img');
                if(!$file->hasMoved()){
                    $type = $file->getMimeType();
                    if(!strstr($type,"image/")){
                        $this->session->setFlashdata('error', "Invalid Image File type.");
                        $this->data['page_title']="Add New post";
                        $this->data['categories'] = $this->category_model->findAll();
                        return view('pages/posts/add', $this->data);
                    }else{
                        $fname = $file->getName();
                        $i = 1;
                        while(true){
                            if(is_file("public/uploads/".$fname)){
                                $fname = ($i++)."_".$fname;
                            }else{
                                break;
                            }
                        }
                        if($file->move("public/uploads/", $fname)){
                            $banner_url = base_url("public/uploads/".$fname);
                        }else{
                            $this->session->setFlashdata('error', "An error occurred while uploading the image due unknown reason.");
                            $this->data['page_title']="Add New post";
                            $this->data['categories'] = $this->category_model->findAll();
                            return view('pages/posts/add', $this->data);
                        }
                    }
                    
                }
            }
            $udata= [];
            if(isset($banner_url))
            $udata['banner'] = $banner_url;
            $udata['user_id'] = $user_id;
            $udata['category_id'] = $category_id;
            $udata['title'] = htmlspecialchars($this->db->escapeString($title));
            $udata['short_description'] = htmlspecialchars($this->db->escapeString($short_description));
            $udata['content'] = htmlspecialchars($this->db->escapeString($content));
            $udata['tags'] = htmlspecialchars($this->db->escapeString($tags));
            $udata['status'] = $status;
            $save = $this->post_model->save($udata);
            if($save){
                $this->session->setFlashdata('main_success',"Post Details has been added successfully.");
                return redirect()->to('Main/posts/');
            }else{
                $this->session->setFlashdata('error',"Post Details has failed to update.");
            }
    }

        $this->data['page_title']="Add New Post";
        $this->data['categories'] = $this->category_model->findAll();
        return view('pages/posts/add', $this->data);
    }
    public function post_edit($id=''){
        if(empty($id))
        return redirect()->to('Main/posts');
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            if($this->request->getFile('banner_img')->getSize() > 0){
                $file = $this->request->getFile('banner_img');
                if(!$file->hasMoved()){
                    $type = $file->getMimeType();
                    if(!strstr($type,"image/")){
                        $this->session->setFlashdata('error', "Invalid Image File type.");
                        $this->data['page_title']="Edit Post";
                        $this->data['post'] = $this->post_model->where("id ='{$id}'")->first();
                        $this->data['categories'] = $this->category_model->findAll();
                    }else{
                        $fname = $file->getName();
                        $i = 1;
                        while(true){
                            if(is_file("public/uploads/".$fname)){
                                $fname = ($i++)."_".$fname;
                            }else{
                                break;
                            }
                        }
                        if($file->move("public/uploads/", $fname)){
                            $banner_url = base_url("public/uploads/".$fname);
                        }else{
                            $this->session->setFlashdata('error', "An error occurred while uploading the image due unknown reason.");
                            $this->data['page_title']="Edit Post";
                            $this->data['post'] = $this->post_model->where("id ='{$id}'")->first();
                            $this->data['categories'] = $this->category_model->findAll();
                        }
                    }
                    
                }
            }
            $udata= [];
            if(isset($banner_url))
            $udata['banner'] = $banner_url;
            $udata['user_id'] = $user_id;
            $udata['category_id'] = $category_id;
            $udata['title'] = htmlspecialchars($this->db->escapeString($title));
            $udata['short_description'] = htmlspecialchars($this->db->escapeString($short_description));
            $udata['content'] = htmlspecialchars($this->db->escapeString($content));
            $udata['tags'] = htmlspecialchars($this->db->escapeString($tags));
            $udata['status'] = $status;
            $update = $this->post_model->where('id',$id)->set($udata)->update();
            if($update){
                $this->session->setFlashdata('success',"Post Details has been updated successfully.");
                return redirect()->to('Main/post_edit/'.$id);
            }else{
                $this->session->setFlashdata('error',"Post Details has failed to update.");
            }
        }
        $this->data['page_title']="Edit Post";
        $this->data['post'] = $this->post_model->where("id ='{$id}'")->first();
        $this->data['categories'] = $this->category_model->findAll();
        return view('pages/posts/edit', $this->data);
    }
    
    public function post_delete($id=''){
        if(empty($id)){
                $this->session->setFlashdata('main_error',"Post Deletion failed due to unknown ID.");
                return redirect()->to('Main/posts');
        }
        $delete = $this->post_model->where('id', $id)->delete();
        if($delete){
            $this->session->setFlashdata('main_success',"Post has been deleted successfully.");
        }else{
            $this->session->setFlashdata('main_error',"Post Deletion failed due to unknown ID.");
        }
        return redirect()->to('Main/posts');
    }
   
}
