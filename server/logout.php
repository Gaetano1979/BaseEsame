<?php
session_start();
if (isset($_SESSION['username'])) {
  session_destroy();
  header("Location: http://localhost/BaseEsame/client/index.html");
}

 ?>
