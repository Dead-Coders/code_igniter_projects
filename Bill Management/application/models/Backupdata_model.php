<?php
class Backupdata_model extends CI_Model 
{

        public function __construct()
        {
                $this->load->database('');
        }


        public function insert()
	    {
			$this->db->select_max('itemRowId');
			$query = $this->db->get('items');
	        $row = $query->row_array();

	        $current_row = $row['itemRowId']+1;

			$data = array(
		        'itemRowId' => $current_row
		        , 'itemName' => 'aa'
		        // , 'sellingPrice' => $this->input->post('sellingPrice')
		        // , 'createdBy' => $this->session->userRowId
			);
			$this->db->set('createdStamp', 'NOW()', FALSE);
			$this->db->insert('items', $data);	
		}

		public function alterDb()
	    {
			$this->load->dbforge();
			// $fields = array(
			//         'rechargeLimit' => array('type' => 'INT', 'default' => 0, 'after' => 'electricianNo')
			//         , 'rechargeMobile' => array('type' => 'varchar', 'constraint' => '50', 'after' => 'rechargeLimit')
			// );
			$fields = array(
			        'rechargeLimit' => array('type' => 'INT', 'default' => 0, 'after' => 'electricianNo')
			        , 'rechargeMobile' => array('type' => 'varchar', 'constraint' => '50', 'after' => 'rechargeLimit')
			);
			$this->dbforge->add_column('organisation', $fields);
			// Executes: ALTER TABLE table_name ADD preferences TEXT
		}

		public function tableToArray()
	    {
	    	$this->db->select('purchasedetail.purchaseDetailRowId, purchasedetail.itemRowId, purchase.customerRowId, purchase.purchaseDt');
			$this->db->from('purchasedetail');
			$this->db->join('purchase','purchase.purchaseRowId=purchasedetail.purchaseRowId');
			$this->db->where('purchase.deleted', 'N');
			$this->db->order_by('purchasedetail.purchaseDetailRowId, purchasedetail.purchaseRowId');
			$query = $this->db->get();

			$rows = array();
			foreach($query->result_array() as $row)
			{
				///// CustomerInfo
				$row['customerName'] = "";
				$this->db->select('customers.customerName');
				$this->db->from('customers');
				$this->db->where('customers.customerRowId', $row['customerRowId']);
				$queryCustomers = $this->db->get();
				$rowCustomer = $queryCustomers->row_array();
				if (isset($rowCustomer))
				{
				    $row['customerName'] = $rowCustomer['customerName'];
				}
			    ///// END - CustomerInfo

				///// ItemInfo
				$row['itemName'] = "";
				$this->db->select('items.itemName');
				$this->db->from('items');
				$this->db->where('items.itemRowId', $row['itemRowId']);
				$queryItems = $this->db->get();
				$rowItems = $queryItems->row_array();
				if (isset($rowItems))
				{
				    $row['itemName'] = $rowItems['itemName'];
				}
			    // $row['test'] = $row['customerRowId'];
			    ///// END - ItemInfo
			    $rows[] = $row;
			}

			return $rows;
	    }

	    public function copyItems()
	    {
	    	$this->db->select('items.*');
			$this->db->from('items');
			// $this->db->where('purchase.deleted', 'N');
			$this->db->order_by('items.itemRowId');
			$query = $this->db->get();

			foreach($query->result_array() as $row)
			{
				$this->db->select_max('itemRowId');
				$query = $this->db->get('items');
		        $row1 = $query->row_array();
		        $current_row = $row1['itemRowId']+1;
				$data = array(
			        'itemRowId' => $current_row
			        , 'itemName' => $row['itemName']
			        , 'sellingPrice' => $row['sellingPrice']
			        , 'createdBy' => $this->session->userRowId
				);
				$this->db->set('createdStamp', 'NOW()', FALSE);
				$this->db->insert('items', $data);
			}
	    }

}   