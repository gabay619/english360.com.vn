<?php
include "config/connect.php";
$blCl = $dbmg->bl;
$select = $blCl->find([],['phone']);
$arr1 = array();
$arr2 = array();
foreach ($select as $item){
    $arr1[] = $item['phone'];
}
//echo count($arr);die;
require_once 'admincp/plugin/phpexcel/Classes/PHPExcel/IOFactory.php';
$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT']."/list.xlsx");
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
foreach ($sheetData as $k=>$value){
    $rest = substr($value['A'], 0, 1);
    if ($rest == '0') {
        $phone = substr($value['A'], 1);
    }
    $arr2[] = $phone;
}
$result=array_diff($arr2,$arr1);
?>
<table>
    <?php foreach ($result as $val): ?>
    <tr>
        <td>
          0<?php echo $val ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
