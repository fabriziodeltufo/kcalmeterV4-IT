<!--
WebApp Code Name : kcalmeter
Date: 14-11-2019
Author : Fabrizio Del Tufo
Module : functions.php
Last Upd : 10 June 2020
-->

<?php



// +++++++++++++++++++++++++++++++ BTN UPLOAD +++++++++++++++++++++++++++++++++//

FUNCTION import(){

  GLOBAL $connessioneDB ;

  $id_user = $_SESSION['iduser'];

    if (isset($_POST['upload'])){

      $id_user = $_SESSION['iduser'] ;

        echo '<div class="table-responsive-sm"> ' ;
        echo ' <table class="text-center table table-striped table-hover table-condensed table-bordered table-sm"> ' ;
        echo ' <thead> ' ;
        echo ' <tr> ' ;
        echo ' <th>GRUPPO ALIMENTI</th> ' ;
        echo ' <th>ALIMENTO</th> ' ;
        echo ' <th>KCAL (100 gr)</th> ' ;
        echo ' <th>PORZIONE (gr)</th> ' ;
        echo ' <th>KCAL x PORZIONE</th> ' ;
        echo ' <th>NOTE</th> ' ;
        echo ' </tr> ' ;
        echo ' </thead> ' ;
        echo ' <br><br> ';
        echo ' <tbody> ';


// LEGGE IL FILE CSV --> CHE SI TROVA IN UN TEMP FILE DOPO CLICK BTN UPLOAD//

        $file_temp = fopen ( $_FILES['select']['tmp_name'] , "r" );
        while ( $row = fgetcsv ($file_temp) )
         {

            echo "<tr>";
            echo "<td>{$row['2']}</td>";
            echo "<td>{$row['3']}</td>";
            echo "<td>{$row['5']}</td>";
            echo "<td>{$row['6']}</td>";
            echo "<td>{$row['7']}</td>";
            echo "<td>{$row['8']}</td>";
            echo "</tr>";

// CARICA VARIABILI DEL RECORD PER OGNI RIGA DEL FILE CSV ED INSERT INTO TEMP TABLE //
            $gruppo = $row['2'] ;
            $alimento = $row['3'] ;
            $categoria = " " ;
            $calorie = $row['5'] ;
            $dose_porzione_gr = $row['6'] ;
            $kcal_dose_porzione = $row['7'] ;
            $note = $row['8'] ;

            // CARICA TEMP ALIMENTI X  UTENTE ATTIVO

            $sql = "INSERT INTO temp_alimenti (id_user, id_rec, gruppo, alimento, categoria, calorie, dose_porzione_gr, kcal_dose_porzione, note)
                    VALUES ('{$id_user}' , '0' , '{$gruppo}',  '{$alimento}' , '{$categoria}', '{$calorie}' ,'{$dose_porzione_gr}' ,
                    '{$kcal_dose_porzione}' , '{$note}' ) " ;

              //      echo $sql ;

            $risultato = mysqli_query($connessioneDB, $sql);
        //    conferma($risultato);

         } // end while

        fclose($file_temp);

        // FORM 2 DI CONFERMA CARICAMENTO FOOD LIST: YES / NO solo se lista visualizzata !!! //
                 echo '</tbody>';
                 echo '</table>' ;
                 echo '</div>' ;
                 echo '<br> ';

                 echo "<tr>";
                 echo '<div class="container-fluid text-center"> ' ;
                 echo '<h3>Confermi questa lista come NUOVA lista alimenti ?</h3>'  ;


                 echo '<form method="post" action=""> ' ;


                 echo '<div class="row d-flex justify-content-center"> ' ;

                 echo '<div class="form-group text-center"> ';

                 echo '<input type="submit" name="conferma" value="SI" class="btn btn-success btn-lg">' ;
                 echo ' ';

                 echo '<input type="submit" name="conferma" value="NO" class="btn btn-danger btn-lg">' ;


                 echo '</div> ' ;
                 echo '</div> ' ;

                 echo '</form>' ;

                 echo '</div> ' ;

                 echo "</tr>";
                 echo '<br> ';
                 echo '<br> ';



    } // isset UPLOAD

// RICHIESTA DI CONFERMA UPLOAD FOOD LIST IN DB //
    if (isset($_POST['conferma']))
    {

      $conferma = $_POST['conferma'];

      if ($conferma == "SI")
      {
        $id_user = $_SESSION['iduser'];

        $sql = "SELECT * FROM alimenti WHERE id_user = '$id_user' ";
        $risultato = mysqli_query($connessioneDB, $sql);
  //      echo $sql ;

    //    conferma($risultato);

        $rownum=mysqli_num_rows($risultato);

        if ($rownum > 0)
          {

            // DELETE alimenti WHERE id_user //
            $sql = "DELETE FROM alimenti WHERE id_user='$id_user' ";
            $risultato = mysqli_query($connessioneDB, $sql);
    //        echo $sql ;

    //        conferma($risultato);

          }

          // INSERT NEW FOOD LIST from temp_alimenti into alimenti //
              $sql = " INSERT INTO alimenti ( id_user, id_rec, gruppo, alimento, categoria, calorie, dose_porzione_gr, kcal_dose_porzione, note )
                       SELECT '{$id_user}' , '0' , gruppo, alimento, categoria , calorie, dose_porzione_gr, kcal_dose_porzione,note
                       FROM temp_alimenti
                       WHERE id_user = '$id_user' " ;

              $risultato = mysqli_query($connessioneDB, $sql);
        //      echo $sql ;

              conferma($risultato);

              // DELETE FROM temp_alimenti //
              $sql = "DELETE FROM temp_alimenti WHERE id_user='$id_user' ";
              $risultato = mysqli_query($connessioneDB, $sql);
        //      echo $sql ;

        //      conferma($risultato);

         } // $_POST conferma = YES

          else

          { // $_POST conferma = NO

            // DELETE FROM temp_alimenti //
            $sql = "DELETE FROM temp_alimenti WHERE id_user='$id_user' ";
            $risultato = mysqli_query($connessioneDB, $sql);

          msg_err("ATTENZIONE ! : OPERAZIONE ANNULLATA.");


          } // end test conferma


      } // isset $_POST conferma

} // END FX IMPORT






