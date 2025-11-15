<?php 
$public_captcha = "";

require_once 'tmkt.php';
function upload() {
    $tmkt = new tmkt();
    $tmkt->upload(); 
}
?>
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
            
        }
        .upload-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .error {
            font-family: Arial, sans-serif;
            color: red; /* Schriftfarbe rot */
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
        td { padding-bottom:10px;
        }
    </style>
</head>
<script type="text/javascript">
window.onload = function() {
    check_Disziplin1();
    check_Disziplin2();
    check_Disziplin3();
};
    function check_Disziplin1(){
        var select = document.getElementById('Disziplin1').selectedIndex;  
        if(select == 5) {
            document.getElementById('Einmarsch1').style.display = "block"; 
            alert("Bitte zusätzlich angeben, ob ein eigener Einmarsch im Lied enthalten ist");
        }     
        else { 
            document.getElementById('Einmarsch1').style.display = "none"; 
        }
};
function check_Disziplin2(){
        var select = document.getElementById('Disziplin2').selectedIndex;  
        if(select == 5) {
            document.getElementById('Einmarsch2').style.display = "block"; 
            alert("Bitte zusätzlich angeben, ob ein eigener Einmarsch im Lied enthalten ist");
        }     
        else { 
            document.getElementById('Einmarsch2').style.display = "none"; 
        }
};
function check_Disziplin3(){
        var select = document.getElementById('Disziplin3').selectedIndex;  
        if(select == 5) {
            document.getElementById('Einmarsch3').style.display = "block"; 
            alert("Bitte zusätzlich angeben, ob ein eigener Einmarsch im Lied enthalten ist");
        }     
        else { 
            document.getElementById('Einmarsch3').style.display = "none"; 
        }
};
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
 
<body>
<?php  
if(isset($_POST["submit"])) upload();
else { ?>
<div class="upload-box" >
<img src="tmkt.png" width="200px"><p>&nbsp;</p>
<table><tr><td width="800">  
Liebe Alle, <br>
herzlich Willkommen zum Musikupload für die Thüringer Meisterschaft.<br> 
<br>
Folgendes gilt es zu beachten:<br>
<ul>
<li>pro Start und Verein können bis zu 3 Dateien hochgeladen werden</li>
<li>die Musikdatei muss im Format .mp3 sein und darf max. eine Größe von 15 MB haben</li>
<li>der Upload muss bis spätestens <u>18.10.2025 11:11 Uhr</u> erfolgen</li>
<li>solltet Ihr nach dem Upload Änderungen vornehmen wollen, meldet Euch bitte bis spätestens <u>22.10.2025 20:11 Uhr</u> unter: alexander.ebert@skvschweina.com
</li>
</ul>  

Nach dem erfolgreichen Upload bekommt ihr eine Mail zur Bestätigung (bitte checkt auch Euren Spamordner), sollte diese nicht innerhalb von 2 h bei euch angekommen sein, meldet euch bitte unter: alexander.ebert@skvschweina.com <br>
<br>
Die Dateien werden am <u>Montag, 27.10.2025</u> vollständig gelöscht und es kann nicht mehr auf die Daten zugegriffen werden. <br>
</td></tr></table><br><br>

    <h2>Anmeldung 1</h2>
    <form action="index.php" method="POST" enctype="multipart/form-data">
    <table width="400" align="center"><tr><td class="description">Altersklasse</td><td class="values">
    <select name="AK1">
        <option value="JUG">Jugend</option>
    	<option value="JUN">Junioren</option>
    	<option value="UE15">Ü15</option>
	</select>
	</td></tr><tr><td class="description">Disziplin</td><td class="values">	
    <select name="Disziplin1" id="Disziplin1" onchange="check_Disziplin1();">
        <option value="TP">Tanzpaar</option>
    	<option value="MW">Marsch</option>
    	<option value="SW">Solisten weiblich</option>
    	<option value="SM">Solisten männlich</option>
    	<option value="GG">Gemischte Garden</option>
    	<option value="ST">Schautanz</option>
	</select><br>
	<select name="Einmarsch1" id="Einmarsch1">
    	<option value="eE">Eigener Einmarsch</option>
    	<option value="keE">Kein eigener Einmarsch</option>
    	</select>
	</td></tr><tr><td class="description"> Startnummer</td><td class="values">		
	<select name="Startnummer1">
	<?php    // Schleife für die Optionen 1 bis 40
        for ($i = 1; $i <= 40; $i++) {
            if ($i<10) $nr = "0".$i;
            else $nr = $i;
            echo "<option value=\"$nr\">$nr</option>";
        }
    ?>
	</select>
	</td></tr><tr><td class="description"> Verein</td><td class="values">	
	<input type="text" name="Verein1" required/>	
	</td></tr><tr><td class="description"> Musikdatei</td><td class="values">	
        <input type="file" name="mp3file1" accept=".mp3" required>
        </td></tr><tr><td>
	</td></tr><tr><td class="description">E-Mail für Rückfragen</td><td class="values">	
	<input type="text" name="Mail" required/>	
	</td></tr>
	
	<tr><td colspan="2"><br><div style="color:red">Es können bis zu 3 Anmeldungen gleichzeitig durchgeführt werden. Bei einer langsamen Internetverbindung wird empfohlen die Anmeldungen einzeln durchzuführen.</tr>
	<tr><td colspan="2"><h2>Anmeldung 2</h2></tr>
	<tr><td class="description">Altersklasse</td><td class="values">
    <select name="AK2">
        <option value="JUG">Jugend</option>
    	<option value="JUN">Junioren</option>
    	<option value="UE15">Ü15</option>
	</select>
	</td></tr><tr><td class="description">Disziplin</td><td class="values">	
    <select name="Disziplin2" id="Disziplin2" onchange="check_Disziplin2();">
        <option value="TP">Tanzpaar</option>
    	<option value="MW">Marsch</option>
    	<option value="SW">Solisten weiblich</option>
    	<option value="SM">Solisten männlich</option>
    	<option value="GG">Gemischte Garden</option>
    	<option value="ST">Schautanz</option>
	</select><br>
	<select name="Einmarsch2" id="Einmarsch2">
    	<option value="eE">Eigener Einmarsch</option>
    	<option value="keE">Kein eigener Einmarsch</option>
    	</select>
	</td></tr><tr><td class="description"> Startnummer</td><td class="values">		
	<select name="Startnummer2">
	<?php    // Schleife für die Optionen 1 bis 40
        for ($i = 1; $i <= 40; $i++) {
            if ($i<10) $nr = "0".$i;
            else $nr = $i;
            echo "<option value=\"$nr\">$nr</option>";
        }
    ?>
	</select>
	</td></tr><tr><td class="description"> Verein</td><td class="values">	
	<input type="text" name="Verein2" />	
	</td></tr><tr><td class="description"> Musikdatei</td><td class="values">	
        <input type="file" name="mp3file2" accept=".mp3" >
        </td></tr>
	
	
	<tr><td colspan="2"><h2>Anmeldung 3</h2></tr>
	<tr><td class="description">Altersklasse</td><td class="values">
    <select name="AK3">
        <option value="JUG">Jugend</option>
    	<option value="JUN">Junioren</option>
    	<option value="UE15">Ü15</option>
	</select>
	</td></tr><tr><td class="description">Disziplin</td><td class="values">	
    <select name="Disziplin3" id="Disziplin3" onchange="check_Disziplin3();">
        <option value="TP">Tanzpaar</option>
    	<option value="MW">Marsch</option>
    	<option value="SW">Solisten weiblich</option>
    	<option value="SM">Solisten männlich</option>
    	<option value="GG">Gemischte Garden</option>
    	<option value="ST">Schautanz</option>
	</select><br>
	<select name="Einmarsch3" id="Einmarsch3">
    	<option value="eE">Eigener Einmarsch</option>
    	<option value="keE">Kein eigener Einmarsch</option>
    	</select>
	</td></tr><tr><td class="description"> Startnummer</td><td class="values">		
	<select name="Startnummer3">
	<?php    // Schleife für die Optionen 1 bis 40
        for ($i = 1; $i <= 40; $i++) {
            if ($i<10) $nr = "0".$i;
            else $nr = $i;
            echo "<option value=\"$nr\">$nr</option>";
        }
    ?>
	</select>
	</td></tr><tr><td class="description"> Verein</td><td class="values">	
	<input type="text" name="Verein3" />	
	</td></tr><tr><td class="description"> Musikdatei</td><td class="values">	
        <input type="file" name="mp3file3" accept=".mp3" ><br><br>
        </td></tr>	
	
	
	
	
	<tr><td class="description"> </td><td class="values">	
	 <div class="g-recaptcha" data-sitekey="<?php echo $public_captcha; ?>"></div>
		
        <button type="submit" name="submit">Hochladen</button>
   </td></tr></table>
    </form>
</div>
<?php } ?>

</body>
</html>