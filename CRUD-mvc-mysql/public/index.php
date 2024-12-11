<?php
    require_once __DIR__ . '/../app/Config/routing.php';

    use App\Config\Routes;

    try{
        new Routes();
    } catch(Exception $e){
        echo("Error: ". $e);
    }
?>