<?php
class ExcelRow
{
	protected $excel       = null;
	protected $rowNumber   = null;
	protected $currentCell = null;
	
	/**
	* put your comment there...
	* 
	* @var ExcelCell
	*/
	protected $cell        = null;
	protected $cells       = array();
	
	
	public function __construct(Excel $excel, $rowNumber = null)
	{
		$this->excel = $excel;
		$this->cell  = new ExcelCell($excel);
		if ($rowNumber) $this->rowNumber = $rowNumber;
	}
	
	public function setRowNumber($rowNumber = null)
	{
		$this->rowNumber = $rowNumber;
		return $this;
	}
	
	public function read($rowNumber = null, $return = null)
	{
		if (!$rowNumber) $rowNumber = $this->rowNumber;
		$this->cell->setRowNumber($rowNumber);
		$retArr = array();
		for ($i = 1; $i <= $this->excel->reader->sheets[0]['numCols']; $i++) {
			if ($return && ($ret = $this->readCell($i, $return))) {
				$retArr[$i - 1] = $ret;
			} else {
				$this->readCell($i, $return);
			}
		}
		return $return ? $retArr : $this;
	}
	
	protected function readCell($cellNumber = null, $return = null)
	{
		if (!$cellNumber) $this->currentCell;
		return $this->cell->read($cellNumber, $return);
	}
	
	public function writeCells($rowNumber = null)
	{
		
	}
	
	public function show()
	{
		$this->cell->show();
	}
}
?>
