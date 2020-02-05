<?php

  $nombre = $_REQUEST['nombre'];
  $destino = $_REQUEST['correo'];
  $precio = $_REQUEST['precio'];
  $fechaCreacion = $_REQUEST['fechaCreacion'];
  $numberOxxo = $_REQUEST['numberOxxo'];
  $producto = $_REQUEST['producto'];
  $direccion = $_REQUEST['direccion'];
  $estado = $_REQUEST['estado'];
  $ciudad = $_REQUEST['ciudad'];
  $cp = $_REQUEST['cp'];
  $telefono = $_REQUEST['telefono'];

            $ch = curl_init("https://hooks.zapier.com/hooks/catch/3106335/odoskiu/");
 
            //The JSON data.
            $jsonData = array(
                'nombre' => $nombre,
                'correo' => $destino,
                'precio' => $precio,
                'fechaCreacion' => $fechaCreacion,
                'numberOxxo' => $numberOxxo,
                'producto' => $producto,
                'direccion' => $direccion,
                'estado' => $estado,
                'ciudad' => $ciudad,
                'cp' => $cp,
                'telefono' => $telefono,
            );
 
            //Encode the array into JSON.
            $jsonDataEncoded = json_encode($jsonData);
 
            //Tell cURL that we want to send a POST request.
            curl_setopt($ch, CURLOPT_POST, 1);
 
            //Attach our encoded JSON string to the POST fields.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
 
            //Set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
 
            //Execute the request
            $result = curl_exec($ch);

            ?>
