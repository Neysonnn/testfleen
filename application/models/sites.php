<?php
/* @mrsasha082 */
class sitesModel extends Model {
	public function createSites($data) {
		$sql = "INSERT INTO `sites` SET ";		
		$sql .= "`sites_url` = '" . $data['sites_url'] . "', ";
		$sql .= "`sites_name` = '" . $data['sites_name'] . "', ";
		$sql .= "`sites_status` = '" . (int)$data['sites_status'] . "', ";
		$sql .= "`sites_textx` = '" . strip_tags(htmlspecialchars_decode($this->db->escape($data['sites_textx'])), '<img><span><ul><ol><pre><li><div><em><strong><sup><code>') . "', ";
		$sql .= "`sites_img` = '" . $data['sites_img'] . "', ";	
		$sql .= "`sites_price` = '" . $data['sites_price'] . "'";
		$this->db->query($sql);
		$return=$this->db->getLastId();		
		return $return;
	}

	public function deleteSites($sitesid) {
		$this->db->query("DELETE FROM `sites` WHERE sites_id = '" . (int)$sitesid . "'");
		$this->db->query("DELETE FROM `users_sites` WHERE sites_id = '" . (int)$sitesid . "'");
	}
	
	public function updateSites($sitesid, $data = array()) {
		$sql = "UPDATE `sites`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `sites_id` = '" . (int)$sitesid . "'";
		$query = $this->db->query($sql);
	}
	
	public function getSites($data = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `sites`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		
		if(!empty($sort)) {
			$count = count($sort);
			$sql .= " ORDER BY";
			foreach($sort as $key => $value) {
				$sql .= " $key " . $value;
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		
		if(!empty($options)) {
			if ($options['start'] < 0) {
				$options['start'] = 0;
			}
			if ($options['limit'] < 1) {
				$options['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$options['start'] . "," . (int)$options['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	 
	public function getSitesById($sitesid) {
		$sql = "SELECT * FROM `sites` WHERE `sites_id` = '" . (int)$sitesid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalSites($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `sites`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		$query = $this->db->query($sql);
		return $query->row['count'];
	}
	
	public function getUserSites($userid) {
		$sql = "SELECT * FROM `users_sites` WHERE `user_id` = '" . (int)$userid . "' ";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function addSites($data) {
		$sql = "INSERT INTO `users_sites` SET ";
		$sql .= "user_id = '" . (int)$data['user_id'] . "', ";
		$sql .= "sites_id = '" . (int)$data['sites_id'] . "'";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
}
?>
