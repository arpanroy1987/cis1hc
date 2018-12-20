<?php
header('Content-Type: application/json');
include('connection.php');
$appno = $_REQUEST['app_no'];
$apptype = $_REQUEST['app_type'];
$appyear = $_REQUEST['app_year'];

// //echo $appno." ".$apptype." ".$appyear;

 $sql="SELECT iaf.ia_case_type,ictt.ia_type_name,iaf.ia_regno,iaf.ia_regyear,
 iaf.regcasetype,ctt.type_name,iaf.reg_no,iaf.reg_year,
 iaf.calhc_appl_type,iaf.calhc_appl_no,iaf.calhc_appl_year
 from ia_filing iaf join ia_case_type_t ictt on iaf.ia_case_type=ictt.ia_case_type join case_type_t ctt on iaf.regcasetype=ctt.case_type where calhc_appl_type='".$apptype."' and calhc_appl_no='".$appno."' and calhc_appl_year='".$appyear."'";
 $param_arr=array();

 $stmt=$conn->prepare($sql);	
 $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 $result=$stmt->execute($param_arr);	
 $rec=$stmt->fetchAll(PDO::FETCH_ASSOC);
 
 
 
 echo json_encode($rec);
 
?>