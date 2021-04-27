<?php
require_once '../includes/conn.php';
require_once '../functions.php';
require_once './pdfGen/fpdf.php';

$getParam = $_POST['type_of_report'];


$pdf = new FPDF('P','mm','A3');
$pdf->SetTitle('FPDF tutorial'); 
//add new page

$pdf->AddPage();

//set up the font

$pdf->SetFont('Arial','B',14);

if($getParam == 'users_list'){
    $pdf->Ln();
	    $pdf->SetFont('Arial','',10);
	    $pdf->Cell(270,5,'All Users ',0,0,'R');
	    $pdf->Ln();
	    $pdf->Ln();
	    $pdf->Ln();
	    $pdf->Ln();
	    $pdf->SetFont('Times','',18);
	    // $pdf->Cell(290,5,'De Progress Primary ',0,0,'C');
	    $pdf->Ln();
	    $pdf->Ln();
	    $pdf->Cell(290,5,'All Users Report',0,0,'C');
	    
	    $pdf->Ln();
        $pdf->Ln();
        
        $getProvince = mysqli_query($db_link, "SELECT province, COUNT(province) as ProvinceCount, city, 
        COUNT(city) as CityCount FROM `users_tbl` GROUP BY province");

        $pdf->Cell(70 ,10,'City',1,0,'C');
        $pdf->Cell(70 ,10,'Total Count ',1,0,'C');
        $pdf->Cell(70,10,'Province',1,0,'C');
        $pdf->Cell(70 ,10,'Province Count',1,1,'C');
        $num = 1;
        while ($rows = mysqli_fetch_assoc($getProvince)) {
           

           $pdf->Cell(70 ,7,$rows['city'],1,0,'C');
           $pdf->Cell(70 ,7,$rows['CityCount'],1,0,'C');
           $pdf->Cell(70 ,7,$rows['province'],1,0,'C');
           $pdf->Cell(70 ,7,$rows['ProvinceCount'],1,1,'C');
        }
        $pdf->Output();
} else if ($getParam == 'blood_group'){
    $getOptions = $_POST['blood_groups'];

    $pdf->Ln();
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(270,5,'All Users ',0,0,'R');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('Mono','',18);
    // $pdf->Cell(290,5,'De Progress Primary ',0,0,'C');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(290,5,'All Users Report',0,0,'C');
    
    $pdf->Ln();
    $pdf->Ln();
    $firstSQL = mysqli_query($db_link, "SELECT users_tbl.blood_group, COUNT(users_tbl.blood_group) AS BG
                    FROM users_tbl
                    GROUP BY users_tbl.blood_group");

    $secondSQL = mysqli_query($db_link, "SELECT request_tbl.request_blood_group, 
                    COUNT(request_tbl.request_blood_group) AS SEC_BG FROM request_tbl");
    
    $pdf->Cell(90 ,10,'Blood Group',1,0,'C');
    $pdf->Cell(90 ,10,'Total Users With this Group ',1,0,'C');
    $pdf->Cell(90,10,'Total Requests ',1,1,'C');

    foreach($firstSQL as $rows){
        $pdf->Cell(90 ,10,$rows['blood_group'],1,0,'C');
        $pdf->Cell(90 ,10,$rows['BG'],1,0,'C');

        foreach($secondSQL as $secRows){
            if($secRows['request_blood_group'] == $rows['blood_group']){
                $pdf->Cell(90,10,$secRows['SEC_BG'],1,1,'C');
            }else {
                $pdf->Cell(90,10,'0',1,1,'C');
            }
        }

    }
    
    $pdf->Output();
}else if($getParam == 'hospital_search'){

    $pdf->Ln();
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(270,5,'All Blood Bank Centers ',0,0,'R');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    // $pdf->SetFont('Mono','',18);
    // $pdf->Cell(290,5,'De Progress Primary ',0,0,'C');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(290,5,'All Blood Bank Centers',0,0,'C');
    
    $pdf->Ln();
    $pdf->Ln();
    $firstSQL = mysqli_query($db_link, "SELECT hospital_tbl.hosp_name, hospital_tbl.hosp_city 
    FROM hospital_tbl GROUP BY hospital_tbl.hosp_name");

    $secondSQL = mysqli_query($db_link, "SELECT request_tbl.requested_hosp, 
                    COUNT(request_tbl.requested_hosp) AS REQHOS FROM request_tbl");
    
    $pdf->Cell(90 ,10,'Hospital Name',1,0,'C');
    $pdf->Cell(90 ,10,'Belongs to City',1,0,'C');
    $pdf->Cell(90,10,'Total Requests Received',1,1,'C');

    foreach($firstSQL as $rows){
        $pdf->Cell(90 ,10,$rows['hosp_name'],1,0,'C');
        $pdf->Cell(90 ,10,$rows['hosp_city'],1,0,'C');

        foreach($secondSQL as $secRows){
            if($secRows['requested_hosp'] == $rows['hosp_name']){
                $pdf->Cell(90,10,$secRows['REQHOS'],1,1,'C');
            }else {
                $pdf->Cell(90,10,'0',1,1,'C');
            }
        }

    }
    
    $pdf->Output();
}

?>