// ++++++++++++++++++++++++ BTN EXPORT +++++++++++++++++++++++++++++++++ //

FUNCTION export(){

  GLOBAL $connessioneDB ;




  if (isset($_POST['export'])){

    $id_user = $_SESSION['iduser'];


  if ( isset($id_user) ){


    $sql = "SELECT * FROM alimenti WHERE id_user='$id_user' ORDER BY gruppo, alimento ";
    $risultato = mysqli_query($connessioneDB, $sql);
    $rownum=mysqli_num_rows($risultato);

    // conferma($risultato);
    if ($rownum > 0){



      // scrivi riga x riga da array $risultato a file csv //
        $file = fopen("download/" . $id_user . "export.csv","w");
      //  fpassthru($file);

        foreach ($risultato as $line) {
          fputcsv($file, $line);
        }
        fclose($file);

        // conferma($risultato);
        msg_err("DATAS EXPORTED.");
        echo "<h2 class='text-center'><a href='download/{$id_user}export.csv'>> Salva nella cartella di download <</a></h2>" ;



    } else {
  //    var_dump($id_user);

      msg_err("ERRORE : NON CI SONO DATI DA ESPORTARE.");
    }

  } // isset
  } // end isset export //

} // END FX EXPORT //







// ===========================  GESTIONE LISTA ALIMENTI ==========================//

// ++++++ FX AGGIUNGI ALIMENTO - PAGINA ALIMENTI +++++++ //

FUNCTION aggiungiAlimento(){

  GLOBAL $connessioneDB;

  //  ++++++++++++++++++++  BTN DELETE LIST +++++++++++++++++++++++++++++++++++++ //
  //  ++++++++++++++++++++  BTN DELETE LIST +++++++++++++++++++++++++++++++++++++ //

  if (isset($_POST['delete'])){

  $id_user = $_SESSION['iduser'];
  $sql = "DELETE FROM alimenti WHERE id_user='$id_user'";
  $risultato = mysqli_query($connessioneDB, $sql);
  //conferma($risultato);
  }

  //  ++++++++++++++++++++  BTN DEFAULT LIST  +++++++++++++++++++++++++++++++++++++ //
  //  ++++++++++++++++++++  BTN DEFAULT LIST  +++++++++++++++++++++++++++++++++++++ //

  if (isset($_POST['default'])){


    $rownum=0;
    $id_user = $_SESSION['iduser'];
    $sql = " SELECT * FROM alimenti WHERE id_user='$id_user'";
    $risultato = mysqli_query($connessioneDB, $sql);
    $rownum=mysqli_num_rows($risultato);

  // LISTA GIA CARICATA X UTENTE NUOVO ?
  //$risultato = mysqli_query($id_user) ;
  if ($rownum > 0){

    //msg_red("LISTA GIA' CARICATA !!!");
    echo "<h6 class='bg-alert text-center'>LISTA GIA' CARICATA !</h6>" ;


  } else { // CARICA LISTA



  // CARICA LISTA ALIMENTI X  UTENTE ATTIVATO
    $query = "INSERT INTO alimenti (id_user, id_rec, gruppo, alimento, categoria, calorie, dose_porzione_gr, kcal_dose_porzione, note)
              SELECT '{$id_user}' , 0 , gruppo, alimento, categoria , calorie, dose_porzione_gr, kcal_dose_porzione,note
              FROM alimenti
              WHERE id_user = 0; " ;
      $risultato = mysqli_query($connessioneDB, $query);
          //conferma($risultato);

  }
  } // isset default


//  ++++++++++++++++++++  BTN INSERT / UPDATE  +++++++++++++++++++++++++++++++++++++ //

// INSERIMENTO MANUALE + CONTROLLO CAMPI VOID   //

if ( isset($_POST['aggiungi']) ){

// FIELDS WITH VALUE //
$id_user = $_SESSION['iduser'];
$id_rec = $_POST['id_rec'];
$gruppo = $_POST['gruppo'];
$alimento = $_POST['alimento'];
$categoria = $_POST['categoria'];
$calorie = $_POST['calorie'];
$dose_porzione_gr = $_POST['dose_porzione_gr'];
$kcal_dose_porzione = (($calorie/100) * $dose_porzione_gr) ;
$note = $_POST['note'];

// CHECK FIELDS - NO NULL/VOID //

if ( $gruppo == "" OR $alimento == "" OR $calorie==0 OR  $dose_porzione_gr==0 ) {

  msg_err("ERRORE : CAMPI RICHIESTI ! ");


} else {

if ($id_rec > 0) { // CASO UPDATE


$sql = " UPDATE alimenti
SET gruppo='{$gruppo}',
alimento='{$alimento}',
categoria='{$categoria}',
calorie='{$calorie}',
dose_porzione_gr='{$dose_porzione_gr}',
kcal_dose_porzione='{$kcal_dose_porzione}',
note='{$note}'
WHERE id_user='{$id_user}' AND id_rec='{$id_rec}' " ;

$risultato= mysqli_query($connessioneDB, $sql);
conferma($risultato);

} else {

//  echo "CASO INSERT " ;

  $id_rec = 0;
  $query = "INSERT INTO alimenti (id_user, id_rec, gruppo, alimento, categoria, calorie, dose_porzione_gr, kcal_dose_porzione, note)
  VALUES ('{$id_user}' , '{$id_rec}' , '{$gruppo}',  '{$alimento}' , '{$categoria}' , '{$calorie}' ,'{$dose_porzione_gr}' ,
    '{$kcal_dose_porzione}' , '{$note}' ) " ;

    $risultato = mysqli_query($connessioneDB, $query);
    conferma($risultato);
    // header('Location:index.php?alimenti');

} // IF id_rec >0
} // NO NULL / VOID FIELDS
} // is set AGGIUNGI
} // FINE FX





