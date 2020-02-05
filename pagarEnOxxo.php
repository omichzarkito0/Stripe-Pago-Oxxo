<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Pagar En Oxxo</title>

  <script type="text/javascript">
    if(!document.referrer){
      alert("No puedes acceder a este sitio directamente o actualizando la p&aacutegina");
      location.href = "https://kiitos.com.mx/"
    }
  </script>
  
</head>
<body>
  <script src="https://js.stripe.com/v3"></script>
  <script src='https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js'></script>

<?php
  $nombre = $_REQUEST['nombre'].' '.$_REQUEST["apellido"];
  $correo = $_REQUEST['correo'];
  $precio = $_REQUEST['precio'];
  $telefono = $_REQUEST['telefono'];
  $calle = $_REQUEST['calle'];
  $estado = $_REQUEST['estado'];
  $ciudad = $_REQUEST['ciudad'];
  $cp = $_REQUEST['cp'];
  $producto = $_REQUEST['producto'];
?>

<script type="text/javascript">
  var stripe = Stripe('pk_live_QuNuW1H1QSZkv6ESt7cddxRC');
  //var stripe = Stripe('pk_test_Zy5l3MbrU4TXOIFCPYHln5WD');
  var precio = <?php echo $precio; ?>;
  precio *= 100;
  var page = "";
  var NumberOxxo;
  
  function valiDate(x){
      if(x < 10){
        x = '0' + x;
      }
      return x;
  }
  
  var hoy = new Date();
  var dd = hoy.getDate();
  var mm = hoy.getMonth() + 1;
  var yyyy = hoy.getFullYear();
  var fechaCreacion = valiDate(dd) + " de " + valiDate(mm) + " del " + yyyy;

  function generateFecha(){
    document.getElementById("fechaCreacion").innerHTML = fechaCreacion;
  }

  stripe.createSource({
      type: 'oxxo',
      amount: precio,
      currency: 'mxn',
      metadata: {
        producto: '<?php echo $producto ;?>',
        direccion: '<?php echo $calle; ?>',
        estado: '<?php echo $estado; ?>',
        ciudad: '<?php echo $ciudad; ?>',
        cp: '<?php echo $cp; ?>',
      },
      owner: {
        name: '<?php echo $nombre; ?>',
        email: '<?php echo $correo; ?>',
        phone: '<?php echo $telefono; ?>'
      },
    }).then(function(result) {
        // handle result.error or result.source
          //alert("Success");
          //Instrucciones
          JsBarcode("#barcode", String(result.source.oxxo.number));
          //alert(String(result.source.oxxo.number));
          NumberOxxo = result.source.oxxo.number;

          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
          if(this.readyState == 4 && this.status == 200){
              var ans = this.responseText;
            }
          };
          xhttp.open("POST", "./StripePagoOxxo.php?nombre=<?php echo $nombre; ?>&correo=<?php echo $correo; ?>&precio=<?php echo $precio; ?>&fechaCreacion=" + fechaCreacion + "&numberOxxo=" + String(NumberOxxo + "&producto=<?php echo $producto;?>" + "&direccion=<?php echo $calle;?>" + "&estado=<?php echo $estado;?>" + "&ciudad=<?php echo $ciudad;?>" + "&cp=<?php echo $cp;?>" + "&telefono=<?php echo $telefono;?>"), true);
          xhttp.send();
      });

    function imprimir(){
      document.getElementById("btn-1").hidden = true;
      document.getElementById("btn-2").hidden = true;
      window.print();
      document.getElementById("btn-1").hidden = false;
      document.getElementById("btn-2").hidden = false;
    }

      alert("Cargando Documento de Compra, Por favor espere...");

</script>

      <style type='text/css'>

        .container { 
          padding: 20px; 
          font-family: sans-serif;
        }

        .containerChild {
          width: 100%;
          max-width: 1000px;
        }

        .imgContainer {
          display: flex;
          width: 95%;
          align-items: center;
          justify-content: space-between;
          margin-top: 20px;
        }

        .imgSize {
          display: block;
          width: 45%;
        }

        .divisor {
          width: 90%;
          height: 4px;
          background: gray;
          margin-top: 10px;
        }

        .date {
          font-weight: bold;
        }

        .instrucciones {
          display: flex;
          width: 100%;
          align-items: center;
          margin-bottom: 20px;
        }

        .bottonImprimir{
          padding: 20px 30px;
          outline: none;
          background: transparent;
          border-radius: 10px;
          border: 4px solid gray;
          color: gray;
          cursor: pointer;
        }

        .bottonImprimir:hover {
          background: gray;
          color: white;
        }      


        @media screen and (max-width: 600px){
          .instrucciones {
            flex-direction: column;
          }
        }  

      </style>


      <div class = 'container'>
        <div class = 'containerChild'>


          <center><button id='btn-1' class="bottonImprimir" onclick="imprimir();">Imprimir</button></center>

          <div class = 'imgContainer'>
            <img class = 'imgSize' src='https://stripe.com/img/docs/apms/oxxo.png'/>
            <img class = 'imgSize' src='https://kiitos.com.mx/wp-content/uploads/2020/01/Kiitos-logo.png' />
          </div>

          <center><div class = 'divisor'></div></center>

          <div style='width:100%;'>
            <p>Total a Pagar: <span class = 'date'>$<?php echo $precio; ?></span></p>
            <p>Fecha de Creaci&oacuten: <span class = 'date' id="fechaCreacion"></span>
            <p class = 'date' style='color: red;'>*3 dias despues de la fecha de creacion del documento, este dejara de ser aceptado en todas las tiendas OXXO del pais.</p>
          </div>

          <center><div class = 'divisor'></div></center>

          <div class = 'instrucciones'>

            <div style='display:block; padding-right:30px;'>
              <svg id='barcode' style='max-width:267px;min-width:267px;'></svg>
            </div>

            <div style='display:block: width:auto; color:gray;'>
              <p>Instrucciones:</p>
              <p>1.- Entregue la factura al cajero para que escanee el c&oacutedigo de barras.</p>
              <p>2.- Proporcione el pago en efectivo al cajero.</p>
              <p>3.- Una vez completado el pago, guarde el recibo de su pago para sus registros.</p>
              <p>4.- Para cualquier duda o aclaraci&oacuten, contacte al proveedor de los bienes o servicio.</p>
            </div>

          </div>


      <center><button id='btn-2' class="bottonImprimir" onclick="imprimir();">Imprimir</button></center>
      <script type="text/javascript">generateFecha();</script>

        </div>
      </div>

</body>
</html>
