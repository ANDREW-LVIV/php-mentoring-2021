<?php

header('Content-Type: text/html; charset=utf-8');
require_once("APIClient.php");
require_once('Cache.php');

$act = $_GET['act'] ?: NULL;
$breed_id = $_GET['breed_id'] ?: NULL;

$client = new APIClient();
$cache = new Cache();
$cacheKey = 'cat' . $act . $breed_id;

if(!$act){
  $cache_lifetime = 5;
  $breeds = $cache->getCache($cacheKey, $cache_lifetime) ?? $cache->setCache($cacheKey, $client->getBreeds()->getBody(), $cache_lifetime);
  $breeds = json_decode($breeds, true);
} elseif ($act == 'show_breed' && $breed_id) {
  $cache_lifetime = 0;
  $breed_by_name = $cache->getCache($cacheKey, $cache_lifetime) ?? $cache->setCache($cacheKey, $client->getBreedByName($breed_id)->getBody(), $cache_lifetime);
  $breed_by_name = json_decode($breed_by_name, true);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>TheCatAPI | Guzzle</title>
  <link rel="stylesheet" type="text/css" href="styles/style.css"/>
</head>

<body>

  <div class="header">
    <h2>TheCatAPI</h2>
  </div>

<?php if (!$act): ?>

    <div class="main">
        <?php foreach($breeds as $breed): ?>
            <div class="result_item">
                <a href="/?act=show_breed&breed_id=<?= $breed['id']; ?>">
                    <?= $breed['name'] ?>
                    <span>[<?= $breed['origin'] ?>]</span>
                </a>
            </div>
        <?php endforeach?>
    </div>

<?php elseif ($act == 'show_breed' && $breed_id): ?>

    <div class="main">
        <a href="/">← BACK</a> | <a href="<?= $_SERVER['REQUEST_URI'] ?>">REFRESH PAGE</a>
        <?php foreach($breed_by_name as $data): ?>
            <div class="result_item">
                <div class="result_title">name:</div>
                <div class="result_data"><?= $data['breeds'][0]['name']; ?></div>
                <div class="result_title">temperament:</div>
                <div class="result_data"><?= $data['breeds'][0]['temperament']; ?></div>
                <div class="result_title">description:</div>
                <div class="result_data"><?= $data['breeds'][0]['description']; ?></div>
                <div>
                    <img src="<?= $data['url']; ?>" alt="<?= $data['name']; ?>">
                </div>
            </div>
        <?php endforeach?>
    </div>

<?php endif; ?>

</body>
</html>

