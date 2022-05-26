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
  $update_status_sql = "update users set status='$status' where user_id='$id'";
  mysqli_query($conn, $update_status_sql);
}
if ($type == 'delete') {
  $id = check_input($conn, $_GET['id']);
  $delete_sql = "delete from users where user_id='$id'";
  mysqli_query($conn, $delete_sql);
 }
}
?>
<div class="page-wrapper">
<div class="content container-fluid">

<div class="page-header">
<div class="row">
<div class="col-12">
<h3 class="page-title">Welcome Admin!</h3>
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
<th>Name</th>
<th>Email</th>
<th>Number</th>
<th>Update</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php 
$get_users=getUsers($conn);
$serial_num=1;
foreach($get_users as $user_list){
  $update_date = date("d-m-Y",strtotime($user_list['update_date']));
  $new_date = date("d F Y",strtotime($update_date));
?>  
<tr>
<td><?=$serial_num?></td>
<td>
<a href="javascript:void(0)">
<img class="rounded service-img mr-1" src="../assets/images/userimage/<?=$user_list['user_image']?>" alt=""> <?=$user_list['user_name']?>
</a>
</td>
<td><?=$user_list['user_email']?></td>
<td><?=$user_list['user_pnumber']?></td>
<td><?=$new_date?></td>
<td>
    <?php 
      if ($user_list['status'] == 1) {
         echo "<a href='?type=status&operation=deactive&id=".$user_list['user_id']."' class='btn btn-info'>Active</a>&nbsp;"; 
      }
      else{
        echo "<a href='?type=status&operation=active&id=".$user_list['user_id']."' class='btn btn-danger'>Deactive</a>&nbsp;"; 
      }
    ?>
        
</td>
<td>
<a href="javascript:void(0)" class="btn btn-sm bg-info-light">
<i class="far fa-eye mr-1"></i> View
</a>
<a href="?type=delete&id=<?=$user_list['user_id'];?>" class="btn btn-sm bg-danger-light mr-2"> <i class="far fa-trash-alt mr-1"></i> Delete</a>
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