//  ++++ FX LISTA ALIMENTI() ++++++ //

FUNCTION lista_alimenti($TipoLista, $TP){

  GLOBAL $connessioneDB;
  GLOBAL $row_count;


  $id_user = $_SESSION['iduser'];

  if ( isset ($id_user) ){

  $sql = "SELECT * FROM alimenti WHERE id_user = '$id_user' ORDER BY gruppo, alimento" ;

  // creaz ARRAY contenente le SELECT *
  $mostra_alimenti = mysqli_query($connessioneDB, $sql);

  // estrae da ARRAY una riga alla volta
  $row_count = 0;
  $_testata = 0;

  while ($row = mysqli_fetch_array($mostra_alimenti)) {

    if ($TipoLista == 'ALI' ){

      $testata ++ ;
      if ($testata == 1){
        echo "<table class='table table-striped table-hover table-condensed table-bordered table-sm text-center'>" ;
        echo "<thead>" ;
        echo "<tr>" ;
        echo "<th>GRUPPO ALIMENTI </th>" ;
        echo "<th>ALIMENTO </th>" ;
        echo "<th>KCALs (100 gr) </th>" ;
        echo "<th>PORZIONE (gr) </th>" ;
        echo "<th>KCALs x PORZIONE </th>" ;
        echo "<th>NOTE </th>" ;
        echo "</tr>" ;
        echo "</thead>";
        echo "<tbody>" ;
      }

    echo "<tr>";
    echo "<td>{$row['gruppo']}</td>";
    echo "<td>{$row['alimento']}</td>";
    echo "<td>{$row['calorie']}</td>";
    echo "<td>{$row['dose_porzione_gr']}</td>";
    echo "<td>{$row['kcal_dose_porzione']}</td>";
    echo "<td>{$row['note']}</td>";
    echo "<td><a class='btn btn-warning' href='$link_php?modifica_id={$row['id_rec']}&gruppo={$row['gruppo']}&alimento={$row['alimento']}
    &calorie={$row['calorie']}&dose_porzione_gr={$row['dose_porzione_gr']}&kcal_dose_porzione={$row['kcal_dose_porzione']}
    &note={$row['note']}' role='button'>Modifica</a></td>" ;

    echo "<td><a class='btn btn-danger' href='$link_php?cancella_id={$row['id_rec']}' role='button'>Cancella</a></td>" ;
    echo "</tr>";


  } else { // caso DD = dropdown delle pagine colazione etc etc

    $testata ++ ;
    if ($testata == 1){
      echo "<table class='table table-striped table-hover table-condensed table-bordered table-sm text-center'>" ;
      echo "<thead>" ;
      echo "<tr>" ;
      echo "<th></th>" ;
      echo "<th>GRUPPO ALIMENTI </th>" ;
      echo "<th>ALIMENTO </th>" ;
      echo "<th>KCALs (100 gr) </th>" ;
      echo "<th>PORZIONE (gr) </th>" ;
      echo "<th>KCALs x PORZIONE </th>" ;
      echo "<th>NOTE </th>" ;
      echo "</tr>" ;
      echo "</thead>";
      echo "<tbody>" ;
    }

    echo "<tr>";
    echo "<td><a role='button' class='btn btn-secondary' href='$TP?id_rec={$row['id_rec']}
    &gruppo={$row['gruppo']}
    &alimento={$row['alimento']}
    &calorie={$row['calorie']}
    &dose_porzione_gr={$row['dose_porzione_gr']}
    &kcal_dose_porzione={$row['kcal_dose_porzione']}
    &note={$row['note']}' >Seleziona</a></td>" ;
    echo "<td>{$row['gruppo']}</td>";
    echo "<td>{$row['alimento']}</td>";
    echo "<td>{$row['calorie']}</td>";
    echo "<td>{$row['dose_porzione_gr']}</td>";
    echo "<td>{$row['kcal_dose_porzione']}</td>";
    echo "<td>{$row['note']}</td>";
    echo "</tr>";

  } // END IF $TipoLista

    $row_count ++ ;

}// END WHILE

echo "</tbody>" ;
echo "</table>" ;


} // END if isset

//else {echo "<h4 class='bg-alert text-center text-light'>CODICE UTENTE MANCANTE. CREA UN NUOVO UTENTE</h4>" ;}
else {echo "<h6 class='bg-alert text-center text-light'>CODICE UTENTE NON PRESENTE. REGISTRA UN NUOVO UTENTE.</h6>" ;}


} // END FX



