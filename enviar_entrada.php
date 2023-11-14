<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];

    include 'generar_qr.php';

    //phpmailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Username = 'pruebatortu1@gmail.com';
    $mail->Password = 'flhq qxrk lpmx zaie';

    //correo
    $mail->setFrom('pruebatortu1@gmail.com', 'tortu');
    $mail->addAddress($email, $nombre . ' ' . $apellido);
    $mail->Subject = 'prueba';
    $mail->Body = 'entrada';

    $mail->addAttachment('entrada_qr.png');

    try {
        $mail->send();

        // phpadmin
        $conexion = new mysqli("localhost", "root", "", "entradas_evento");

        if ($conexion->connect_error) {
            die("Error en la conexión a la base de datos: " . $conexion->connect_error);
        }

        $codigo_qr = base64_encode(file_get_contents('entrada_qr.png'));

        $sql = "INSERT INTO compradores (nombre, apellido, email, codigo_qr) VALUES ('$nombre', '$apellido', '$email', '$codigo_qr')";

        if ($conexion->query($sql) === TRUE) {
            echo "¡Entrada enviada y registrada correctamente!";
        } else {
            echo "Error al registrar la entrada: " . $conexion->error;
        }

        $conexion->close();
    } catch (Exception $e) {
        echo "Error al enviar el correo: " . $mail->ErrorInfo;
    }
}
?>
