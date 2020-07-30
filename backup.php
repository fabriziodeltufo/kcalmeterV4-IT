<!--
WebApp Code Name : kcalmeter
Date: 14-11-2019
Author : Fabrizio Del Tufo
Module : backup.php
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
               <a class="nav-link" href="home.php">Home</a>
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
               <a class="nav-link active" href="backup.php">Backup</a>
             </li>

           </ul>
         </nav>


<!-- PAGE CONTENT TOOLS -->

      <div>
          <h2 class="text-center tit">IMPORTA / ESPORTA LA LISTA ALIMENTI</h2>
          <p class='text-center'><b>Suggerimento:</b> Puoi scaricare / caricare la lista alimenti per salvarla in excel e personalizzarla.</p>
      </div>
<hr>
<br>
<!--  EXPORT -->
<?php include FRONT_END . DS . 'export.php'; ?>

<hr>
<br>
<!--  IMPORT -->
<?php include FRONT_END . DS . 'import.php'; ?>



<!-- FOOTER -->
<?php include FRONT_END . '/footer.php'; ?>
