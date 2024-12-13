<?php
class Right_model extends CI_Model 
{
	public function __construct()
    {
            $this->load->database('');
    }

	public function deleteRecord()
	{
		$this->db->where('userrowid', $this->input->post('uid'));
		$this->db->delete('userrights');
	}

 	public function insertAjax()
    {
		$this->db->select_max('rightrowid');
		$query = $this->db->get('userrights');
		$this->deleteRecord();
		if ($query->num_rows() > 0)
		{
	        $row = $query->row_array();
        	$uid  = $this->input->post('uid');
			$data = explode(",", $_POST['rights']);


         	$current_row = $row['rightrowid']+1;
	       	for ($i=0; $i <count($data) ; $i++)
	       	{

	       		// echo $data[$i];
	       		 // $this->db->query("INSERT INTO `userrights`(`rightrowid`, `userrowid`, `menuoption`, `createdby`, `createdstamp`) VALUES ("
	       		 // 	.$current_row.",".$uid.",".$data[$i].",".$this->session->userRowId.",NOW())");
				$data1 = array(
		        'rightrowid' => $current_row,
		        'userrowid' =>$uid,
		        'menuoption' => $data[$i],
		        'createdby' => $this->session->userRowId
				);
				$this->db->set('createdstamp', 'NOW()', FALSE);
				$this->db->insert('userrights', $data1);
				$current_row++;
			}
		}


		//////user ab access
		$data5 = array(
		        'abAccessIn' => $this->input->post('users4ab')
		);

		$this->db->where( 'rowid', $this->input->post('uid') );
		$this->db->update('users', $data5);
		// echo $this->input->post('uid');
	}

	public function getDataForCheckBox()
	{
		// $this->db->select('vehicleRowId, vehicleNo');
		// $this->db->where('deleted', 'N');
		// $this->db->order_by('vehicleNo');
		// $query = $this->db->get('vehicles');
		// $arr = array();
		// foreach ($query->result_array() as $row)
		// {
  //   		$arr[$row['vehicleRowId']]= $row['vehicleNo'];
		// }
		// return $arr;
	}
}