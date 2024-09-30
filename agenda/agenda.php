<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../img/icon2.webp" type="image/x-icon">
    <script src="https://kit.fontawesome.com/48e0e5e260.js" crossorigin="anonymous"></script>
    <!-- Links PARA EL FULL CALENDAR -->
    <script src="js/jquery.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/fullcalendar.min.js"></script>
    <script src="js/es.js"></script>
    <script src="../js/script_ocar.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> <!-- boostrap para el calendario  -->
    <link rel="stylesheet" href="css/fullcalendar.min.css">
    <!-- links de js de boostrap -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <!-- Link para el clockpicker -->
    <script src="js/bootstrap-clockpicker.js"></script>
    <link rel="stylesheet" href="css/bootstrap-clockpicker.css">
    <link rel="stylesheet" href="../estilos/ads.scss?v=<?php echo filemtime('../estilos/ads.scss'); ?>">
    <title>Turnos</title>
</head>
<body>
    <div class="navbar">
        <figure class="volver_menu">
            <img class="img_navbar" src="../img/logo.webp" alt="Logo">
            <figcaption><p style="margin-top: 20px;">Menu</p></figcaption>
            <a href="../menu_princip.php"></a>
        </figure>
        <div class="wrapper">
            <div class="contenedor_cerrar">
                <?php
      session_start();
      if (isset($_SESSION['correo_activo'])) {
        // Obtener el nombre del administrador desde la base de datos
        require_once '../php/conexion.php';
        $email = $_SESSION['correo_activo'];
        $query = "SELECT nombre_adm FROM admin WHERE email_adm ='$email'";
        $result = mysqli_query($conexion, $query);
        if ($row = mysqli_fetch_assoc($result)) {
          echo '<span class="admin_nombre">Bienvenido, ' . $row['nombre_adm'] . '</span>';
        }
      }
    ?>
    <button onclick="cerrarSesion()" class="boton_cerrar" style= "margin-bottom: 20px;">Cerrar sesion </button>
      <div class="rombo-desplegable">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 268.832 268.832">
          <path d="M265.17 125.577l-80-80c-4.88-4.88-12.796-4.88-17.677 0-4.882 4.882-4.882 12.796 0 17.678l58.66 58.66H12.5c-6.903 0-12.5 5.598-12.5 12.5 0 6.903 5.597 12.5 12.5 12.5h213.654l-58.66 58.662c-4.88 4.882-4.88 12.796 0 17.678 2.44 2.44 5.64 3.66 8.84 3.66s6.398-1.22 8.84-3.66l79.997-80c4.883-4.882 4.883-12.796 0-17.678z"/>
        </svg>
      </div> 
    </div>
  </div>
