<!-- 
/*
 * ====================================
 *   LTK e.V.
 *   Author: Christian Herold
 *   Date:   2025-08-13
 * ====================================
 */
 -->
 <!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Musikupload für die Thüringer Meisterschaft</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .upload-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        input[type="file"] {
            margin-top: 10px;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        ul {
          display: inline-block;
          text-align: left;
        }   
        .description {
        	text-align: right;
        	padding-right: 10px;
        }
        .values {
        	text-align: left;
        }
    </style>
</head>
<body>
<div class="upload-box" >

<?php

    require_once 'tmkt.php'; 
    $tmkt = new tmkt();
    IF(isset($_GET["del"])) $tmkt->delete($_GET["del"]);
    echo  $tmkt->get_registrations(); 

?>
</div>
</body>
</html>