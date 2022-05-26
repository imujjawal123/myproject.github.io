<?php 
include('admin_header.php'); 
include('sidebar.php');
if (isset($_GET['type']) && $_GET['type'] != '') {
$type = check_input($conn, $_GET['type']);

if ($type == 'status') {
  $operation = check_input($conn, $_GET['operation']);
  $id = check_input($conn, $_GET['id']);

  if ($operation == 'active') {
     $status = 1;
  }
  else{
     $status = 0;
  }
  $update_status_sql = "update service set ser_status='$status' where ser_id='$id'";
  mysqli_query($conn, $update_status_sql);
}
if ($type == 'delete') {
  $id = check_input($conn, $_GET['id']);
  $delete_sql = "delete from service where ser_id='$id'";
  mysqli_query($conn, $delete_sql);
 }
}
?>

<div class="page-wrapper">
<div class="content container-fluid">

<div class="page-header">
<div class="row">
<div class="col">
<h3 class="page-title">Services</h3>
</div>
<div class="col-auto text-right">
<a href="add-service.php" class="btn btn-primary add-button ml-3">
<i class="fas fa-plus"></i>
</a>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="card">
<?php 
if (isset($_SESSION['success']) && $_SESSION['success'] !='') {
   echo '<div class="alert alert-success alert-dismissible">'.$_SESSION['success'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> </div>';   
   unset($_SESSION['success']);
} 
if (isset($_SESSION['error']) && $_SESSION['error'] !='') {
   echo '<div class="alert alert-danger alert-dismissible" style="color:#f50017">'.$_SESSION['error'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> </div>';    
   unset($_SESSION['error']);
}
?>   
<div class="card-body">
<div class="table-responsive">
<table class="table table-hover table-center mb-0 datatable">
<thead>
<tr>
<th>#</th>
<th>Service</th>
<th>Location</th>
<th>Category</th>
<th>Amount</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php 
$get_service=getServices($conn,'','');
$serial_num=1;
foreach($get_service as $service_list){
  $ser_date = date("d-m-Y",strtotime($service_list['ser_added']));
  $new_date = date("d F Y",strtotime($ser_date));
?>  
<tr>
<td><?=$serial_num?></td>
<td>
<a href="javascript:void(0)">
<img class="rounded service-img mr-1" src="assets/img/services/<?=$service_list['ser_image']?>" alt=""> <?=$service_list['ser_title']?>
</a>
</td>
<td><?=$service_list['ser_location']?></td>
<td><?=$service_list['cat_name']?></td>
<td><?php echo "INR ".$service_list['ser_price']?></td>
<td><?=$new_date?></td>
<td>
    <?php 
      if ($service_list['ser_status'] == 1) {
         echo "<a href='./services.php?type=status&operation=deactive&id=".$service_list['ser_id']."' class='btn btn-info'>Active</a>&nbsp;"; 
      }
      else{
        echo "<a href='./services.php?type=status&operation=active&id=".$service_list['ser_id']."' class='btn btn-danger'>Deactive</a>&nbsp;"; 
      }
    ?>
        
</td>
<td>
<a href="javascript:void(0)" class="btn btn-sm bg-info-light">
<i class="far fa-eye mr-1"></i> View
</a>
<a href="edit-service.php?edit_id=<?=$service_list['ser_id']?>" class="btn btn-sm bg-success-light mr-2"> <i class="far fa-edit mr-1"></i> Edit</a>
<a href="?type=delete&id=<?=$service_list['ser_id'];?>" class="btn btn-sm bg-danger-light mr-2"> <i class="far fa-trash-alt mr-1"></i> Delete</a>
</td>
</tr>
<?php $serial_num++; } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php include('admin_footer.php') ?>