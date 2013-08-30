<?php
class ExcelCell
{
	/**
	* put your comment there...
	* 
	* @var Excel
	*/
	protected $excel;
	protected $dataIn;
	protected $dataOut;
	
	protected $rowNumber;
	
	public function __construct(Excel $excel)
	{
		$this->excel = $excel;
	}
	
	public function setRowNumber($rowNumber)
	{
		$this->rowNumber = $rowNumber;
	}
	
	public function read($cellNumber, $return = null)
	{
		$sheet = $this->excel->reader->sheets[$this->excel->currentSheet];
		
		if (isset($sheet['cells'][$this->rowNumber][$cellNumber])) {
			$this->dataOut[$cellNumber - 1]['data'] = $this->excel->need2encode
				?
			iconv('cp1251', 'utf-8', $sheet['cells'][$this->rowNumber][$cellNumber])
				:
			$sheet['cells'][$this->rowNumber][$cellNumber];
		}
		
		if (isset($sheet['cellsInfo'][$this->rowNumber][$cellNumber])) {
			$this->dataOut[$cellNumber - 1]['info'] = $sheet['cellsInfo'][$this->rowNumber][$cellNumber];
		}
		
		switch ($return) {
			case 'data': 
				if (isset($this->dataOut[$cellNumber - 1]['data'])) {
					return $this->dataOut[$cellNumber - 1]['data'];
				} else {
					return null;
				}
		}
	}
	
	public function show()
	{
		echo "in: ";
		debug::dump($this->dataIn);
		echo "<br />out: ";
		debug::dump($this->dataOut);
	}
}
?>
