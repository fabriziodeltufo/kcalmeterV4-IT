<!--
WebApp Code Name : kcalmeter
Date: 14-11-2019
Author : Fabrizio Del Tufo
Module : home.php
Last Upd : 10 June 2020
-->

<!-- crea connessioneDB + path -->
<?php require_once 'config.php'; ?>

<!-- carica header image + menu -->
<?php include FRONT_END . DS . 'header.php'; ?>

<!-- carica le funzioni ma non le esegue fino a chiamata -->
<?php include FRONT_END . DS . 'functions.php'; ?>

<!-- LOGIN / SIGNUP CHECK -->
<?php check_iduser(); ?>
<?php astro(); ?>


<?php //session_start(); ?>
<?php //echo " Astro " . $_SESSION['username'] . " - ID : " . $_SESSION['iduser']  ;?>




<!-- =========================================== HEADER - MAIN MENU ============================================== -->

         <nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
           <ul class="navbar-nav">

             <li class="nav-item">
               <a class="nav-link active" href="home.php">Home</a>
             </li>

             <li class="nav-item">
               <a class="nav-link" href="food.php">Alimenti</a>
             </li>

             <li class="nav-item">
               <a class="nav-link" href="breakfast.php">Colazione</a>
             </li>

             <li class="nav-item">
               <a class="nav-link" href="snack-am.php">Snack Mattina</a>
             </li>

             <li class="nav-item">
               <a class="nav-link" href="lunch.php">Pranzo</a>
             </li>

             <li class="nav-item">
               <a class="nav-link" href="snack-pm.php">Snack Pomeriggio</a>
             </li>

             <li class="nav-item">
               <a class="nav-link" href="dinner.php">Cena</a>
             </li>

             <li class="nav-item">
               <a class="nav-link" href="tot-day.php">Tot KCal Giorno</a>
             </li>

             <li class="nav-item">
               <a class="nav-link" href="backup.php">Backup</a>
             </li>

           </ul>
         </nav>





<!-- HERO SECTION -->
<div class="hero">


<!-- BLOCK VIDEO TUTORIAL -->
      <div class="box-video">
        <h4 class="bg-primary">Video Tutorial.</h4>

        <div class="videoYT">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/gkwfQYFiYkg?rel=0" frameborder="0"
            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>

      </div>


      <!-- BLOCK INFO INSTRUCTIONS ======== -->
            <div class="box-info">
              <h4 class="bg-danger">Leggi le istruzioni prima della missione.</h4>
                <p><b>1 - ACCEDI / REGISTRATI : </b>Inserisci Nome Utente (Nickname / Nome di fantasia) e Password.</p>
                <p><b>2 - LISTA ALIMENTI : </b>Inserisci alimento e calorie come mostrato sulla etichetta prodotto. Lista predefinita disponibile.</p>
                <p><b>3 - PASTI : </b>Seleziona gli alimenti per la tua colazione, pranzo, cena etc. dalla tua lista alimenti.</p>
                <p><b>4 - TOTALE CALORIE DELLA GIORNATA : </b>Inserisci il tuo obbiettivo calorico. Controlla il totale delle calorie giornaliere che hai raggiunto.</p>
            <!--    <p><b>Repeat the entries daily to keep the calories ingested under control.
            To loose weight, set a daily goal that should not be exceeded.</b></p>  -->
            </div>

</div>
<!-- END HERO SECTION-->






<!-- carica footer -->
  <?php include FRONT_END . '/footer.php'; ?>
