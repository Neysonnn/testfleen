<?php
/* @mrsasha082 */
class forumsModel extends Model {
	public function createForums($data) {
		$sql = "INSERT INTO `forums` SET ";		
		$sql .= "`forums_url` = '" . $data['forums_url'] . "', ";
		$sql .= "`forums_name` = '" . $data['forums_name'] . "', ";
		$sql .= "`forums_status` = '" . (int)$data['forums_status'] . "', ";
		$sql .= "`forums_textx` = '" . strip_tags(htmlspecialchars_decode($this->db->escape($data['forums_textx'])), '<img><span><ul><ol><pre><li><div><em><strong><sup><code>') . "', ";
		$sql .= "`forums_img` = '" . $data['forums_img'] . "', ";	
		$sql .= "`forums_price` = '" . $data['forums_price'] . "'";
		$this->db->query($sql);
		$return=$this->db->getLastId();		
		return $return;
	}

	public function deleteForums($forumsid) {
		$this->db->query("DELETE FROM `forums` WHERE forums_id = '" . (int)$forumsid . "'");
		$this->db->query("DELETE FROM `users_forums` WHERE forums_id = '" . (int)$forumsid . "'");
	}
	
	public function updateForums($forumsid, $data = array()) {
		$sql = "UPDATE `forums`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `forums_id` = '" . (int)$forumsid . "'";
		$query = $this->db->query($sql);
	}
	
	public function getForums($data = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `forums`";
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
	 
	public function getForumsById($forumsid) {
		$sql = "SELECT * FROM `forums` WHERE `forums_id` = '" . (int)$forumsid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalForums($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `forums`";
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
	
	public function getUserForums($userid) {
		$sql = "SELECT * FROM `users_forums` WHERE `user_id` = '" . (int)$userid . "' ";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function addForums($data) {
		$sql = "INSERT INTO `users_forums` SET ";
		$sql .= "user_id = '" . (int)$data['user_id'] . "', ";
		$sql .= "forums_id = '" . (int)$data['forums_id'] . "'";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
}
?>
