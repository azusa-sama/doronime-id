<?php
header('Content-Type: application/json');
require_once('src/doronime.class.php');
require_once('src/simple_html_dom.php');

// Doronime Get Update
$doronime = new Doronime();
$doronime->get_data(); // Required -> Get Data From Doronime.id then Save to Properties Variable
$doronime->get_anime();

// Doronime Download From URL
// can Download OST and other from doronime.id
$doronimedl = new DoronimeDL('https://doronime.id/anime/tsuki-ga-michibiku-isekai-douchuu/episode-8');
$doronimedl->download();
