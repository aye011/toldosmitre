<?php
header('Content-Type: text/html; charset=UTF-8');

$to = 'ayelen@g2rocket.com';

$producto  = isset($_POST['producto'])  ? strip_tags(trim($_POST['producto']))  : 'Home';
$nombre    = isset($_POST['nombre'])    ? strip_tags(trim($_POST['nombre']))    : '';
$telefono  = isset($_POST['telefono'])  ? strip_tags(trim($_POST['telefono']))  : '';
$email     = isset($_POST['email'])     ? strip_tags(trim($_POST['email']))     : '';
$medidas   = isset($_POST['medidas'])   ? strip_tags(trim($_POST['medidas']))   : '';
$mensaje   = isset($_POST['mensaje'])   ? strip_tags(trim($_POST['mensaje']))   : '';
$consulta  = isset($_POST['consulta'])  ? strip_tags(trim($_POST['consulta']))  : '';
$device    = isset($_POST['device'])    ? strip_tags(trim($_POST['device']))    : '';
$utm_source   = isset($_POST['utm_source'])   ? strip_tags(trim($_POST['utm_source']))   : '';
$utm_medium   = isset($_POST['utm_medium'])   ? strip_tags(trim($_POST['utm_medium']))   : '';
$utm_campaign = isset($_POST['utm_campaign']) ? strip_tags(trim($_POST['utm_campaign'])) : '';

// Validación básica
if (empty($nombre) || empty($telefono) || empty($email)) {
    http_response_code(400);
    echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Error</title></head><body>';
    echo '<p>Por favor completá Nombre, Teléfono y Email.</p>';
    echo '<p><a href="javascript:history.back()">Volver</a></p>';
    echo '</body></html>';
    exit;
}

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Error</title></head><body>';
    echo '<p>El email ingresado no es válido.</p>';
    echo '<p><a href="javascript:history.back()">Volver</a></p>';
    echo '</body></html>';
    exit;
}

// Texto del mensaje (usar mensaje o consulta según el form)
$textoMensaje = !empty($mensaje) ? $mensaje : $consulta;

// Armar el email
$subject = "Nueva consulta - $producto | Toldos Mitre";

$body  = "Nueva consulta desde el sitio web\n";
$body .= "================================\n\n";
$body .= "Producto: $producto\n";
$body .= "Nombre: $nombre\n";
$body .= "Teléfono: $telefono\n";
$body .= "Email: $email\n";
if (!empty($medidas))       $body .= "Medidas: $medidas\n";
if (!empty($textoMensaje))  $body .= "Mensaje: $textoMensaje\n";
$body .= "\n--- Datos de tracking ---\n";
$body .= "Dispositivo: $device\n";
if (!empty($utm_source))   $body .= "UTM Source: $utm_source\n";
if (!empty($utm_medium))   $body .= "UTM Medium: $utm_medium\n";
if (!empty($utm_campaign)) $body .= "UTM Campaign: $utm_campaign\n";

$headers  = "From: noreply@toldosmitre.com.ar\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$enviado = mail($to, $subject, $body, $headers);

// Página de agradecimiento
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gracias | Toldos Mitre</title>
  <link rel="icon" type="image/webp" href="img/favicon.webp">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Lato', sans-serif; background: #f3f3f3; color: #333; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
    .gracias { background: #fff; border-radius: 8px; padding: 50px 40px; max-width: 500px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,.1); }
    .gracias h1 { color: #7ab800; font-size: 28px; margin-bottom: 16px; }
    .gracias p { font-size: 16px; line-height: 1.6; color: #555; margin-bottom: 24px; }
    .gracias a { display: inline-block; background: #7ab800; color: #fff; padding: 14px 40px; border-radius: 6px; font-weight: 700; text-decoration: none; text-transform: uppercase; font-size: 14px; }
    .gracias a:hover { background: #6a9f00; }
  </style>
  <!-- GTM -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-W2X38TWS');</script>
</head>
<body>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W2X38TWS" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<div class="gracias">
<?php if ($enviado): ?>
  <h1>¡Gracias por tu consulta!</h1>
  <p>Recibimos tu mensaje correctamente. Nos vamos a comunicar con vos a la brevedad.</p>
<?php else: ?>
  <h1>Hubo un problema</h1>
  <p>No pudimos enviar tu mensaje. Por favor intentá nuevamente o escribinos por WhatsApp.</p>
<?php endif; ?>
  <a href="/">VOLVER AL INICIO</a>
</div>
<script>
  if(window.dataLayer) window.dataLayer.push({event:'form_thank_you', producto:'<?php echo addslashes($producto); ?>'});
</script>
</body>
</html>
