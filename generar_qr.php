<?php
require 'vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;



$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
//$email = $_POST["email"];
$contenido_qr = "$nombre $apellido";


$qrCode = new QrCode($contenido_qr);
$writer=new PngWriter;
$result=$writer->write($qrCode);
//header("Content-Type:" . $result->getMimeType());
//echo $result->getString();
$result->saveToFile("entrada_qr.png");
?>
