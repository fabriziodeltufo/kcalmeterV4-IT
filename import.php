<!--
WebApp Code Name : kcalmeter
Date: 14-11-2019
Author : Fabrizio Del Tufo
Module : import.php
Last Upd : 10 June 2020
-->

<!-- FORM IMPORT -->
<?php
  if (isset($_SESSION['iduser'])){
    $id_user = $_SESSION['iduser'] ;
  }
?>

<div class="container-width text-center">
  <h3>Importa la lista alimenti dalla cartella di download.</h3>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  enctype="multipart/form-data">Seleziona il file da caricare :
    <input type="file" name="select">
    <input type="submit" name="upload" value="Importa">
  </form>
</div>
<br>
<hr>

<?php import (); ?>
