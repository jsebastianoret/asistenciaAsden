<?php include 'includes/session.php'; ?>
<?php include 'includes/header-admin.php'; ?>
<body class="hold-transition skin-purple-light sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Unidad de Negocio
      </h1>
      <ol class="breadcrumb">
        <li><a href="../admin/home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Unidad de Negocio</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i>¡Proceso Exitoso!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">

      <?php 
        $gestionAsistencia = $permisoUnidad['actualizar'];
        $gestionAsistencia2 = $permisoUnidad['eliminar'] ;
        $gestionAsistencia3 = $permisoUnidad['crear'];
        $gestionAsistencia4 = $permisoUnidad['leer'];

        if ($gestionAsistencia4 == "No") {
          echo '<script>window.location.replace("home.php");</script>';
          exit;
        }
      ?>

        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">

            <?php
              if ($gestionAsistencia3 == "Sí") {
                echo '<a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>';
              }
            ?>   
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Área</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * FROM negocio";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          <td>".$row['nombre_negocio']."</td>
                          <td>";
                          if ($gestionAsistencia == "Sí") {
                            echo "<button class='btn margin_btn btn-success btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Editar</button>";
                          }
                          if ($gestionAsistencia2 == "Sí") {
                            echo "<button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Eliminar</button>";
                          }
                          echo 
                          "</td>
                        </tr>
                      ";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/negocio_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'negocio_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#nego').val(response.id);
      $('#edit_title').val(response.nombre_negocio);
      $('#edit_rate').val(response.rate);
      $('#del_nego').val(response.id);
      $('#del_negocio').html(response.nombre_negocio);
    }
  });
}
</script>
</body>
</html>
