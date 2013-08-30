<?php
require_once 'zf/tools/excel/excelrow.class.php';
require_once 'zf/tools/excel/excelcell.class.php';
class Excel implements Iterator
{
	public    $reader       = null;
	public    $writer       = null;
	public    $currentSheet = null;
	public    $need2encode  = null;
	
	/**
	* put your comment there...
	* 
	* @var ExcelRow
	*/
	protected $row          = null;
	protected $currentRow   = null;
	protected $rowsCount    = null;
	protected $currentCell  = null;
	
	protected $fileName     = null;
	protected $isLoaded     = null;
	
	
	public function __construct($fileName = null)
	{
		if ($fileName) $this->fileName = $fileName;	
	}
	
	protected function getRow($rowNumber = null)
	{
		if (!$rowNumber) {
			$rowNumber = $this->currentRow;
		} else {
			$this->currentRow = $rowNumber;
		}
		
		if ($this->row) {
			return $this->row->setRowNumber($rowNumber);
		} else {
			$this->row = new ExcelRow($this, $rowNumber);
			return $this->row;
		}
	}
	
	public function setSheet($sheetNumber = 0)
	{
		$this->currentSheet = $sheetNumber;
	}
	
	public function Load($fileName, $OutputEncoding = 'utf-8')
	{
		if (!$this->reader) $this->reader = $this->getExcelReader();
		if (strtolower($OutputEncoding) !== 'cp1251') {
			$this->need2encode = 1;
		}
		$this->reader->setOutputEncoding($OutputEncoding);
		$this->reader->read($fileName);
		$this->setSheet();
		$this->currentRow = 0;
		return $this;
	}
	
	public function readRow($rowNumber = null)
	{
		return $this->getRow($rowNumber)->read();
	}
	
	public function getData($rowNumber = null)
	{
		return $this->getRow($rowNumber)->read(null, 'data');
	}
	
	public function getRowsCount()
	{
		return $this->reader->sheets[$this->currentSheet]['numRows'];
	}
		
	protected function getExcelReader()
	{
		require_once 'zf/third-party/phpExcelReader/oleread.inc';
		require_once 'zf/third-party/phpExcelReader/reader.php';
		return new Spreadsheet_Excel_Reader();
	}
	
	public function create($fileName)
	{
		ini_set("include_path", ini_get("include_path").PATH_SEPARATOR.ltrim(zf::$zf_root_url, '/').'zf/third-party/pear/');
		require_once 'zf/third-party/pear/PEAR.php';
		require_once 'Writer.php';
		$this->reader = new Spreadsheet_Excel_Writer($fileName);
		return $this->reader;
	}
	
	
	
	
	public function current()
	{
		return $this->getData();
	}
	
	public function next()
	{
		$this->currentRow++;
	}
	
	public function key()
	{
		return $this->currentRow;
	}
	
	public function valid()
	{
		if ($this->rowsCount === null) $this->rowsCount = $this->getRowsCount();
		return ($this->currentRow <= $this->rowsCount);
	}
	
	public function rewind()
	{
		$this->currentRow = 0;
	}
}
?>
