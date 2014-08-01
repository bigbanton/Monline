<?
$localDate=getdate();
$minYear = $localDate["year"];
$maxYear = $minYear + 15;

function printYearDropdown($sel='')
{
  global $minYear, $maxYear;

  $output =  "<option value=''>--</option>";
  for($i=$minYear; $i<$maxYear; $i++) {
    $output .= "<option value='". substr($i, 2, 2) ."'".($sel==(substr($i, 2, 2))?' selected':'').
	">". $i ."</option>";
  }
  return($output);
}

function printMonthDropdown($sel='')
{
  $output =  "<option value=''>--</option>";
  for($i=1; $i<13; $i++) {
    if($i<10)
	$value = "0" . $i;
    else
	$value = $i;
    $output .= "<option value='". $value."'".($sel==$i?' selected':'').
	">". $value ."</option>";
  }
  return($output);
}

?>
