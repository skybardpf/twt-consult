<?php
class CNGeoIP
{
	const FILENAME_BINARY_TREE = "zf/third-party/geobaza/cngeoip.dat";
	private $is_valid;
	private $error_message;
	private $level_size;
	private $start_offset;
	private $fp_binary_tree;
	private $dbh;
	
	public function __construct($filepath = self::FILENAME_BINARY_TREE)
	{
		$this->is_valid = false;
		$this->error_message = "";
		$this->fp_binary_tree = fopen($filepath, 'r');
		if (!$this->fp_binary_tree) {
			$this->error_message = "Can't open binary tree file \"" . $filepath . "\"";
			return false;
		}
		$data = fread($this->fp_binary_tree, 7);
		if ($data != "CNGEOIP") {
			$this->error_message = "Invalid datafile signature";
			return false;
		}
		$data = fread($this->fp_binary_tree, 2);
		$unp = unpack('nlen', $data);
		$data = fread($this->fp_binary_tree, $unp['len']);
		$this->headers = json_decode($data, true);
		$this->level_size = array();
		for (;;) {
			$data = fread($this->fp_binary_tree, 1);
			$unp = unpack('Cdata', $data);
			$hi = ($unp['data'] >> 4) & 0x0f;
			$lo = $unp['data'] & 0x0f;
			$this->level_size[] = $hi;
			if ($hi == 0)
				break;
			$this->level_size[] = $lo;
			if ($lo == 0)
				break;
		}
		$this->start_offset = ftell($this->fp_binary_tree);
		$this->is_valid = true;
	}

	public function __destruct()
	{
		fclose($this->fp_binary_tree);
	}

	public function lookup($ip)
	{
		if (!$this->is_valid) return false;
		$ipint = ip2long($ip);
		$shift = 32;
		$offset = $this->start_offset;
		$result = array();
		for ($l = 0; $l < sizeof($this->level_size); $l++) {
			$shift -= $this->level_size[$l];
			$index = (($ipint >> $shift)) & ((1 << $this->level_size[$l]) - 1);
			$tell = $offset + $index * 4;
			fseek($this->fp_binary_tree, $tell, 0);
			$data = fread($this->fp_binary_tree, 4);
			$unp = unpack('Ndata', $data);
			$offset = $unp['data'] & 0xffffffff;
			if ($offset & 0x80000000) {
				while ($offset) {
					$tell = $offset & 0x7fffffff;
					fseek($this->fp_binary_tree, $tell, 0);
					$data = fread($this->fp_binary_tree, 2);
					$unp = unpack('nlen', $data);
					$length = $unp['len'] & 0xffff;
					if (!$length) return "";
					$info = fread($this->fp_binary_tree, $length);
					$unpacked_data = json_decode($info, true);
					if (isset($unpacked_data['special'])) {
						return $unpacked_data;
					}
					$result[] = $unpacked_data;
					$data = fread($this->fp_binary_tree, 4);
					$unp = unpack('Nparent', $data);
					$offset = $unp['parent'];
				}
				break;
			}
		}
		return array('items' => $result);
	}

	public function is_valid()
	{
		return $this->is_valid;
	}

	public function get_error()
	{
		return $this->error_message;
	}
}
?>
