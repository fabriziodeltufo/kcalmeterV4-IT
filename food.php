<!--
WebApp Code Name : kcalmeter
Date: 14-11-2019
Author : Fabrizio Del Tufo
Module : food.php
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
               <a class="nav-link active" href="food.php">Alimenti</a>
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








<!-- richiamo la cancella x verificare se e' stato premuto il bottone CANCELLA
se si , cancella il record e poi esegue la lista alimenti -->
<?php cancella_rec("alimenti"); ?>



<!-- PAGE CONTENT - FOOD LIST -->


<!-- TITOLO PAGINA -->
      <div>
          <h2 class="text-center tit">LISTA ALIMENTI</h2>
          <p class="text-center">Inserisci un nuovo alimento. Mantieni la tua lista aggiornata.</br>
          <b>Suggerimento : </b>Questa lista alimenti sara' di riferimento per i tuoi pasti giornalieri.</p>
          <hr>
          <p><b>* Campi Richiesti.</b></p>
    </div>


<!-- FORM INPUT RECORD ALIMENTI -->

<div class="container-fluid text-center">

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <div class="row d-flex justify-content-center">

                <!-- COLONNA -->
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="gruppo">* GRUPPO ALIMENTI</label>
                    <input value="<?php echo($_GET['gruppo']);?>" type="text" name="gruppo" class="form-control">
                  </div>
                </div>


                <!-- COLONNA -->
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="alimento">* ALIMENTO</label>
                    <input value="<?php echo($_GET['alimento']);?>" type="text" name="alimento" class="form-control">
                  </div>
                </div>

                <!-- COLONNA -->
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="calorie">* KCALs (100 gr)</label>
                    <input  value="<?php echo($_GET['calorie']);?>" type="text" name="calorie" class="form-control">
                  </div>
                </div>



                <!-- COLONNA -->
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="dose_porzione_gr">* PORZIONE (gr)</label>
                    <input  value="<?php echo($_GET['dose_porzione_gr']);?>" type="text" name="dose_porzione_gr" class="form-control">
                  </div>
                </div>


                <!-- COLONNA -->
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="kcal_dose_porzione">KCALs x PORZIONE</label>
                    <input READONLY value="<?php echo($_GET['kcal_dose_porzione']);?>" type="text" name="kcal_dose_porzione" class="bg-secondary text-light form-control">
                  </div>
                </div>


                <!-- COLONNA -->
                <div class="col-sm-10">
                  <div class="form-group">
                    <label for="note">NOTE</label>
                    <input value="<?php echo($_GET['note']);?>" type="text" name="note" class="form-control">
                  </div>
                </div>

                <!-- COLONNA NASCOSTA ID_REC-->
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="gruppo"></label>
                    <input HIDDEN READONLY value="<?php echo($_GET['modifica_id']);?>" type="text" name="id_rec" class="form-control">
                  </div>
                </div>

    </div>

    <div class="row d-flex justify-content-center">

      <div class="form-group text-center">
      <!-- INSERT / UPDATE // DEFAULT LIST // DELETE LIST BUTTONS -->
        <input type="submit" name="aggiungi" value="Inserisci / Aggiorna" class="btn btn-success btn-lg">
        <input type="submit" name="default" value="Lista Default" class="btn btn-primary btn-lg">
        <input type="submit" name="delete" value="Cancella Lista" class="btn btn-danger btn-lg">

      </div>

</form>

</div>


<!-- DEBUGGER CMD <?php echo "modifica id : " . $_GET['modifica_id'] ; ?> -->

</div>

<?php aggiungiAlimento(); ?>


<hr>
<br>



          <!-- LISTA ALIMENTI + BOTTONE CANCELLA SU OGNI RECORD , FORM INTERCETTA SE PREMUTO BTN CANCELLA
        nella action la variabile $SERVER ricarica la stessa pagina food.php

        Se CANCELLA non e' stato premuto esegue lista_alimenti()
        Se CANCELLA e' stato premuto , ricarica food.php dopo aver cancellato da DB il record dell alimento
        selezionato da Cancella

          <form action="food.php" method="get" >        -->

          <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >


          <div class="table-responsive-sm">

<!-- call alla fx che esegue la SELECT su DB fornendo dati + bottone CANCELLA-->
            <?php lista_alimenti('ALI', 'food.php');?> <!-- LIS = lista -->


            <div class="text-center bg-white text-dark">
              Data : <?php echo date('d-n-Y'); ?> | <?php echo "Alimenti in lista : " . $row_count; ?>
            </div>

          </div>

        </form>




<!-- FOOTER -->
<?php include FRONT_END . DS . 'footer.php'; ?>
