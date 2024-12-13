<?php 

/**
 * 
 */
class User_model extends CI_Model
{
	
	public function add_student()
	{
		$data = $this->upload->data();
    	$image_path = base_url("uploads/image/".$data['raw_name'].$data['file_ext']);

    	$data = array(
    		's_name'	=> $this->input->post('s_name'),
    		'g_name'	=> $this->input->post('g_name'),
    		'contact'	=> $this->input->post('contact'),
    		'email'		=> $this->input->post('email'),
    		'address'	=> $this->input->post('address'),
    		'year' 	=> $this->input->post('year'),
    		'division' 	=> $this->input->post('division'),
    		'b_group' 	=> $this->input->post('b_group'),
    		'shift' 	=> $this->input->post('shift'),
    		'gender' 	=> $this->input->post('gender'),
    		'profile_image' => $image_path
    	);

    	$insert_student = $this->db->insert('students', $data);
    	return $insert_student;
	}

	public function get_students()
	{
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('students');
		return $query->result();
	}

	public function get_student_details($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('students');
		return $query->row();
	}

	public function edit_student($id, $data)
	{
		$data = $this->upload->data();
    	$image_path = base_url("uploads/image/".$data['raw_name'].$data['file_ext']);

    	$data = array(
    		's_name'	=> $this->input->post('s_name'),
    		'g_name'	=> $this->input->post('g_name'),
    		'contact'	=> $this->input->post('contact'),
    		'email'		=> $this->input->post('email'),
    		'address'	=> $this->input->post('address'),
    		'year' 		=> $this->input->post('year'),
    		'division' 	=> $this->input->post('division'),
    		'b_group' 	=> $this->input->post('b_group'),
    		'shift' 	=> $this->input->post('shift'),
    		'gender' 	=> $this->input->post('gender'),
    		'profile_image' => $image_path
    	);

    	return $query = $this->db->where('id', $id)->update('students', $data);
	}

	public function delete_student($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('students');
	}

	/*=== Register New admin ===*/
	public function register_admin()
	{

		$options = ['cost'=> 12];
		$encripted_pass = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);

		$data = array(

		'admin_name'	=> $this->input->post('admin_name'),
		'email'	=> $this->input->post('email'),
		'password' => $encripted_pass

		);

		$insert_data = $this->db->insert('users', $data);
		return $insert_data;

	}

	public function students_slider()
	{
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('students');
		return $query->result();
	}
}