// +++++++  FX - CANCELLA RECORD USANDO ID_REC. ARG:TABLENAME +++++++ //
// CANCELLA DALLA TABLE: ALIMENTI, PASTI. RECORD SELEZIONATO CON BTN CANCELLA. ARG: ID_REC //

FUNCTION cancella_rec($table){
  GLOBAL $connessioneDB;

// CASO 1 -- premuto CANCELLA //

  if(isset($_GET['cancella_id'])){

    $id_user = $_SESSION['iduser'];
    $id_rec = $_GET['cancella_id'];
    $sql = "DELETE FROM $table WHERE id_user = '$id_user' AND id_rec = $id_rec ";
    $risultato = mysqli_query($connessioneDB, $sql);
    // conferma($risultato);
    // echo " id_rec cancellato : " . $id_rec;

  } // IF  isset $_GET = cancella

} // END FX



/// ==============================  GESTIONE DEI PASTI =================================== ///
// ++++++++++++ fx aggiungi alimenti ai pasti / configurazione del pasto ++++++++++++++++++ //
// PAGINE : COLAZIONE, SNACK MATTINA, PRANZO, SNACK POMERIGGIO, CENA //

FUNCTION aggiungiAlimentoPasto($TP){

  GLOBAL $connessioneDB;
  GLOBAL $data;


if(isset($_POST['aggiungi'])){

  $id_user = $_SESSION['iduser'];
  $id_rec = $_POST['id_rec'];
  $gruppo = $_POST['gruppo'];
  $alimento = $_POST['alimento'];
  $categoria = $_POST['categoria'];//
  $calorie = $_POST['calorie'];
  $dose_porzione_gr = $_POST['dose_porzione_gr'];
  $kcal_dose_porzione = ($calorie/100) * $dose_porzione_gr;
  $note = $_POST['note'];
  $data = date('Y-n-d');
  //$data = date('d-n-Y');
  $tipo_pasto = $TP;



  if ($id_rec > 0) {

    // UPDATE //

  $sql = " UPDATE pasti
  SET gruppo='{$gruppo}',
  alimento='{$alimento}',
  categoria='{$categoria}' ,
  calorie='{$calorie}',
  dose_porzione_gr='{$dose_porzione_gr}',
  kcal_dose_porzione='{$kcal_dose_porzione}',
  note='{$note}'
  WHERE id_user='{$id_user}' AND id_rec='{$id_rec}' " ;

  $risultato= mysqli_query($connessioneDB, $sql);
  //conferma($risultato);

  } else {

// INSERT //
  $id_rec = 0;

// echo "Data : " . $data ;
$sql = "INSERT INTO pasti (id_user , id_rec, gruppo, alimento, categoria, calorie, dose_porzione_gr, kcal_dose_porzione, note, data, tipo_pasto)
VALUES ( '{$id_user}' , '{$id_rec}' , '{$gruppo}',  '{$alimento}' , '{$categoria}' , '{$calorie}' ,'{$dose_porzione_gr}' ,
  '{$kcal_dose_porzione}' , '{$note}' , '{$data}', '{$tipo_pasto}') " ;

  $risultato = mysqli_query($connessioneDB, $sql);
  //conferma($risultato);


} //  else - if ($id_rec > 0) {

} // if(isset($_POST['aggiungi'])){

} // END FX




//  +++++++++++ LISTA ALIMENTI PASTI() ++++++++++++++ //

