<div class="footer">
    <div class="container">
         <div class="footer-wrapper d-flex flex-wrap justify-content-center align-items-center text-center">
            <p class="copyright" style="color: #000">Copyrights &copy; <span id="year"></span> Design & Developed By Ujjawal</p>
        </div>
    </div>
</div>
</div>  
</body>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/admin-login.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#myCarousel").carousel();
});
</script>
<script>
    document.getElementById("year").innerHTML = new Date().getFullYear();
</script> 
</html>