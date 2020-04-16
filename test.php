<?php
include "./utils/PayPal/PayPal.php";
$p = new PayPal(true);
include "./config.php";
$token = $p->getToken("AQuygMvKooua8NOUloHhoENCme9o5XoFkM7ZzpMVKBuft_Ir3mHs7FA23Nyv7D3pHyw-_VHsSdaWHuP4","EBYU6OMvklLwaNU9eWqXv3CO3aetIqz1QQoT2nYyvfEt2K5Lz3T3AXf6T019N8kSZoT2DhhIPf4fzui3");
print_r( $token);