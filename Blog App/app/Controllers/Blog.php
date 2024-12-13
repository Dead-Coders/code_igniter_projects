<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Auth;
use App\Models\Categories;
use App\Models\Posts;

class Blog extends BaseController
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->db = db_connect();
        $this->auth_model = new Auth;
        $this->category_model = new Categories;
        $this->post_model = new Posts;
        $menu_cat = $this->category_model->select("id, name")->orderBy('name','asc')->limit(3)->find();
        $this->data = ['session' => $this->session,'request'=>$this->request, 'menu_cat' => $menu_cat];

    }

    public function index()
    {
        $this->data['page_title'] = "Home";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  5;
        $this->data['total'] =  $this->post_model->where('status', 1)
                                ->orderBy('abs(unix_timestamp(created_at)) DESC')
                                ->countAllResults();
        $this->data['posts'] = $this->post_model->where('status', 1)
                                ->orderBy('abs(unix_timestamp(created_at)) DESC')
                                ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['posts'])? count($this->data['posts']) : 0;
        $this->data['pager'] = $this->post_model->pager;
        
        return view('pages/public/home', $this->data);
    }
    
    public function categories()
    {
        $this->data['page_title'] = "Categories";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  5;
        $this->data['total'] =  $this->category_model->orderBy('abs((name)) asc')
                                ->countAllResults();
        $this->data['categories'] = $this->category_model->orderBy('abs((name)) asc')
                                ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['categories'])? count($this->data['categories']) : 0;
        $this->data['pager'] = $this->category_model->pager;
        
        return view('pages/public/categories', $this->data);
    }
    
    public function category($id="")
    {
        if(empty($id))
        return redirect()->to('Blog/PagenotFound');
        
        $category = $this->category_model->where('id',$id)->first();
        if(!isset($category['id']))
            return redirect()->to('Blog/PagenotFound');
        $this->data['page_title'] = $category['name'];
        $this->data['category'] = $category;
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  5;
        $this->data['total'] =  $this->post_model
                                ->where('status', 1)
                                ->where('category_id', $id)
                                ->orderBy('abs(unix_timestamp(created_at)) DESC')
                                ->countAllResults();
        $this->data['posts'] = $this->post_model
                                ->where('status', 1)
                                ->where('category_id', $id)
                                ->orderBy('abs(unix_timestamp(created_at)) DESC')
                                ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['posts'])? count($this->data['posts']) : 0;
        $this->data['pager'] = $this->post_model->pager;
        return view('pages/public/category', $this->data);
    }
    public function view($id = ''){
        if(empty($id))
        return redirect()->to('Blog/PagenotFound');
        $post = $this->post_model
                     ->select("posts.*, users.email as author, concat(users.name, ' - ', users.email) as author_full, categories.name as category")
                     ->where("posts.id = '{$id}'")
                     ->join('users',"posts.user_id = users.id", "inner")
                     ->join('categories',"posts.user_id = categories.id", "inner")
                     ->first();
        if(!isset($post['id']))
        return redirect()->to('Blog/PagenotFound');
        $this->data['page_title'] = $post['title'];
        $this->data['post'] = $post;
        return view('pages/public/post', $this->data);
    }
    public function PagenotFound(){
        $this->data['page_title'] = "Page Not Found";
        return view('pages/public/page_not_found', $this->data);
    }
}
