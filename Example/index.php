
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">

  <head>

      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-sacle=1.0">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>cltco-form</title>
        <script src="http://jqueryvalidation.org/files/lib/jquery.js"></script>
  	    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>

        <link rel="stylesheet" href="./CSS/ultraligero.css">
        <script src="js/functions.js"></script>

  </head>

  <body>

    <form id="suscribe">

      <input type="email" placeholder="E-mail:" name="suscribe[E-mail]" id="suscribe_mail" from="suscribe" required><br>
      
      
      <input type="submit" id="suscribe_submit" value = "Enviar" from="suscribe"/>
    </form>
      

    <br><hr><br>
      

    <form id="contacto">

      <input type="text" placeholder="Número:" name="contacto[Número]" id="contacto_numero" from="contacto" required><br>
      


      <input type="text" placeholder="Nombre(s) y Apellidos:" name="contacto[Nombre(s) y Apellidos]" id="contacto_nombre" from="contacto" required><br>
      

      <input type="text" placeholder="E-mail:" name="contacto[E-mail]" id="contacto_mail" from="contacto" required><br>
      
      <input type="submit" id="contacto_submit" value = "Enviar" from="contacto"/>
    </form>

  </body>

</html>