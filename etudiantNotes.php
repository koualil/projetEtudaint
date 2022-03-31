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

<?php

   include './database/connection.php';

   $id_etudiant = $_SESSION['id_etudiant'];
   $id_classe = $_SESSION['id_classe'];

   $notesResultat = $conn->query("select m.nom, n.note 
                  from Matiere m LEFT JOIN Note n 
                  ON m.id_matiere = n.id_matiere 
                  AND m.id_classe = $id_classe
                  AND n.id_etudiant = $id_etudiant");



?>

<div class="container">


   <table border="1">
      <tr>
         <th>matiere</th>
         <th>note</th>
      </tr>
      <?php
      if ($notesResultat) {
         while($row = mysqli_fetch_assoc($notesResultat)){
            echo "<tr>
               <td>$row[nom]</td>
               <td>$row[note]</td>
            </tr>";
         }
      }
   ?>

   </table>

</div>

<?php  include './footer.php' ?>