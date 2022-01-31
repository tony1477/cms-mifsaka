<?php
class Formatter extends CFormatter
{
  /**
   * @var array the format used to format a number with PHP number_format() function.
   * Three elements may be specified: "decimals", "decimalSeparator" and 
   * "thousandSeparator". They correspond to the number of digits after 
   * the decimal point, the character displayed as the decimal point,
   * and the thousands separator character.
   * new: override default value: 2 decimals, a comma (,) before the decimals 
   * and no separator between groups of thousands
   */
  
  public $numberFormat = array('decimals' => 4);
  public $currencyFormat = array('decimals' => 2);
  public $decimalqty = 2;
  public $decimalprice = 2;
  public $decimalSeparator = ',';
  public $thousandSeparator = '.';
  
  /**
   * Formats the value as a number using PHP number_format() function.
   * new: if the given $value is null/empty, return null/empty string
   * @param mixed $value the value to be formatted
   * @return string the formatted result
   * @see numberFormat
   */
  public function formatNumber($value)
  {
    if ($value === null)
      return null; // new
    if ($value === '')
      return ''; // new
    return number_format($value, $this->decimalqty, $this->decimalSeparator, $this->thousandSeparator);
  }
  
  public function formatCurrency($value)
  {
    if ($value === null)
      return null; // new
    if ($value === '')
      return ''; // new
    $curr = Yii::app()->db->createCommand("select paramvalue from parameter where paramname = 'basecurrency'")->queryScalar();
    return $curr . number_format($value, $this->decimalqty, $this->decimalSeparator, $this->thousandSeparator);
  }
  
  public function unformatNumber($formatted_number)
  {
    if ($formatted_number === null)
      return null;
    if ($formatted_number === '')
      return '';
    if (is_float($formatted_number))
      return $formatted_number; // only 'unformat' if parameter is not float already
    
    $value = str_replace($this->numberFormat['thousandSeparator'], '', $formatted_number);
    $value = str_replace($this->numberFormat['decimalSeparator'], '.', $value);
    return (float) $value;
  }
}