FUNCTION lista_ali_pasti($TP){

  GLOBAL $connessioneDB;
  GLOBAL $row_count;
  GLOBAL $sum_calorie;


  $id_user = $_SESSION['iduser'];


// DEBUG echo "variabile:" . $TP;

// verifica tipo pasto ///

if ($TP == "COL") {
  $link_php = "breakfast.php" ;
}

if ($TP == "SNA") {
  $link_php = "snack-am.php" ;
}
if ($TP == "PRA") {
  $link_php = "lunch.php" ;
}
if ($TP == "SNP") {
  $link_php = "snack-pm.php" ;
}
if ($TP == "CEN") {
  $link_php = "dinner.php" ;
}

$sql = " SELECT * FROM pasti WHERE id_user = '$id_user' AND tipo_pasto='$TP' ORDER BY gruppo, alimento";

// x DEBUGGARE:  echo " stringa select = " . $query;

  // creaz ARRAY contenente le SELECT *

  $mostra_alimenti_pasti = mysqli_query($connessioneDB, $sql);

  // estrae da ARRAY una riga alla volta
  $row_count = 0;
  $sum_calorie = 0;
  $testata = 0 ;



  while ($row = mysqli_fetch_array($mostra_alimenti_pasti)) {
    $testata ++ ;
    if ($testata == 1){
      echo "<thead>" ;
      echo "<tr>" ;
      echo "<th>GRUPPO ALIMENTI </th>" ;
      echo "<th>ALIMENTO </th>" ;
      echo "<th>KCALs (100 gr) </th>" ;
      echo "<th>PORZIONE (gr) </th>" ;
      echo "<th>KCALs x PORZIONE </th>" ;
      echo "<th>NOTE </th>" ;
      echo "</tr>" ;
      echo "</thead>";
      echo "<tbody>" ;
    }

    echo "<tr>";
    echo "<td>{$row['gruppo']}</td>";
    echo "<td>{$row['alimento']}</td>";
    echo "<td>{$row['calorie']}</td>";
    echo "<td>{$row['dose_porzione_gr']}</td>";
    echo "<td>{$row['kcal_dose_porzione']}</td>";
    echo "<td>{$row['note']}</td>";
    // echo '<td><button type="button" class="btn btn-primary">Cancella</button</td>';
    echo "<td><a role='button' class='btn btn-warning' href='$link_php?modifica_id={$row['id_rec']}&gruppo={$row['gruppo']}
    &alimento={$row['alimento']}&categoria={$row['categoria']}&calorie={$row['calorie']}
    &dose_porzione_gr={$row['dose_porzione_gr']}&kcal_dose_porzione={$row['kcal_dose_porzione']}
    &note={$row['note']}'>Modifica</a></td>" ;
    echo "<td><a role='button' class='btn btn-danger' href='$link_php?cancella_id={$row['id_rec']}' >Cancella</a></td>" ;

    echo "</tr>";

    // somma calorie //
    $sum_calorie = $sum_calorie + $row['kcal_dose_porzione'] ;

    // calcola numero alimenti
    $row_count ++;
  }

  echo "</tbody>" ;

}






/// ================================= GESTIONE PAGINA TOTALE CALORIE GIORNATA ======================== ///
// ++++++++++++++++++++++++++++++++++ fx goal / obbiettivo calorico da settare +++++++++++++++++++++++ //
//  fx x settare OBB, mostrarlo, mostrare totali giornata e aggiornare i totali parziali dei pasti //

FUNCTION goal(){
  GLOBAL $connessioneDB;

// se vuoi inserire nuovo OBB ,
  if(isset($_POST['aggiungi']) AND ($_POST['goal']) ){

    $id_user = $_SESSION['iduser'];
    $id_rec = 0;
    $data = date('Y-n-d');
    $limite =  $_POST['goal'];

// controlla se esiste gia record OBB //
    // echo "P1A - SELECT" ; // debug
    $sql = "SELECT * FROM totali WHERE id_user = '$id_user' AND tp = 'OBB' ";
    $risultato = mysqli_query($connessioneDB, $sql);
    // conferma($risultato);

    if ($risultato){ // SELECT IS TRUE
      // ha trovato OBB, quindi deve cancellare e poi reinserire quell nuovo ultimo digitato//
      // echo "P2 - DELETE" ; // debug
      $sql = "DELETE FROM totali WHERE id_user = '$id_user' AND tp = 'OBB'  ";
      $risultato = mysqli_query($connessioneDB, $sql);
      // conferma($risultato);
        if($risultato){ // DELETE IS TRUE //
          // ora inserisce nuovo OBB //
          // echo "P3 - INSERT" ; // debug
          $sql = " INSERT INTO totali (id_user, id_rec, data, tp, cal) VALUES ('{$id_user}' , '{$id_rec}' , '{$data}',  'OBB' , '{$limite}' ) ";
          $risultato = mysqli_query($connessioneDB, $sql);
          // conferma($stringa);
        }
    }

    else // SELECT IS FALSE , NO OBB in table
    {

    // inserisci obbiettivo calorico nella totali con flag speciale =  OBB //
    // echo "P4 - INSERT" ; // debug

    $sql = " INSERT INTO totali (id_user, id_rec, data, tp, cal) VALUES ('{$id_user}' , '{$id_rec}' , '{$data}',  'OBB' , '{$limite}' ) ";
    $risultato = mysqli_query($connessioneDB, $sql);
    // conferma($risultato);

  } // END SELECT x sapere se OBB e' presente la prima volta

} // END IF SET aggiungi

}  // END FX goal



