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

   include './database/connection.php';


   if (isset($_POST['note']) AND isset($_POST['id_etudiant']) AND isset($_POST['id_note']) AND isset($_POST['id_matiere'])) {
      $id_note = $_POST['id_note'];
      $note = $_POST['note'];
      $id_etudiant = $_POST['id_etudiant'];
      $id_matiere = $_POST['id_matiere'];

      if ($note >= 0 AND $note <=20) {
         if (empty($id_note)) {
            $resultat = $conn->query("INSERT INTO Note (note, id_matiere, id_etudiant) 
                                      VALUES($note ,$id_matiere ,$id_etudiant)");
            if ($resultat) {
               echo "<script>alert('modification avec success.')</script>";
            }else{
               echo "<script>alert('modification avec echec.')</script>";
   
            }
         }else{
            $resultat=$conn->query("update Note set note=$note ,id_matiere=$id_matiere,id_etudiant=$id_etudiant
                                    where id_etudiant=$id_etudiant");
            if ($resultat) {
               echo "<script>alert('modification avec success Update.')</script>";
            }else{
               echo "<script>alert('modification avec echec Update.')</script>";
            } 
         }
      }else{
         echo "<script>alert('note invalide.')</script>";
      }
      

   }

?>

<?php  include './header.php' ?>
<?php include 'layouts/navbarEnseignant.php'; ?>

<!-- <div class="container"> -->
   <?php
   $id_enseignant = $_SESSION['id_enseignant'];

   $MatieresResultat = $conn->query("select m.id_matiere, m.nom , m.id_classe, c.nom as classeNom
                                       from Matiere m join classe c 
                                    ON m.id_enseignant = $id_enseignant AND m.id_classe = c.id_classe ");

   if ($MatieresResultat) {
      echo "<div class=classes__nav>";
      while ($row = mysqli_fetch_assoc($MatieresResultat)) {
         $id_classe=$row['id_classe'];
         // requete pour le nom de chaque class!

         $id_matiere = $row['id_matiere'];
         $nom_matiere = $row['nom'];
         // affichage chaque matiere
         echo "<div class=classes__item id='$id_matiere'>$nom_matiere ( $row[classeNom])</div>";
      }
      echo "</div>";
      $MatieresResultat->data_seek(0);
      while ($row = mysqli_fetch_assoc($MatieresResultat)) {
         $id_matiere = $row['id_matiere'];

         $notesResultat = $conn->query("select a.id_etudiant, a.id_matiere, a.id_classe, a.nom, a.prenom, n.note, n.id_note 
                                 from (select m.id_matiere, m.id_classe, e.id_etudiant, e.nom, e.prenom
                                       from Etudiant e JOIN Matiere m 
                                       ON m.id_classe = e.id_classe 
                                       AND m.id_matiere=$id_matiere) a 
                                 LEFT JOIN Note n 
                                 ON a.id_matiere = n.id_matiere 
                                 AND a.id_etudiant=n.id_etudiant");
         if ($notesResultat){
           
                     
             echo "<div class='margin hidden contenu' class-id='$id_matiere'>";
            
             echo "<h1>CLasse : $row[nom]  </h1>";
             echo "<table border='1'>
                  <tr>
                     
                      
                     <th>nom</th>
                     <th>prenom</th>
                     <th>note</th>
                     <th></th>
                  </tr>";
             while ($row2 = mysqli_fetch_assoc($notesResultat)) {
               echo "<tr>
                
                  <td>$row2[nom]</td>
                  <td>$row2[prenom]</td>
                  <form method='POST' action=''>
                     <input hidden type='number' value='$row2[id_note]' name='id_note'/>
                     <input hidden type='number' value='$row2[id_matiere]' name='id_matiere'/>
                     <input hidden type='number' value='$row2[id_etudiant]' name='id_etudiant'/>
                     <td><input type='number' value='$row2[note]' name='note'/></td>
                     
                     <td>
                       <div class=modifie>
                         <button id=btn1 type=button  onclick='ajouter()'>
                          <img class='h-6 w-6' src=./img/modifie.png>
                         </button>
                         <button   type='submit' value='' name='modifier'>
                         <img class='h-6 w-6' src=./img/modif.png>
                        </button>
                        </div>
                           
                     </td>
                  </form>
                </tr>";
             }
             echo '</table>';
             echo "</div>";
        
         }
      }
    
    
   }



?>

 
<?php  include './footer.php' ?>
<?php include './tailwindss.php' ?>