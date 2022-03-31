<?php
   session_start();
   if (isset($_SESSION['type']) && isset($_SESSION['email'])) {
      if($_SESSION['type'] == 'etudiant'){

      }else{
         header('Location: login.php');
      }
   }else{
      header('Location: login.php');
   }
?>

<?php  include './header.php' ?>

<?php include 'layouts/navbarEtudiant.php';?>

<div class="container">

   <h1 class="titre-center ">bonjour <strong><?php echo $_SESSION['nom'].' '.$_SESSION['prenom']?></strong></h1>
</div>



<?php  include './footer.php' ?>