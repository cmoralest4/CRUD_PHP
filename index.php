<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  </head>
  <body>
      <h1>Formulario Empleados</h1>
      <div class = "container">
      <form class = "d-flex" action = "crud_empleado.php" method = "post">
        <div class = "col">
        <div class="mb-3">
            <label for="lbl_id" class="form-label"><b>ID</b></label>
            <input type="text" name="txt_id" id="txt_id" class="form-control" value = "0" readonly>
        </div>

      <div class="mb-3">
            <label for="lbl_codigo" class="form-label"><b>Codigo</b></label>
            <input type="text" name="txt_codigo" id="txt_codigo" class="form-control" placeholder="Codigo: E001" required>
        </div>
        <div class="mb-3">
            <label for="lbl_nombres" class="form-label"><b>Nombres</b></label>
            <input type="text" name="txt_nombres" id="txt_nombres" class="form-control" placeholder="Nombre1 Nombre2" required>
        </div>
        <div class="mb-3">
            <label for="lbl_apellidos" class="form-label"><b>Apellidos</b></label>
            <input type="text" name="txt_apellidos" id="txt_apellidos" class="form-control" placeholder="Apellido1 Apellido2" required>
        </div>
        <div class="mb-3">
            <label for="lbl_direccion" class="form-label"><b>Direccion</b></label>
            <input type="text" name="txt_direccion" id="txt_direccion" class="form-control" placeholder="#casa, Calle, Avenida" required>
        </div>
        <div class="mb-3">
            <label for="lbl_telefono" class="form-label"><b>Telefono</b></label>
            <input type="number" name="txt_telefono" id="txt_telefono" class="form-control" placeholder="55555555" required>
        </div>
        <div class="mb-3">
          <label for="lbl_puesto" class="form-label"><b>Puesto</b></label>
          <select class="form-select" name="drop_puesto" id="drop_puesto">
            <option value= 0>---- Puesto ----</option>
            <?php
            include("datos_conexion.php");
            $db_conexion = mysqli_connect($db_host, $db_usr, $db_pass, $db_nombre);
            $db_conexion ->real_query("Select id_puesto as id,puesto from db_empresa_2021.puestos;");
            $resultado = $db_conexion->use_result();
            while($fila = $resultado->fetch_assoc()){
              echo"<option value=".$fila['id'] .">".$fila['puesto']."</option>";

            }
            $db_conexion ->close();

            ?>

          </select>
        </div>
        <div class="mb-3">
            <label for="lbl_fn" class="form-label"><b>Fecha Nacimiento</b></label>
            <input type="date" name="txt_fn" id="txt_fn" class="form-control" placeholder="aaaa-mm-dd" required>
        </div>
        <div class="mb-3">
            <input type="submit" name="btn_agregar" id="btn_agregar" value ="Agregar" class="btn btn-primary">
            <input type="submit" name="btn_modificar" id="btn_modificar" value ="Modificar" class="btn btn-secondary">
            <input type="submit" name="btn_eliminar" id="btn_eliminar" value = "Eliminar" class="btn btn-danger">
        </div>
        </div>
</form>

<table class="table table-stripe table-inverse table-responsive">
  <thead class="thead-inverse|thead-default">
    <tr>
      <th>Codigo</th>
      <th>Nombres</th>
      <th>Apellidos</th>
      <th>Direccion</th>
      <th>Telefono</th>
      <th>Puesto</th>
      <th>Nacimiento</th>
    </tr>
    </thead>
    <tbody id = "tbl_empleados">
          <?php
            include("datos_conexion.php");
            $db_conexion = mysqli_connect($db_host, $db_usr, $db_pass, $db_nombre);
            $db_conexion ->real_query("Select e.id_empleado as id, e.codigo,e.nombres,e.apellidos,e.direccion,e.telefono,p.puesto,e.fecha_nacimiento,e.id_puesto from empleados as e inner join puestos as p on e.id_puesto=p.id_puesto;");
            $resultado = $db_conexion->use_result();
            while($fila = $resultado->fetch_assoc()){

              echo"<tr data-id=".$fila['id']." data-idp=".$fila['id_puesto'].">";
              echo"<td>". $fila['codigo'] ."</td>";
              echo"<td>". $fila['nombres'] ."</td>";
              echo"<td>". $fila['apellidos'] ."</td>";
              echo"<td>". $fila['direccion'] ."</td>";
              echo"<td>". $fila['telefono'] ."</td>";
              echo"<td>". $fila['puesto'] ."</td>";
              echo"<td>". $fila['fecha_nacimiento'] ."</td>";
              echo"</tr>";

            }

            $db_conexion ->close();

            ?>
    </tbody>
</table>


        </div>

        <?php

        if(isset($_POST["btn_agregar"])){
          include("datos_conexion.php");
          $db_conexion = mysqli_connect($db_host, $db_usr, $db_pass, $db_nombre);
          $txt_codigo = utf8_decode($_POST["txt_codigo"]);
          $txt_nombres = utf8_decode($_POST["txt_nombres"]);
          $txt_apellidos = utf8_decode($_POST["txt_apellidos"]);
          $txt_direccion = utf8_decode($_POST["txt_direccion"]);
          $txt_telefono = utf8_decode($_POST["txt_telefono"]);
          $drop_puesto = utf8_decode($_POST["drop_puesto"]);
          $txt_fn = utf8_decode($_POST["txt_fn"]);
          $sql = "INSERT INTO empleados (codigo,nombres,apellidos, direccion, telefono, fecha_nacimiento,id_puesto) VALUES('".$txt_codigo."','".$txt_nombres."','".$txt_apellidos."','".$txt_direccion."',".$txt_telefono.",'".$txt_fn."', ".$drop_puesto.");";

          if($db_conexion->query($sql)===true){
            $db_conexion->close();
            echo"exito";
            header("refresh:0");
          }else{
            echo"error" .$sql."<br>".$db_conexion->close();
          }

        }

        ?>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  
      <script>
        $("#tbl_empleados").on('click','tr td',function (e){
          var target, id, idp,codigo,nombres,apellidos,direccion,telefono,nacimiento;
          target = $(event.target);
          id = target.parent().data('id');
          idp = target.parent().data('idp');
          codigo = target.parent('tr').find("td").eq(0).html();
          nombres = target.parent('tr').find("td").eq(1).html();
          apellidos = target.parent('tr').find("td").eq(2).html();
          direccion = target.parent('tr').find("td").eq(3).html();
          telefono = target.parent('tr').find("td").eq(4).html();
          nacimiento = target.parent('tr').find("td").eq(6).html();
          $("#txt_id").val(id);
          $("#txt_codigo").val(codigo);
          $("#txt_nombres").val(nombres);
          $("#txt_apellidos").val(apellidos);
          $("#txt_direccion").val(direccion);
          $("#txt_telefono").val(telefono);
          $("#txt_fn").val(nacimiento);
          $("#drop_puesto").val(idp);




        });
  
      </script>
  
  </body>
</html>