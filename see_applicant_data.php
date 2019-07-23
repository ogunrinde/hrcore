<?php
 include "connection.php";
 session_start();
 if(!isset($_SESSION['id'])) header("Location: login.php");
 $msg = "";
 $q = "SELECT * FROM job_personal_information ORDER BY id DESC";
$res = mysqli_query($conn, $q);
 $month = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUNE', 'JULY', 'AUG','SEPT', 'OCT', 'NOV', 'DEC'];
 $year = [];
 $all_months = [];
 $day = [];
 $applicant = [];
 $users = [];
if(mysqli_num_rows($res) > 0){
   while($r = mysqli_fetch_assoc($res)) {
     $t = $r['date_created'];
     $applicant[] = $r;
     if(strpos($t,'/') !== false){
         $t =  (int)(trim(explode('/',$r['date_applied'])[1]));
         $all_months[] = $month[$t];
         $year[] = explode('/',$r['date_applied'])[0];
         $day[] = explode('/',$r['date_applied'])[2];
     }else if(strpos($t,'-') !== false){
         $t =  (int)(trim(explode('-',$r['date_applied'])[1]));
         $all_months[] = $month[$t];
         $year[] = explode('-',$r['date_applied'])[0];
         $day[] = explode('-',$r['date_applied'])[2];
     }
  }
     //print_r($year);
}
/* $q = "SELECT * FROM job_personal_information ORDER BY id DESC";
$res = mysqli_query($conn, $q);
if(mysqli_num_rows($res) > 0){
   while($r = mysqli_fetch_assoc($res)) {
     $users[] = $r;
  }
}*/
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ESS Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/solid.css" integrity="sha384-+0VIRx+yz1WBcCTXBkVQYIBVNEFH1eP6Zknm16roZCyeNg2maWEpk/l/KsyFKs7G" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/fontawesome.css" integrity="sha384-jLuaxTTBR42U2qJ/pm4JRouHkEDHkVqH0T1nyQXn1mZ7Snycpf6Rl25VBNthU4z0" crossorigin="anonymous">
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,600,700' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
  <link rel="stylesheet" type="text/css" href="css/dashboard.css">
  <link rel="stylesheet" href="css/view_leave.css">


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include "sidebar.php" ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include "top_nav.php" ?>
        <!-- End of Topbar -->

        <div class="container-fluid">
          <div class="card border-0 shadow mb-4">
            <div class="card-header border-0 py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Applicants</h6>
            </div>
            <div class="card-body">  
                <div class="row" id="ads">
                    <!-- Category Card -->
                    <?php for ($i = 0; $i < count($applicant); $i++) { ?>  
                    <div class="col-md-3">
                        <div class="card rounded getapplicant" id = 'card<?=$i?>' applicant_id = "<?=$applicant[$i]['user_id']?>">
                            <div class="card-image">
                                <!--span class="card-notify-badge" style="color: #858796;background-color: #fff;">Stage: <?=$leaves[$i]['stage']?> </span-->
                                <span class="card-notify-year"><span style="display: block;font-size: 20px;"> <?= $day[$i] ?></span><span style="display: block;font-size: 10px;"><?= $all_months[$i]?> <?=$year[$i]?></span></span>
                                <div class="text-center" style="padding: 10px;"><img src="images/doc.png" alt="..." class="rounded-circle" style="width: 100px;height: 100px;"></div>
                            </div>
                            <div class="card-image-overlay m-auto">
                                <div class="bg-danger" style="color: #fff;padding: 4px;font-size: 13px;border-radius: 2px;font-weight: 800;text-transform: capitalize;"></div>
                            </div>
                            <div class="card-body text-center">
                                <div class="ad-title m-auto" style="padding: 4px;color: #4e73df;">
                                    <?php  foreach ($users as $user) { ?>
                                      <?php if($user['user_id'] == $applicant[0]['user_id']){?>
                                        <p style="text-transform: uppercase;"><?=$user['firstname']?> <?=$user['surname']?></p>
                                      <?php } ?>  
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script type="text/javascript" src = "js/timeline.js"></script>
  <script type="text/javascript">
    $(".getapplicant").on('click', function(){
    let r = $("#"+this.id+"").attr('applicant_id');
    //alert(r);
    let code = btoa(r);
     window.location.href = "/ess/access_applicant_details.php/?applicant_id="+code+"";
  });
  </script>
</body>

</html>
