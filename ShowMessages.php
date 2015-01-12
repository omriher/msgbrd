<?php
// test
require 'dbConnect.php';

?>
<table alignt="center" border="0">
      <tr>
        <td>
      <?php
      try {
          foreach($dbh->query('SELECT * from Messages ORDER BY ID DESC') as $row) {
            ?>
            <img src="https://graph.facebook.com/<?php echo $row['fbUser']; ?>/picture"></td><td width="400" align="center">
             <?php

           print_r($row['Message'] . "<Br>");
           print("</td></tr><tr><td>");
          }
          $dbh = null;
      } catch (PDOException $e) {
          print "Error!: " . $e->getMessage() . "<br/>";
          die();
      }
    ?>
  </td>
</tr>
</table>