// +++++++++++++++++++++++++++++ fx mostra obbiettivo +++++++++++++++++++++++++++ //

FUNCTION mostraOBB(){

  GLOBAL $connessioneDB;

  // STEP 1 - check se esiste OBB, se si mostralo.

  $id_user = $_SESSION['iduser'];
  $sql = "SELECT * FROM totali WHERE id_user = '$id_user' AND tp = 'OBB' ";
  $risultato = mysqli_query($connessioneDB, $sql);
  // conferma($risultato);

  // estrai da array il valore del limite OBBIETTIVO

  while ($row = mysqli_fetch_array($risultato)) {
    $limite = $row['cal'] ;
    echo "Goal Currently Set : " . $limite . " KCal";
  }
} // END FX




// +++++++++++++++++++++++++++++ lista totali della giornata ++++++++++++++++++++++++++//
// TABELLA TOTALI KCAL x GIORNATA //

FUNCTION listaTotDay() {

    GLOBAL $connessioneDB;
    GLOBAL $mostra_OBB;

// estrai OBB cal dalla totali che serve come rif x calcolo.
    $id_user = $_SESSION['iduser'];
    $sql = "SELECT cal FROM totali WHERE id_user = '$id_user' AND tp = 'OBB' ";
    $risultato = mysqli_query($connessioneDB, $sql);

    while ($row = mysqli_fetch_array($risultato)) {
      $limite = $row['cal'];
    }


// seleziona data, cal per ogni giorno dalla totali escludendo OBB record
    $sql = "SELECT data, SUM(cal) FROM totali WHERE id_user = '$id_user' AND tp != 'OBB' GROUP BY data";

    // creaz ARRAY contenente le SELECT *
    $risultato = mysqli_query($connessioneDB, $sql);

    // estrae da ARRAY una riga alla volta x avere data, somma delle cal a quella data e confronta con limite
    while ($row = mysqli_fetch_array($risultato)) {

      if (!isset ($testata)) {

        // PRINT HEADER //
          echo "<table class='table table-stripped table-hover table-condensed table-bordered'>";
          echo "<tr>" ;
          echo "<th>DATA</th>";
          echo "<th>TOTALE KCALs</th>";
          echo "<th>MISSIONE</th>";
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
          $testata = TRUE;
      }


// PRINT RECORDS ON 3 COL //
        echo "<tr>";
        echo "<td class='text-center'>{$row['data']}</td>";
        echo "<td class='text-center'>{$row['SUM(cal)']}</td>";


        // ALLARMI COLORATI + TEXT //

        if ($row['SUM(cal)'] < $limite) {
          echo "<td class='bg-success text-light text-center'>SUCCESSO !</td>";
        } else {
          echo "<td class='bg-alert text-light text-center'>FALLITA !</td>";
        }

      echo "</tr>";

    } // FINE WHILE

    echo "</tbody>";
    echo "</table>";

    if (isset($testata)) {

      // PRINT suggerimento  //
      echo "<br>";
      echo "<p><i style='color:white;''><b>Suggerimento :</b> Se superi il LIMITE, riduci le dosi, NON gli alimenti.<br>";
      echo "<b>Mantieni la tua dieta varia ed equilibrata.</b></i></p>";
      echo "<br>";
    }

    else {
      echo "<br>";
    }

  } // FINE FUNZIONE listaTotDay




// ++++++++++++++++++++ fx aggiorna tabella totali ++++++++++++++++++ //
// AGGIORNA TABELLA TOTALI  //

FUNCTION aggiornaTotali($TP){

  GLOBAL $connessioneDB;
  GLOBAL $sum_calorie;

  $id_user = $_SESSION['iduser'];
  $id_rec = 0;
  $data = date('Y-n-d');

// controlla se non c'e il record per il tipo_pasto ///

$sql = " SELECT * FROM totali WHERE id_user = '$id_user' AND data = '$data' AND tp = '$TP' " ;

$risultato = mysqli_query ($connessioneDB, $sql ) ;
$row = mysqli_fetch_array($risultato);

$id_rec = $row['id_rec'];
$data = $row['data'];
// var_dump($id);
// var_dump($data);

if (isset($id_rec)) {


    // aggiorna totale calorie x pasto ///
    $sql = " UPDATE totali SET cal = '$sum_calorie' WHERE id_user = '$id_user' AND id_rec = '$id_rec' AND data = '$data' AND tp = '$TP' ";
    $risultato = mysqli_query($connessioneDB, $sql);
    // conferma($risultato);



  } else {


    $id_rec = 0;
    $data = date('Y-n-d');


        // inserisci totale calorie x pasto  ////
        $sql = " INSERT INTO totali (id_user ,id_rec, data, tp, cal) VALUES ('{$id_user}' , '{$id_rec}' , '{$data}',  '{$TP}' , '{$sum_calorie}' ) ";
        $risultato = mysqli_query($connessioneDB, $sql);
        // conferma($risultato);

} // fine else


progressionBar();


} // fine funzione




