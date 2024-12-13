<?php
class organisation_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getOrganisation()
	{
		$this->db->select('organisation.*');
		$this->db->from('organisation');
		$query = $this->db->get();
		return($query->result_array());
	}



	public function update()
    {
    	$this->db->select('*');
		$query = $this->db->get('organisation');
		if ($query->num_rows() > 0)
		{
			$data = array(
		        'orgName' => $this->input->post('orgName')
		        , 'add1' => $this->input->post('add1')	        
		        , 'add2' => $this->input->post('add2')
		        , 'add3' => $this->input->post('add3')
		        , 'add4' => $this->input->post('add4')
		        , 'electricianNo' => $this->input->post('electricianNo')
		        , 'rechargeLimit' => $this->input->post('rechargeLimit')
		        , 'rechargeMobile' => $this->input->post('rechargeMobile')
			);
			$this->db->update('organisation', $data);			
		}
		else
		{
			$data = array(
		        'orgName' => $this->input->post('orgName')
		        , 'add1' => $this->input->post('add1')	        
		        , 'add2' => $this->input->post('add2')
		        , 'add3' => $this->input->post('add3')
		        , 'add4' => $this->input->post('add4')
		        , 'electricianNo' => $this->input->post('electricianNo')
		        , 'rechargeLimit' => $this->input->post('rechargeLimit')
		        , 'rechargeMobile' => $this->input->post('rechargeMobile')
			);
			$this->db->insert('organisation', $data);	
		}
	}

}