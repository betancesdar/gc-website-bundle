<?php 
    $to_email = 'betancesdar08@gmail.com';

    $subject = 'New employee'

    $message = "Se ha recibido un nuevo formulario de contacto:\n\n";
    $message .= "Nombre completo: " . $_POST['fullname'] . "\n";
    $message .= "Correo electrónico: " . $_POST['email'] . "\n";
    $message .= "Número de contacto: " . $_POST['phone'] . "\n";
    $message .= "ID Dominicano: " . $_POST['document'] . "\n";

    $uploaded_file = $_FILES['uploaded_file'];

    $temp_name = $uploaded_file['tmp_name'];

    // Nombre original del archivo cargado
$file_name = $uploaded_file['name'];

// Tipo MIME del archivo cargado
$file_type = $uploaded_file['type'];

// Leer el contenido del archivo cargado
$file_content = file_get_contents($temp_name);

// Codificar el contenido del archivo para enviarlo por correo
$attachment = chunk_split(base64_encode($file_content));

// Encabezados para el correo electrónico
$headers = "From: sender@example.com\r\n";
$headers .= "Reply-To: sender@example.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"\r\n";
$headers .= "Content-Disposition: attachment; filename=\"".$file_name."\"\r\n";

// Construir el mensaje multipart
$body = "--PHP-mixed-".$random_hash."\r\n";
$body .= "Content-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"\r\n\r\n";
$body .= "--PHP-alt-".$random_hash."\r\n";
$body .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
$body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$body .= $message."\r\n\r\n";
$body .= "--PHP-alt-".$random_hash."\r\n";
$body .= "Content-Type: application/pdf; name=\"".$file_name."\"\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n";
$body .= "Content-Disposition: attachment\r\n\r\n";
$body .= $attachment."\r\n\r\n";
$body .= "--PHP-mixed-".$random_hash."--";

// Enviar el correo electrónico
if (mail($to_email, $subject, $body, $headers)) {
    echo 'El formulario se ha enviado correctamente.';
} else {
    echo 'Error al enviar el formulario. Por favor, inténtelo de nuevo más tarde.';
}
?>