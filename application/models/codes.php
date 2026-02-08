<?php
/*
Copyright (c) 2020 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko and Alexander Zemlyanoy  (https://vk.com/id00v / https://vk.com/mrsasha082)
*/
class codesModel extends Model {
	public function createCode($data) {
		$sql = "INSERT INTO `codes` SET ";
		$sql .= "cod = '" . $this->db->escape($data['cod']) . "', ";
		$sql .= "uses = '" . (int)$data['uses'] . "', ";
		$sql .= "used = '" . (int)$data['used'] . "', ";
		$sql .= "money = '" . (int)$data['money'] . "', ";
		$sql .= "locationid = '" . (int)$data['locationid'] . "', ";
		$sql .= "gameid = '" . (int)$data['gameid'] . "', ";
		$sql .= "server_day = '" . (int)$data['server_day'] . "', ";
		$sql .= "money_ili_server = '" . (int)$data['money_ili_server'] . "', ";
		$sql .= "slotiki = '" . (int)$data['slotiki'] . "', ";
		$sql .= "ludi = '" . $this->db->escape($data['ludi']) . "' ";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
	
	public function deletecode($codeid) {
		$sql = "DELETE FROM `codes` WHERE id = '" . (int)$codeid . "'";
		$this->db->query($sql);
	}
	
	public function updatecode($codeid, $data = array()) {
		$sql = "UPDATE `codes`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `id` = '" . (int)$codeid . "'";
		$query = $this->db->query($sql);
		return true;
	}
	
	public function getcode($data = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `codes`";
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
	
	public function getcodeById($codeid) {
		$sql = "SELECT * FROM `codes` WHERE `id` = '" . (int)$codeid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getcodeByHui($code) {
		$sql = "SELECT * FROM `codes` WHERE `cod` = '" . (int)$code . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalcode($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `codes`";
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
}
?>
