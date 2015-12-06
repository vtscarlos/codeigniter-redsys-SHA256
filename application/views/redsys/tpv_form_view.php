<html lang="es">
<head>

</head>
  <body>
    <form name="frm" id="frm" action="https://sis.redsys.es/sis/realizarPago" method="POST">
      <input type="hidden" name="Ds_SignatureVersion" value="<?php echo $version; ?>"/>
      <input type="hidden" name="Ds_MerchantParameters" value="<?php echo $params; ?>"/>
      <input type="hidden" name="Ds_Signature" value="<?php echo $signature; ?>"/>
    </form>
  </body>
  <script>document.frm.submit();</script>
</html>
