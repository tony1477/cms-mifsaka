<?php
class Formatter extends CFormatter
{ 
  public $numberFormat = array('decimals' => 4);
  public $currencyFormat = array('decimals' => 2);
  public $decimalQty = 2;
  public $decimalPrice = 2;
  public $decimalSeparator = ',';
  public $groupSeparator = '.';
  public $dateFormat = 'd-m-Y';
  public $datetimeFormat = 'd-m-Y H:i:s';
  public $timeFormat = 'H:i:s';
  public $baseCurrency = 'Rp ';
  
  public function formatNumber($value)
  {
    if ($value === null)
      return null;
    if ($value === '')
      return '';
    return number_format($value, $this->decimalQty, $this->decimalSeparator, $this->groupSeparator);
  }
  
  public function formatNumberWODecimal($value)
  {
    if ($value === null)
      return null;
    if ($value === '')
      return '';
    return number_format($value, 0, $this->decimalSeparator, $this->groupSeparator);
  }
	
	public function formatCurrencyWOSymbol($value, $symbol = '')
  {
    if ($value === null)
      return null;
    if ($value === '')
      return '';
    return number_format($value, 0, $this->decimalSeparator, $this->groupSeparator);
  }
  
  public function formatCurrency($value, $symbol = '')
  {
    if ($value === null)
      return null;
    if ($value === '')
      return '';
    /* 
    if ($symbol === '') {
      $symbol = $this->baseCurrency;
    }
    return $symbol . number_format($value, $this->decimalPrice, $this->decimalSeparator, $this->groupSeparator);
    */
    if($value < 0) {
        return '(' . number_format($value * -1, $this->decimalPrice, $this->decimalSeparator, $this->groupSeparator) . ')';
    }
    else
    {
         return $symbol . number_format($value, $this->decimalPrice, $this->decimalSeparator, $this->groupSeparator);
    }
  }
  
  public function formatDate($value)
  {
    if ($value === null)
      return null;
    if ($value === '')
      return '';
    $objdate = DateTime::createFromFormat('Y-m-d', $value);
    return $objdate->format($this->dateFormat);
  }
  
  public function formatDateSQL($value)
  {
    if ($value === null)
      return null;
    if ($value === '')
      return '';
    return date('Y-m-d h:i:s', strtotime($value));
  }
  
  public function formatTime($value)
  {
    if ($value === null)
      return null;
    if ($value === '')
      return '';
    $objdate = DateTime::createFromFormat('H:i:s', $value);
    return $objdate->format($this->timeFormat);
  }
  
  public function formatDateTime($value)
  {
    if ($value === null)
      return null;
    if ($value === '')
      return '';
    $objdate = DateTime::createFromFormat('Y-m-d H:i:s', $value);
    return $objdate->format($this->datetimeFormat);
  }
  
  public function formatDateTimeSQL($value)
  {
    if ($value === null)
      return null;
    if ($value === '')
      return '';
    return date('Y-m-d H:i:s', strtotime($value));
  }
  
  public function unformatNumber($formatted_number)
  {
    if ($formatted_number === null)
      return null;
    if ($formatted_number === '')
      return '';
    if (is_float($formatted_number))
      return $formatted_number;
    $value = str_replace($this->groupSeparator, '', $formatted_number);
    $value = str_replace($this->decimalSeparator, '.', $value);
    return (float) $value;
  }
}