<?php 
class Poi_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function add($data)
	{
		$this->db->insert('map_nodes',$data);
	}
	
	function edit($id, $data)
	{
		$this->db->where('node_no',$id);
		$this->db->update('map_nodes',$data);
	}
	
	function get_POIs($type, $offset, $limit)
	{
		$query = $this->db->get_where('map_nodes', array('node_type' => $type), $offset, $limit);
		
		return $query->result_array();
			$query->free_result();
	}
	
	function get_POIs_in_between_limitless($start, $end)
	{
		//$query = $this->db->get_where('map_nodes', array('node_type' => $type), $offset, $limit);
		$where = 'node_endDate between "' . $start . '" AND "' . $end . '"';
	
		$this->db->from('map_nodes')
				->where($where);
	
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
	
	function get_POIs_in_between($start, $end, $offset, $limit)
	{
		//$query = $this->db->get_where('map_nodes', array('node_type' => $type), $offset, $limit);
		$where = 'node_endDate between "' . $start . '" AND "' . $end . '"';
		
		$this->db->from('map_nodes')
				->where($where)
				->limit($offset, $limit);
		
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
	
	function get_unending_POIs($offset, $limit)
	{
		$query = $this->db->get_where('map_nodes', array('node_endDate' => 0), $offset, $limit);
		
		return $query->result_array();
			$query->free_result();
	}
	
	function get_poi($no)
	{
		$query = $this->db->get_where('map_nodes', array('node_no' => $no));
		
		return $query->row_array();
			$query->free_result();
	}
	
	function search_limitless($search_term)
	{
		$this->db->from('map_nodes')
		->join('bhw','map_nodes.node_barangay = bhw.barangay')
		->like('node_name', $search_term)
		->or_like('node_notes', $search_term);
	
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
	
	function search($search_term, $offset = FALSE, $limit = FALSE)
	{
		$this->db->from('map_nodes')
				->join('bhw','map_nodes.node_barangay = bhw.barangay')
				->like('node_name', $search_term)
				->or_like('node_notes', $search_term)
				->limit($offset, $limit);
	
		$query = $this->db->get();
		return $query->result_array();
			$query->free_result();
	}
}

/* End of poi_model.php */
/* Location: ./application/models/poi_model.php */