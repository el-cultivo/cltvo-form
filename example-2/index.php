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

    <br><br>
    <br>
    <br>
    <br><br>

    <!----------------------------------------- inicio form--------------------------------------------------------------------------------------->
    <form id="contact-form_JS">
      <div class="row">
        <input type="text" id="cont_nombre_JS" value="" placeholder="Nombre" name = "contact-form_JS[Nombre]" form = "contact-form_JS" required>
      </div>
      <div class="row">
        <div class="columns grande-6">
          <input type="text" id="cont_mail_JS" value=""  placeholder="E-mail" name = "contact-form_JS[E-mail]" form = "contact-form_JS" required >
        </div>
        <div class="columns grande-6">
          <input type="text" id="cont_telefono_JS" value="" placeholder="Teléfono" name = "contact-form_JS[Teléfono]" form = "contact-form_JS">
        </div>
      </div>
      <div class="row">
        <textarea rows="5" placeholder="Deja tu mensaje" value="" id="cont_mens_JS"  name = "contact-form_JS[Mensaje]" form = "contact-form_JS"> </textarea>
      </div>
      <div class="row">
        <div class="g-recaptcha" data-sitekey="6Lf8zQQTAAAAAHEuAajIZuEUIvUnZBH2FNizpMxM"></div>
      </div>
      <div class="row">
        <input type="submit" value="Enviar" id="contact_sub_JS" form = "contact-form_JS" >
      </div>

    </form>
    <!---------------------------------------- fin form--------------------------------------------------------------------------------------->
</body>

</html>
