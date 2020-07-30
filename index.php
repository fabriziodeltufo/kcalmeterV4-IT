<!--
WebApp Code Name : kcalmeter
Date: 14-11-2019
Author : Fabrizio Del Tufo
Module : index.php
Last Upd : 10 June 2020
-->

<!-- crea connessioneDB + path -->
<?php require_once 'config.php'; ?>

<!-- carica header image + menu -->
<?php include FRONT_END . DS . 'header.php'; ?>

<!-- carica le funzioni ma non le esegue fino a chiamata -->
<?php include FRONT_END . DS . 'functions.php'; ?>

<?php //session_start(); ?>
<?php //echo " Astro " . $_SESSION['username'] . " - ID : " . $_SESSION['iduser']  ;?>


<?php astro(); ?>


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
