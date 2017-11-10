<?php
require_once('../database.php');
if(!empty($project_id = $_POST["project_id"])) {
    try {
        $page = $_POST["page"];
        $results = $db->prepare('select image_name from pages
        where project_id = ? and page = ?');
        $results->bindParam(1, $project_id, PDO::PARAM_INT);
        $results->bindParam(2, $page, PDO::PARAM_INT);
        $results->execute();
    } catch(Exception $e) {
        echo $e->getMessage();
        die();
    }
    $image_name = $results->fetch(PDO::FETCH_ASSOC)["image_name"];
    if($image_name == FALSE){
        echo 'Sorry, a project could not be found with the provided id.';
        die();
    }
    echo $image_name;
}
else
    echo 'Sorry, a project id was not provided.';