<?php
require_once('database.php');

try {
    $results = $db->query(
'select users.nickname as author_name, projects.id as id,
projects.name as name, projects.total_pages as total_pages,
projects.chapter as chapter, pages.page as page,
pages.image_name as image_name from projects left join pages
on projects.id=pages.project_id left join users on
projects.author_id=users.id where pages.cover = 1');
} catch(Exception $e) {
    echo $e->getMessage();
    die();
}
$projects = $results->fetchAll(PDO::FETCH_ASSOC);
/*echo '<pre>';
var_dump($projects);
echo '</pre>';
die();*/
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="favicon.ico">
    <title>Drawbook</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine">
    <link rel="stylesheet" href="./css/font-css/roboto-font.css">
    <link rel="stylesheet" href="./css/font-css/icon.css">
    <link rel="stylesheet" href="./css/font-css/icon-codes.css">
    <link rel="stylesheet" href="./css/font-css/icon-embedded.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/font-css/animation.css">
    <style>
    </style>
</head>
<body>
<div id="head">
    <a href="#">
        <div id="logo"></div><h1>Drawbook</h1></a>
    <div id="head-right">
        <div id="top-menu">
            <a href="#">Home</a>
            <a href="#">Categories</a>
            <a href="#">Illustrations</a>
            <a href="#">Artists</a>
            <a href="#">My works</a>
            <a href="#">Login</a>
        </div>
        <div id="search">
            <div>Search</div>
            <a href="#" onclick="searchAction(); return false;">l</a>
        </div>
        <div id="small-menu" onclick="openMenu(); return false;">~</div>
    </div>
</div>
<div id="container">
    <ul class="project-list">
        <?php
        for($i = 0; $i < 2; $i++){
            foreach($projects as $project)
            {
                echo '<li>';
                echo '<div class="image-container" data-id="' . $project["id"] . '"  data-totalPages="' . $project["total_pages"] . '">';
                echo '<img src="img/pages/'. $project["image_name"] . '.jpg">';
                echo '<div href="#" class="image-hover">';
                echo '<a href="img/pages/'. $project["image_name"] . '.jpg">';
                echo ' <span>l</span></a></div></div>';
                echo ' <div class="image-description">
                    <div class="project-name"><a href="#">'. $project["name"] . '</a></div>
                    <div class="author-name"><a href="#">' . $project["author_name"] . '</a></div>
                </div>';
                echo '</li>';
            }
        } ?>
    </ul>
</div>
<div id="footer">
    <img src="./img/logo-high.png">
    <div>Drawbook<br>All rights reserved</div>
</div>
</body>
<script src="./js/jquery-1.11.3.js"></script>
<script src="./js/reader.js"></script>
<script>
    function openMenu() {

    }
    function searchAction () {
         if($('#search div').length){
            $('#search div').remove();
            $('#search a').before('<input type="text" name="search">');
            $('#search input').focus();
        } else {
            $('#search input').remove();
            $('#search a').before('<div>Search</div>');
            // HERE YOU INSERT SEARCHING METHOD
        }
    }
</script>
</html>