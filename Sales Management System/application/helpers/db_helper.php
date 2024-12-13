<?php

/*
	@author : Olaiya Segun paul
	A simple helper class to comunicate with db. not an ORM, not some active records abstraction layer, jst a basic stuff for this basic application. :)
 */

	class DB 
	{

		static function save($table = '', $data = [])
		{
			$CI = & get_instance();
			$CI->db->insert($table, $data);
			return $CI->db->insert_id();
		}

		static function get($table = '', $orderfield = '', $ordercode='', $limit = '', $offset = '', $where=[])
		{
			$CI = & get_instance();
			if(!empty($orderfield) && !empty($ordercode))
				$CI->db->order_by($orderfield, $ordercode);
			if($limit > 0 && $offset >= 0)
				$CI->db->limit($limit, $offset);
			if(!empty($where))
				return $CI->db->get_where($table, $where)->result();

			return $CI->db->get($table)->result();
		}

		

		static function get_row($table='', $where=[])
		{
			$CI = & get_instance();
			$query = $CI->db->get_where($table, $where);
			if($query->num_rows() > 0)
				return $query->row();
			else
				return false;
		}

		static function update($table='', $where=[], $data =[])
		{
			$CI = & get_instance();
			$CI->db->where($where);
			$CI->db->update($table, $data);
			if($CI->db->affected_rows() > 0)
				return true;
			else
				return false;
		}

		static function delete($table='', $where=[])
		{
			$CI = & get_instance();
			$CI->db->where($where);
			$CI->db->delete($table);
			if($CI->db->affected_rows() > 0)
				return true;
			else
				return false;
		}

		static function get_cell($table='', $where=[], $cell='')
		{
			$CI = & get_instance();
			$query = $CI->db->get_where($table, $where);
			if($query->num_rows() > 0)
				return $query->row()->$cell;
			else
				return '';
		}

		static function it_exists($table='', $field='', $value='')
		{
			$CI = & get_instance();
			$query = $CI->db->get_where($table, array($field=>$value));
			if($query->num_rows() > 0)
				return true;
			else
				return false;
		}

		
		static function num_rows($table = '', $where=[])
		{
			$CI = & get_instance();
			return $CI->db->get_where($table, $where)->num_rows();
		}

		
		static function table_sum($table = '', $field = '', $where=[])
		{
			$CI = & get_instance();
			$CI->db->where($where);
			$CI->db->select_sum($field, 'sum');
			return $CI->db->get($table)->result()[0]->sum;
		}

		static function table_max($table = '', $field = '')
		{
			$CI = & get_instance();
			$CI->db->select_max($field, 'max');
			return $CI->db->get($table)->result()[0]->max;
		}

	}