function progressionBar(){

  GLOBAL $connessioneDB;


  $id_user = $_SESSION['iduser'];
  $data = date('Y-n-d');
  $sum_calorie = 0 ;
  $OBB = 0 ;
  $perceOBB = 0 ;

  // TROVA OBB IMPOSTATO x UTENTE ASSEGNATO //
  $sql = " SELECT cal FROM totali WHERE id_user='$id_user' AND tp='OBB'   ";
  $risultato = mysqli_query($connessioneDB, $sql);
  // conferma($risultato);

  while ($row = mysqli_fetch_array($risultato)){
    $OBB = $row['cal']; // restituisce OBB settato //
  };


// TROVA SOMMA CALORIE DEI PASTI x UTENTE ASSEGNATO x DATA ODIERNA //
$sql = " SELECT cal FROM totali WHERE id_user='$id_user' AND tp!='OBB' AND data='$data'  ";
$risultato = mysqli_query($connessioneDB, $sql);
// conferma($risultato);

while ($row = mysqli_fetch_array($risultato)){
  $sum_calorie = $sum_calorie + $row['cal'];
};


  //echo "OBB = " . $OBB ;
  $perceOBB = (($sum_calorie/$OBB)*100) ;
  $perceOBB = round($perceOBB, 2);


switch($perceOBB){



  case $perceOBB>100 :
  echo "<hr>" ;
    echo "<div class='block text-center bg-alert text-light'> ";
    echo "<progress class='inline-block' max='$OBB' value='$sum_calorie'></progress>" ;
    echo "<H4><span class='inline-block'>Sei a $perceOBB% del tuo obbiettivo. ($OBB Kcal)</span></H4>";
    echo "</div>";
    echo "<hr>" ;
    break;

  case $perceOBB>79 :
  echo "<hr>" ;
    echo "<div class='block text-center bg-danger text-light'> ";
    echo "<progress class='inline-block' max='$OBB' value='$sum_calorie'></progress>" ;
    echo "<H4><span class='inline-block'>Sei a $perceOBB% del tuo obbiettivo. ($OBB Kcal)</span></H4>";
    echo "</div>";
    echo "<hr>" ;
    break;

    case $perceOBB>49 :
    echo "<hr>" ;
    echo "<div class='block text-center text-dark bg-warning'> ";
    echo "<progress class='inline-block' max='$OBB' value='$sum_calorie'></progress>" ;
    echo "<H4><span class='inline-block'>Sei a $perceOBB% del tuo obbiettivo. ($OBB Kcal)</span></H4>";
    echo "</div>";
    echo "<hr>" ;
    break;

    default:
    echo "<hr>" ;
    echo "<div class='block text-center bg-success text-light'> ";
    echo "<progress class='inline-block' max='$OBB' value='$sum_calorie'></progress>" ;
    echo "<H4><span class='inline-block'>Sei a $perceOBB% del tuo obbiettivo. ($OBB Kcal)</span></H4>";
    echo "</div>";
    echo "<hr>" ;
    break;



} // switch
} // FX




// ======================================  EXTRA-COMMON FX  ============================================== //
// FUNZIONI MESSAGGI SUCCESS / ERROR //

//crea una funzione per la gestione degli errori di connessione
FUNCTION conferma($risultato){ // $risultto sara cio che arriva dalla mysqli_query($connessioneDB, @sql);

    GLOBAL $connessioneDB ;

    if($risultato){
      echo "<br><h2 class='text-center text-light bg-success'>OPERAZIONE CONFERMATA !</h2>";
      }
      else
      {
      // die('Richiesta fallita. ERROR : ' . mysqli_error($connessioneDB));
      echo "<br>ERRORE ! OPERAZIONE FALLITA. : " . mysqli_error($connessioneDB) ;
      }
}


function msg_err($text){
  echo "<h4 class='text-center text-light bg-alert'>$text</h4>";
}



FUNCTION astro(){
    echo "<div class='astro'>ASTRO " . $_SESSION['username'] . " - UserID : " . $_SESSION['iduser'] . "</div>" ; //
}

// ++++++++++++++++++ fx check access ++++++++++++++++++++ //
function check_iduser(){

  $id_user = $_SESSION['iduser'];
  if (!isset( $id_user ) ){
    header("Location:index.php");
  }
} // end fx



// ++++++++++++++++++++++++++++ FX LOGIN  +++++++++++++++++++++++++++++ //

