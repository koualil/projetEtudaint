<?php

   session_start();
   if (isset($_SESSION['type']) && isset($_SESSION['email'])) {
      if($_SESSION['type'] == 'etudiant'){
         header('Location: etudiantPage.php');
      }else if($_SESSION['type'] == 'enseignant'){
         header('Location: enseignantPage.php');
      }
   }

   include './database/connection.php';

   $error = '';
   $errorEnseignant = '';

   if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['type'])) {
      $type = $_POST['type'];
      if ($type === "etudiant") {
         $result = $conn->query("select * from Etudiant WHERE email='$_POST[email]' and password='$_POST[password]'" );
         if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['type'] = 'etudiant';
            $_SESSION['id_etudiant'] = $row['id_etudiant'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['prenom'] = $row['prenom'];
            $_SESSION['image'] = $row['image'];
            $_SESSION['date_naissance'] = $row['date_naissance'];
            $_SESSION['id_classe'] = $row['id_classe'];
            header('Location: etudiantPage.php' );
         }else{
            $error="email ou password est incorrect!!";
         }

      } else {
         $result = $conn->query("select * from Enseignant WHERE email='$_POST[email]' and password='$_POST[password]'" );
         if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['type'] = 'enseignant';
            $_SESSION['id_enseignant'] = $row['id_enseignant'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['prenom'] = $row['prenom'];
            $_SESSION['image'] = $row['image'];
            $_SESSION['date_naissance'] = $row['date_naissance'];
            header('Location: enseignantPage.php' );
         }else{
            $error="email ou password est incorrect!!";
         }
      } 
   }


?>



<?php  include './header.php' ?>

<div class="main__container">


   <div class="forms">
      <div class="buttons__container">
         <button id="etudiant-button" class="etudiant__button active">etudiant</button>
         <button id="enseignant-button" class="enseignant__button">enseignant</button>
      </div>
      <?php
               if ($error != '') {
                  echo "<p class='form__error'>$error</p>";
               }
            ?>
      <div class="form__container" id="etudiant-form-container">
         <h1 class="titre-center ">etudiant</h1>
         <form class="etudiant__form" action="" method="POST">
            <p class='hidden form__error'></p>
            <input type="email" name="email" placeholder="email">
            <input type="password" name="password" placeholder="password">
            <input hidden type="text" name="type" value="etudiant">
            <button class="login__button">login</button>
         </form>
      </div>
      <div class="form__container hidden" id="enseignant-form-container">
         <h1 class="titre-center">enseignant</h1>
         <form class="enseignant__form" action="" method="POST">

            <input type="email" name="email" placeholder="email">
            <input type="password" name="password" placeholder="password">
            <input hidden type="text" name="type" value="enseignant">
            <button class="login__button">login</button>
         </form>
      </div>
   </div>
</div>

<?php  include './footer.php' ?>


<script>
const etudiantButton = document.getElementById("etudiant-button");
const enseignantButton = document.getElementById("enseignant-button");

const enseignantFormCont = document.getElementById("enseignant-form-container");
const etudiantFormCont = document.getElementById("etudiant-form-container");

etudiantButton.addEventListener("click", () => {
   etudiantFormCont.classList.remove("hidden");
   enseignantFormCont.classList.add("hidden");

   etudiantButton.classList.add("active");
   enseignantButton.classList.remove("active");
});

enseignantButton.addEventListener("click", () => {
   etudiantFormCont.classList.add("hidden");
   enseignantFormCont.classList.remove("hidden");

   etudiantButton.classList.remove("active");
   enseignantButton.classList.add("active");
});

/*

const etudiantForm = document.querySelector(".etudiant__form");
const etudiantFormBtn = document.querySelector(".etudiant__form button");
const formError = document.querySelector('.form__error')
etudiantForm.onsubmit = function(e) {
   e.preventDefault();
};

etudiantFormBtn.addEventListener("click", () => {
   var xhr = new XMLHttpRequest();
   const formData = new FormData(etudiantForm);

   console.log(formData.get("email"));

   xhr.open("POST", "api/login.php");
   xhr.onload = function(e) {
      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            let data = xhr.response;
            if (data === 'success') {
               location.href = "index.php";
            } else {
               formError.classList.remove('hidden')
               formError.innerHTML = data
            }
            console.log(data);
         }
      }
   };
   xhr.send(formData);
});

*/
</script>