<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>


   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link
      href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
      rel="stylesheet">

   <link rel="stylesheet" href="../styles/main.css">
</head>

<body>
   <?php 
      include '../database/connection.php';
      // classe formulaire
      if (isset($_POST['nom']) && $_POST['submit'] == 'Ajouter Classe') {
         $nom = $_POST['nom'];

         $insertResultat = $conn->query("INSERT INTO Classe(nom) VALUES('$nom')");
         if (!$insertResultat) {
            echo "<script>alert('error!')</script>";
         }


      }

      // matiere formulaire
      if (isset($_POST['nom']) && isset($_POST['id_classe']) 
            && isset($_POST['id_enseignant']) &&  $_POST['submit'] == 'Ajouter Matiere') {
               
         $nom = $_POST['nom'];
         $id_classe = $_POST['id_classe'];
         $id_enseignant = $_POST['id_enseignant'];

         if (!empty($id_enseignant) && !empty($id_classe) && !empty($nom)) {
            try {
               $selectMatiere = $conn->query("SELECT nom FROM Matiere WHERE nom='$nom' AND id_classe = $id_classe");
            
               if (mysqli_num_rows($selectMatiere) === 0) {
                     $insertMatiere = $conn->query("INSERT INTO Matiere(nom, id_classe, id_enseignant) 
                                                   VALUES('$nom', $id_classe, $id_enseignant)");
               }else{
                  echo "<script>alert('le nom de matiere deja exist !')</script>";
               }

               header("Location: classes.php?id_classe=$id_classe");

            } catch (Exception $e) {
               echo "<script>alert('error!')</script>";
            } 
         }else{
            echo "<script>alert('form non valide!')</script>";

         }
      }

      // delete classe formulaire
      if (isset($_POST['id_classe']) && $_POST['submit'] == 'supprimer classe') {
         $id_classe = $_POST['id_classe'];

         $deleteClasse = $conn->query("DELETE FROM Classe WHERE id_classe = $id_classe");
         if (!$deleteClasse) {
            echo "<script>alert('error!')</script>";
         }
      }
      
      // supprimer matiere formulaire
      if (isset($_POST['id_matiere']) && $_POST['submit'] == 'supprimer matiere') {
         $id_matiere = $_POST['id_matiere'];

         $deleteMatiere = $conn->query("DELETE FROM Matiere WHERE id_matiere = $id_matiere");
         if (!$deleteMatiere) {
            echo "<script>alert('error!')</script>";
         }
      }
   ?>


   <?php
      $enseignantResutat = $conn->query("SELECT * FROM Enseignant");
      $classesResultat = $conn->query('SELECT * FROM Classe'); 
   ?>

   <!--- Navbar --->
   <div class="classes__nav">
      <div class="p-2">
         <form class="flex" action="" method="POST">
            <input class="form__input mr-2" type="text" name="nom" required>
            <button class="button__1" type="submit" name="submit" value="Ajouter Classe">
               ajouter
            </button>
         </form>
      </div>
      <ul class="classes__list">
         <?php
            while($row = mysqli_fetch_assoc($classesResultat)){
               echo "<div id='classe$row[id_classe]' class='classes__item'>$row[nom]</div>";
            }
         ?>
      </ul>
   </div>

   <main class="classe__container">
      <?php
         $classesResultat->data_seek(0);
         if ($classesResultat) {
            while($row = mysqli_fetch_assoc($classesResultat)){
              $id_classe = $row['id_classe'];
               echo "<div classe-id='classe$id_classe' class='hidden classe__content'>";
               echo "<h1 class='mb-8'>$row[nom]</h1>";
               
               // echo "<form method='POST' action=''>
               //    <input hidden type='number' name='id_classe' value='$id_classe'>
               //    <input type='submit' name='submit' value='supprimer classe'>
               // </form>";

               echo "<form class='mb-4 flex gap-2 flex-wrap' action='' method='POST'>
                  <input type='text' name='nom' required>
                  <input hidden type='number' name='id_classe' value='$id_classe'>
                  <select name='id_enseignant'>";
                     echo "<option></option>";
                        $enseignantResutat->data_seek(0);
                     if ($enseignantResutat) {
                        while ($enseignantRow = mysqli_fetch_assoc($enseignantResutat)) {
                           echo "<option value='$enseignantRow[id_enseignant]' >$enseignantRow[nom]</option>";
                        }
                     }
                  echo "</select>
                  <input class='button__1' type='submit' name='submit' value='Ajouter Matiere'>
               </form>";

               $MatiereResultat = $conn->query("SELECT * FROM Matiere WHERE id_classe = $id_classe");

               if ($MatiereResultat && mysqli_num_rows($MatiereResultat) > 0) {

                  echo "<table class='mb-8' border='1'>
                  <tr>
                     <th>id</th>
                     <th>matiere</th>
                     <th></th>
                  </tr>";

                  while($row2 = mysqli_fetch_assoc($MatiereResultat)){
                     $id_matiere = $row2['id_matiere'];
                     echo "<tr>
                              <th>$row2[id_matiere]</th>
                              <th>$row2[nom]</th>
                              <th>
                                 <form class='flex justify-center' method='POST' action=''>
                                    <input hidden type='number' name='id_matiere' value='$id_matiere'>
                                    <button type='submit' name='submit' value='supprimer matiere'>
                                       <img class='h-6 w-6' src='../assets/icons/delete.png' alt=''>
                                    </button>
                                 </form>
                              </th>
                           </tr>";
                  }
                  

                  echo "</table>";
                  
               }else{
                  echo "<h4>Pas des matieres</h4>";
               }



                  
               echo "</div>";
            }
         }
      ?>


   </main>

   <script>
   const classesButtons = document.querySelectorAll('.classes__item');
   const classesContent = document.querySelectorAll('.classe__content');

   function displayClasse(id_classe) {
      classesButtons.forEach((btn) => {
         if (btn.getAttribute('id') === id_classe) {
            btn.classList.add('active')
         } else {
            btn.classList.remove('active')
         }
      })

      classesContent.forEach(elem => {
         console.log(elem);
         if (elem.getAttribute('classe-id') == id_classe) {
            elem.classList.remove('hidden')
         } else {
            elem.classList.add('hidden')

         }
      })
   }


   classesButtons.forEach(button => {
      button.addEventListener('click', (e) => {
         classeId = e.target.id

         displayClasse(classeId)
      })
   })
   </script>

   <?php
            if (isset($_GET['id_classe'])) {
               $id_classe = "classe".$_GET['id_classe'];
               echo "<script>
                  displayClasse('$id_classe');
               </script>";
            }

   ?>
  <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>