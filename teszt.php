<?php

include ('session.php');

require_once 'dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

$sql="SELECT * FROM `felhasznalok`";
$result = $db->query($sql);

$html='
<h1>EZ itt pontozó lap</h1>';

$randomvalami="HelloSzia!";
// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream();

$filePath="files/valami.pdf";
$output = $dompdf->output();
file_put_contents($filePath, $output);
?>