function login(){

GLOBAL $connessioneDB;


  if ( isset ( $_POST['submit_login'] ) ){

    $username = trim($_POST['kc_username']);
    $passwd = trim($_POST['kc_passwd']);

    if ( $username == ""  OR $passwd == "" ) {

        msg_err("ERRORE : CAMPI RICHIESTI ! ");
    }

    else {

      // cerca id user connected to username + password //
          $sql = " SELECT id_user FROM utenti WHERE kc_username='$username' AND kc_passwd='$passwd' " ;
          $risultato = mysqli_query($connessioneDB, $sql);
          // conferma($risultato);

          $row_index = 0;

          while ( $row = mysqli_fetch_array($risultato) ) {
            $id_user = $row['id_user'];
            $row_index ++ ;
          } // END WHILE

          if ($row_index == 0) {   // CASE 1 : ID_USER NOT FOUND WITH username + password //


            //  NEW USER == YES : GENERATION OF ID_USER //
              $sql = " INSERT INTO utenti (id_user, kc_username, kc_passwd) VALUES ( 0 , '{$username}' , '{$passwd}' ) " ;
              $risultato = mysqli_query($connessioneDB, $sql);
              // conferma($risultato);



              // select last id user generated in users table  //
              $sql = " SELECT id_user FROM utenti WHERE kc_username='$username' AND kc_passwd='$passwd' " ;
              $risultato = mysqli_query($connessioneDB, $sql);
              //conferma($risultato);

                while ($row = mysqli_fetch_array($risultato)) {
                    $id_user = $row['id_user'];
                } // END WHILE


                // SETTA LA IDUSER VALORE GLOBALE NELLA $_SESSION VISIBILE DA TUTTI //
                $_SESSION['iduser'] = $id_user;
                $_SESSION['username'] = $username;
                echo "<div class='bg-success text-center'>NUOVO UTENTE CONFERMATO ! : $id_user</div>";




                // inizializza OBB = 1500 di default nella totali //
                $id_rec = 0;
                $data = date('Y-n-d');
                $limite =  1500 ;
                $sql = " INSERT INTO totali (id_user, id_rec, data, tp, cal) VALUES ('{$id_user}' , '{$id_rec}' , '{$data}',  'OBB' , '{$limite}' ) ";
                $risultato = mysqli_query($connessioneDB, $sql);
              //  conferma($risultato);

                echo "<div class='bg-success text-center'>NUOVO OBBIETTIVO CONFERMATO PER UTENTE : $id_user</div>";



            } // END IF newuser == YES //

            else   //  // CASE 2 : ID_USER FOUND WITH username + password //


            {

                        // TEST EXTRA TO SEE IF ACCESS CODE = 1 FOR THAT ID USER //
                                  $sql = "SELECT id_user, access_code FROM utenti WHERE id_user = '$id_user' " ;
                                  $risultato = mysqli_query($connessioneDB, $sql);
                                  //conferma($risultato);

                                  $rowcount = 0;

                                  while ($row = mysqli_fetch_array($risultato)) {
                                    $id_user = $row['id_user'];
                                    $access_code = $row['access_code'];
                                    $rowcount ++;
                                  } // END WHILE

                                  // se NON trova cod utente (rowcount=0) = ERR : cod utente inserito non valido
                                  if ( $rowcount == 0 ){

                                    // ERROR : USER NOT FOUND - not possible -- see login select //
                                    echo "<h4 class='bg-alert text-center text-light'>ERRORE : UTENTE NON TROVATO !</h4>" . mysqli_error($risultato);
                                    $_SESSION['iduser'] = NULL;


                                  }

                                  else // rowcount > 0 then id_user AND access_code //


                                  {

                                      // id_user FOUND : 0 or others ? //

                                      if ($id_user == 0 ){

                                          // test access_code //
                                          if ($access_code == 1){

                                            $_SESSION['iduser'] = $id_user;
                                            $_SESSION['username'] = $username;
                                            echo "<h4 class='bg-success text-center text-light'>ADMIN ABILITATO ! : $id_user</h4>";


                                            }

                                            else

                                            {

                                              $_SESSION['iduser'] = NULL;
                                              $_SESSION['username'] = "NOT ADMITTED";
                                              echo "<h4 class='bg-alert text-center text-light'>ERROR : ADMIN NON ABILITATO ! </h4>" . mysqli_error($risultato);

                                            }


                                          }

                                      else    // id_user != 0 //

                                          {
                                            $_SESSION['iduser'] = $id_user;
                                            $_SESSION['username'] = $username;
                                            echo "<p class='bg-success text-center text-light'>UTENTE CONFERMATO : $id_user</p>";


                                          }

                                    } // row_count != 0

            } // END ELSE -- NEWUSER = NO

      // BOTH CASEs : ID USER has been generated //

      session_commit();
      echo "<script>window.location.assign('home.php')</script>" ;


    } // if username OR passwd ARE NOT  NULL //


  } // ifset $_POST

} //END FX LOGIN()




?>  <!-- END TAG PHP
