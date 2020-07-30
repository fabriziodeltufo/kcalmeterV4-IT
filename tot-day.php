<!--
WebApp Code Name : kcalmeter
Date: 14-11-2019
Author : Fabrizio Del Tufo
Module : tot-day.php
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
               <a class="nav-link active" href="tot-day.php">Tot KCal Giorno</a>
             </li>

             <li class="nav-item">
               <a class="nav-link" href="backup.php">Backup</a>
             </li>

           </ul>
         </nav>

<!-- PAGE CONTENT TOT KCAL DAY -->


<!-- OBBIETTIVO CALORIE  -->
      <div>
          <h2 class="text-center tit">TOTALE KCAL DEL GIORNO</h2>

            <p class='text-center'>Inserisci il numero max di Kcal. (Calorie) per giorno come tuo obbiettivo da raggiungere.</br>
              <b>Suggerimento:</b> Cerca su Google per individuare il numero di calorie necessarie al tuo corpo.</br>
              <a target="_blank" href="http://www.caloriegiornaliere.com/"><b>CLICCA QUI</b></a> per un esempio di obbiettivo calorico in base ad eta' e peso.<p>
      </div>

<!-- FORM INPUT OBBIETTIVO CALORICO -->
<div class="container-width text-center">
          <form action="tot-day.php" method="post">
            <div class="row d-flex justify-content-center">
                <!-- COLONNA -->
                <div class="col-sm-3">
                  <div class="form-group stilefont">
                    <label for="gruppo">Inserisci Obbiettivo Calorico</label>
                    <input type="text" name="goal" class="form-control">
                  </div>
                </div>
            </div>

              <div class="row d-flex justify-content-center">
                            <!-- BOTTONE AGGIUNGI / RESET -->
                            <div class="form-group text-center">
                              <input type="submit" name="aggiungi" value="OK" class="btn btn-success btn-lg">
                              <!--<input type="reset" name="reset" value="[Reset]" class="btn btn-danger btn-lg">-->
                            </div>
              </div>
          </form>

  </div>

<!-- call all fx goal : prende il valore dalla form,
lo inserisce nella tabella totali (flag OBB) e lo mostra sotto il form -->
<?php goal(); ?>


<div class="container-width text-center">
  <div class="row d-flex justify-content-center">
    <div class="col-sm-3">
      <p class="text-center bg-secondary "><?php mostraOBB(); ?><p>
    </div>
  </div>
</div>


<!-- TOTALE CALORIE GIORNATA -->

<div class="container text-center">

        <!-- valore dinamico -->
        <?php ListaTotDay($goal); ?>

</div>



  <!-- FOOTER -->
  <?php include FRONT_END . '/footer.php'; ?>
