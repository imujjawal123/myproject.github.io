<?php 
include('admin_header.php'); 
include('sidebar.php');
?>
<div class="page-wrapper">
<div class="content container-fluid">
<div class="page-header">
<div class="row">
<div class="col-12">
<h3 class="page-title">General Settings</h3>
</div>
</div>
</div>

<ul class="nav nav-tabs menu-tabs">
<li class="nav-item active">
<a class="nav-link" href="settings.php">General Settings</a>
</li>
<li class="nav-item">
<a class="nav-link" href="about-details.php">About Details</a>
</li>
<li class="nav-item">
<a class="nav-link" href="social-media.php">Social Media</a>
</li>
</ul>
<div class="row">
<div class="col-xl-3 col-lg-4 col-md-4 settings-tab">
<div class="card">
<div class="card-body">
<div class="nav flex-column">
<a class="nav-link active" data-toggle="tab" href="#general">General</a>
<a class="nav-link" data-toggle="tab" href="#terms">Terms & Conditions</a>
<a class="nav-link mb-0" data-toggle="tab" href="#privacy">Privacy</a>
</div>
</div>
</div>
</div>
<div class="col-xl-9 col-lg-8 col-md-8">
<div class="card">
<div class="card-body p-0">
<div class="tab-content pt-0">

<div id="general" class="tab-pane active">
<div class="card mb-0">
<div class="card-header">
<h4 class="card-title">General Settings</h4>
<?php 
if (isset($_SESSION['success']) && $_SESSION['success'] !='') {
   echo '<div class="alert alert-success alert-dismissible">'.$_SESSION['success'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> </div>';   
   unset($_SESSION['success']);
} 
if (isset($_SESSION['error']) && $_SESSION['error'] !='') {
   echo '<div class="alert alert-danger alert-dismissible" style="color:#f50017">'.$_SESSION['error'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> </div>';    
   unset($_SESSION['error']);
}
$sql=mysqli_query($conn,"select * from general_info");
if (mysqli_num_rows($sql) != null) {
   while($row = mysqli_fetch_assoc($sql)){
       $info_id = $row['id'];
       $website_name = $row['website_name'];
       $contact_details = $row['contact_details'];
       $mobile_num1 = $row['mobile_num1'];
       $mobile_num2 = $row['mobile_num2'];
       $website_logo = $row['website_logo'];
       $website_favicon = $row['website_favicon'];
       
   }
}
?>
</div>
<div class="card-body">
<form method="POST" action="code.php" enctype="multipart/form-data"> 
<div class="form-group">
<input type="hidden" class="form-control" name="info_id" value="<?=$info_id?>">
</div> 
<div class="form-group">
<label>Website Name</label>
<input type="text" class="form-control" name="website_name" value="<?=$website_name?>">
</div>
<div class="form-group">
<label>Contact Details</label>
<input type="text" class="form-control" name="contact_details" value="<?=$contact_details?>">
</div>
<div class="form-group">
<label>Mobile Number1</label>
<input type="text" class="form-control" name="mobile_num1" value="<?=$mobile_num1?>">
</div>
<div class="form-group">
<label>Mobile Number2</label>
<input type="text" class="form-control" name="mobile_num2" value="<?=$mobile_num2?>">
</div>
<div class="form-group">
<label>Website Logo</label>
<div class="uploader">
<input type="file" class="form-control" name="website_logo">
</div>
<p class="form-text text-muted small mb-0">Recommended image size is <b>660px x 85px</b>
</p>
<img src="assets/img/<?=$website_logo?>" class="site-logo" alt="">
</div>
<div class="form-group">
<label>Favicon</label>
<div class="uploader">
<input type="file" class="form-control" name="website_favicon">
</div>
<p class="form-text text-muted small mb-0">Recommended image size is <b>16px x 16px</b> or <b>32px x 32px</b></p>
<p class="form-text text-muted small mb-1">Accepted formats: only png and ico</p>
<img src="assets/img/<?=$website_favicon?>" class="fav-icon" alt="">
</div>
<div class="pt-0">
<button class="btn btn-primary" type="submit" name="update_info">Save Changes</button>
</div>
</form>
</div>
</div>
</div>


<div id="push_notification" class="tab-pane">
<div class="card mb-0">
<div class="card-header">
<h4 class="card-title">Push Notification</h4>
</div>
<div class="card-body">
<div class="form-group">
<label>Firebase Server Key</label>
<input type="text" class="form-control">
</div>
<div class="form-group">
<label>APNS Key</label>
<input type="text" class="form-control">
</div>
</div>
</div>
</div>


<div id="terms" class="tab-pane">
<div class="card mb-0">
<div class="card-header">
<h4 class="card-title">Terms & Conditions</h4>
</div>
<div class="card-body">
<div class="form-group">
<label>Page Content</label>
<textarea class="form-control content-textarea" rows="4">Nunc placerat mi id nisi interdum mollis. Praesent pharetra, justo ut scelerisque the mattis, leo quam aliquet congue placerat mi id nisi interdum mollis. Praesent pharetra, justo ut scel erisque the mattis, leo quam aliquet congue justo ut scelerisque. Praesent pharetra, justo ut scelerisque the mattis, leo quam aliquet congue justo ut scelerisque.</textarea>
</div>
</div>
</div>
</div>


<div id="privacy" class="tab-pane pt-0">
<div class="card mb-0 shadow-none">
<div class="card-header">
<h4 class="card-title">Privacy</h4>
</div>
<div class="card-body">
<div class="form-group">
<label>Page Content</label>
<textarea class="form-control content-textarea" rows="4">Nunc placerat mi id nisi interdum mollis. Praesent pharetra, justo ut scelerisque the mattis, leo quam aliquet congue placerat mi id nisi interdum mollis. Praesent pharetra, justo ut scel erisque the mattis, leo quam aliquet congue justo ut scelerisque. Praesent pharetra, justo ut scelerisque the mattis, leo quam aliquet congue justo ut scelerisque.</textarea>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php include('admin_footer.php') ?>