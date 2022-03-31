<?php
   session_start();
   if (isset($_SESSION['type']) && isset($_SESSION['email'])) {
      if($_SESSION['type'] == 'enseignant'){

      }else{
         header('Location: login.php');
      }
   }else{
      header('Location: login.php');
   }

?>

<?php  include './header.php' ?>

<?php include 'layouts/navbarEnseignant.php'; ?>

<div class="container">

   <h1>bienvenu</h1>

</div>
<?php  include './footer.php' ?>