</div>

    <!-- BODY -->
    <!-- <div class="container" style="background-color:#fff"> -->
        <div class="row">
            <div class="col"></div>
            <div class="col-7"><br><br>
                <div id="calendarioWeb"></div>
            </div>
            <div class="col"></div>
        </div>
    </div>
     
    <script>
        $(document).ready(function(){
            $('#calendarioWeb').fullCalendar({
                // CABEZA
                header:{
                    left:'today, prev,next', //boton hoy, antes y siguiente
                    center:'title', //Titulo
                    right:'month, agendaWeek, agendaDay' //boton mes, semana , dia , semana en modo lista y horas del dia
                },
                dayClick:function(date, jsEvent, view) { //FUNCION PARA PODER SELECCIONAR EL DIA
                    $('#btnAgregar').prop("disabled",false);
                    $('#btnModificar').prop("disabled",true);
                    $('#btnDelete').prop("disabled",true);

                    limpiar();
                    $('#txtFecha').val(date.format());
                    $("#modalEventos").modal();
                },
                events:'https://localhost/OCAR/agenda/mostrar.php',

                //EVENTO DEL CLICK PARA QUE MUESTRE EL TITULO Y LOS DATOS DE LOS EVENTOS
                eventClick:function(calEvent,jsEvent,view){

                    $('#btnAgregar').prop("disabled",true);
                    $('#btnModificar').prop("disabled",false);
                    $('#btnDelete').prop("disabled",false);
                    //Titulo h2
                    $('#TituloEvento').html(calEvent.title);

                    //Mostrar los datos en el imput de los eventos
                    $('#txtDescripcion').val(calEvent.descripcion);
                    $('#txtId').val(calEvent.id);
                    $('#txtTitulo').val(calEvent.title);
                    $('#txtColor').val(calEvent.color);

                    FechaHora = calEvent.start._i.split(" ");
                    $('#txtFecha').val(FechaHora[0]);
                    $('#txtHora').val(FechaHora[1]);

                    $("#modalEventos").modal();
                },
                editable:true,
                eventDrop:function(calEvent){
                    $('#txtId').val(calEvent.id);
                    $('#txtTitulo').val(calEvent.title);
                    $('#txtColor').val(calEvent.color);
                    $('#txtDescripcion').val(calEvent.descripcion);

                    var fechaHora=calEvent.start.format().split("T");
                    $('#txtFecha').val(fechaHora[0]);
                    $('#txtHora').val(fechaHora[1]);
                    recolectar();
                    Enviar('modificar', NuevoEvento,true);
                }
            });
        });
    </script>

    <!-- Modal para agregar,modificar, eliminar-->
    <div class="modal fade" id="modalEventos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="TituloEvento"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            
            <input type="hidden" id="txtId" name="txtID">
            <input type="hidden" id="txtFecha" name="txtFecha" /><br/>

            <div class="form-row">
                <div class="form-group col-md-8">
                    <label>Titulo:</label>
                    <input type="text" id="txtTitulo" class="form-control" placeholder="Titulo del evento"/>              
                </div>
                <div class="form-group col-md-4">
                    <label>Hora de evento:</label>

                    <div class="input-group clockpicker" data-autoclose="true">

                        <input type="text" id="txtHora" value="15:30" class="form-control"/>

                    </div>

                </div>
            </div>

            <div class="form-group">
                <label>Descripcion:</label><br>
                <textarea id="txtDescripcion" rows="3" class="form_control"></textarea>
            </div>

             <div class="form-group">
                <label>Color:</label>
                <input type="color" id="txtColor" value="#ff0000" class="form-control" style="height: 36px;"/>
                <input type="hidden" id="txtTextColor" value="#FFFFFF" />
             </div>
        </div>

        <div class="modal-footer">
            <button type="button" id="btnAgregar" class="btn btn-success" >Agregar</button>
            <button type="button" id="btnModificar" class="btn btn-success" >Modificar</button>
            <button type="button" id="btnDelete" class="btn btn-danger" >Borrar</button>
            <button type="button" id="" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>

    <script>
        var NuevoEvento;
        $('#btnAgregar').click(function(){
            recolectar();
            Enviar('agregar', NuevoEvento);
        });

        $('#btnDelete').click(function(){
            recolectar();
            Enviar('eliminar', NuevoEvento);
        });

        $('#btnModificar').click(function(){
            recolectar();
            Enviar('modificar', NuevoEvento);
        });

        function recolectar() {
            NuevoEvento = {
                id: $('#txtId').val(),
                title: $('#txtTitulo').val(),
                descripcion: $('#txtDescripcion').val(),
                color: $('#txtColor').val(),
                textColor: $('#txtTextColor').val(),
                start: $('#txtFecha').val()+" "+$('#txtHora').val(),
                end: $('#txtFecha').val()+" "+$('#txtHora').val()
            };
        }
        function Enviar(accion, objEvento,modal) {
            // console.log(objEvento);
            $.ajax({
                type:'POST',
                url:'mostrar.php?accion='+accion,
                data:objEvento,
                success:function(msg){
                    if (msg) {
                        $('#calendarioWeb').fullCalendar('refetchEvents');
                        if (!modal) {
                            $("#modalEventos").modal('toggle');
                        }       
                    }
                },
                error: function (xhr, status, error) {
                    alert("hay un error");
                    console.error("Error en la solicitud AJAX:", error);
                }
            });
        }
        $('.clockpicker').clockpicker();

        function limpiar(){
            $('#txtId').val(' ');
            $('#txtTitulo').val(' ');
            $('#txtColor').val(' ');
            $('#txtDescripcion').val(' ');
        }
    </script>

</body>
</html>