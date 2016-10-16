<?php

function generateRandomToken($length = 25) {
  return bin2hex(openssl_random_pseudo_bytes($length));
}

?>
