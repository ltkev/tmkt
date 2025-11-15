<?php
/*
 * ====================================
 *   LTK e.V.
 *   Author: Christian Herold
 *   Date:   2025-08-13
 * ====================================
 */
class tmkt
{ 
    protected $tm_mail = 'admin@ltkev.de';
    protected $Verbindung;  
    protected $SessionID;
    protected $success;
    protected $ausgabe = '';
    protected $mailtext = '';
    protected $upload_dir = 'uploads/';  
    protected $Mail;
    private $captcha_key ="";
    protected $AK = array("JUG" => "Jugend","JUN" =>"Junioren","UE15"=>"Ü15");
    protected $Disziplin =array( "TP"=>"Tanzpaar","MW"=>"Marsch","SW"=>"Solisten weiblich","SM"=>"Solisten männlich","GG"=>"Gemischte Garden","ST"=>"Schautanz");
    
    private $result; 
    
    function __construct()  {
        if (strpos(@$_SERVER['HTTP_HOST'], "localhost") === false) 
            @$this->Verbindung = mysqli_connect('localhost', '', '', '');
        else   @$this->Verbindung = mysqli_connect("", "", "", "");
                        
            @mysqli_set_charset($this->Verbindung, "utf8mb4");  
    }
    
    function query($sql){  
        try { 
            $this->result = $this->Verbindung->query($sql);
            if(!$this->result) { 
                $errmsg = "INSERT IGNORE INTO error_tracking (query,error_msg)
                        VALUES ('".$this->Verbindung->escape_string($sql)."','".$this->Verbindung->escape_string($this->Verbindung->error)."')";
                $this->Verbindung->query($errmsg);
                $this->success = ''; 
            }
            else { 
                $this->success = 'X'; 
                return $this->result;
            }
        } catch (Exception $e) { 
            $errmsg = "INSERT IGNORE INTO error_tracking (query,error_msg)
                        VALUES ('".$this->Verbindung->escape_string($sql)."','".$this->Verbindung->escape_string($this->Verbindung->error)."')";
            $this->Verbindung->query($errmsg);
            $this->success = ''; 
        } 
    }
    
    function upload() {
        $json = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$this->captcha_key.'&response='.$_POST['g-recaptcha-response']);
        $data = json_decode($json);
        
        $data->success = 1;
        
        if($data->success){
        // Daten übernehmen
        $this->Mail = $this->Verbindung->escape_string($_POST["Mail"]); 
            // Prüfen, ob Datei hochgeladen wurde
            if ($_FILES["mp3file1"]["size"] > 0) {
                $this->speichern(1,$_FILES["mp3file1"],$_POST["AK1"],$_POST["Disziplin1"],$_POST["Startnummer1"],
                    $this->Verbindung->escape_string($_POST["Verein1"]),$_POST["Einmarsch1"]);
            }
            if ($_FILES["mp3file2"]["size"] > 0) {
                $this->speichern(2,$_FILES["mp3file2"],$_POST["AK2"],$_POST["Disziplin2"],$_POST["Startnummer2"],
                    $this->Verbindung->escape_string($_POST["Verein2"]),$_POST["Einmarsch2"]);
            }
            if ($_FILES["mp3file3"]["size"] > 0) {
                $this->speichern(3,$_FILES["mp3file3"],$_POST["AK3"],$_POST["Disziplin3"],$_POST["Startnummer3"],
                    $this->Verbindung->escape_string($_POST["Verein3"]),$_POST["Einmarsch3"]);
            }
            echo "<table><tr><td align=\"center\"><img src=\"tmkt.png\" width=\"200px\"></td></tr>".$this->ausgabe;
            if($this->mailtext != '')
                $this->send_mail($this->Mail,$_POST["Verein1"]);
                echo "<tr><td>Über den Zurück-Button deines Browsers kommst du zurück zum Formular und kannst deine Eingaben ändern, falls ein Fehler aufgetreten ist.<br> 
                        <a href=\"http://".$_SERVER['HTTP_HOST']."\">Hier klicken</a>, um weitere Dateien hochzuladen.</td></tr></table>";
        }
        else echo "<span class=\"error\">Bitte fülle das Captcha aus!</span>";
    }
    
    protected function speichern($Anmeldnr,$file,$AK,$Disziplin,$Startnummer,$Verein,$Einmarsch) {
         
        $allowed_extensions = array('mp3'); // Erlaubte Dateitypen  
        
        // Dateiinformationen holen
        $filename = basename($file["name"]);
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        // Dateityp prüfen
        if (!in_array($extension, $allowed_extensions)) {
            echo "<tr><td><span class=\"error\">Der Datentyp für Anmeldung $Anmeldnr ist falsch.Bitte gehe zurück und lade eine mp3-Datei hoch.</span><br></td></tr>";
            return;
        }
        
        // Dateigröße prüfen
        if ($file["size"] > 15000000) { // 15MB limit
            echo "<tr><td><span class=\"error\">Datei für Anmeldung $Anmeldnr ist größer als 15 MB. Bitte gehe zurück und lade eine kleinere Datei hoch.</span><br></td></tr>";
            return;
        }
        
        if( $Einmarsch == "keE" && $Disziplin == "ST") $Einmarsch_flag = 'X';
        else $Einmarsch_flag = '';
        
        
        // Dateinamen erstellen
        $new_filename = $Startnummer.'_'.$AK.'_'.$Disziplin.'.' . $extension;
        
        // Zielpfad festlegen
        $destination = $this->upload_dir . $new_filename;
        
        //Prüfe, ob bereits ein Eintrag vorhanden ist
        $result = $this->query("SELECT * FROM tm_anmeldung WHERE AK='$AK' AND Disziplin = '$Disziplin' AND Startnummer = '$Startnummer'");
        if($result->fetch_assoc()) {
            $this->ausgabe .= "<tr><td><span class=\"error\">Es ist bereits ein Eintrag für die Kombination ".$this->AK[$AK].", ".$this->Disziplin[$Disziplin].", $Startnummer vorhanden!<br>
                            Bitte prüfe deine Eingaben oder melde dich per Mail bei ".$this->tm_mail.".</span><br></td></tr>";
            return ;
        }
        
        if (move_uploaded_file($file["tmp_name"], $destination)) {
           $res =  $this->query("INSERT INTO tm_anmeldung (AK,Disziplin,Startnummer,Einmarsch,Verein,Dateiname,Mail)
                                                        VALUES ('$AK','$Disziplin','$Startnummer','$Einmarsch_flag','$Verein','$new_filename','$this->Mail')");
          
            if($this->success == 'X') {
                if ($Einmarsch_flag == 'X') $Einmarsch = "Ja";
                else $Einmarsch = "Nein";
                $this->prepare_mail($AK,$Disziplin,$Startnummer,$Verein,$Einmarsch);
                $this->ausgabe .= "<tr><td>
                    Übermittlung erfolgreich. Folgende Daten wurden erfasst:<br>
                    Altersklasse: ".$this->AK[$AK]."<br>
                    Disziplin: ".$this->Disziplin[$Disziplin]."<br>";
                if($Disziplin == "ST") $this->ausgabe .= "Einmarsch benötigt: $Einmarsch<br>";
                $this->ausgabe .= "Startnummer: $Startnummer<br>
                    Verein: $Verein<br>
                    EMail für Rückfragen: $this->Mail</td></tr>";
            }
            else $this->ausgabe .= "<tr><td><span class=\"error\">Es ist ein Fehler bei Anmeldung $Anmeldnr aufgetreten! Bitte nochmal versuchen oder per Mail an $this->tm_mail senden</span><br></td></tr>";
        } else $this->ausgabe .= "<tr><td><span class=\"error\">Datei für Anmeldung $Anmeldnr konnte nicht hochgeladen werden! Bitte nochmal versuchen oder per Mail an $this->tm_mail senden</span><br></td></tr>";
        
    }
    
    protected function prepare_mail($AK,$Disziplin,$Startnummer,$Verein,$Einmarsch) {
        $this->mailtext .= "<br><br>Altersklasse: ".$this->AK[$AK]."<br>
                    Disziplin: ".$this->Disziplin[$Disziplin]."<br>";
        if($Disziplin == "ST") $this->mailtext .= "Einmarsch benötigt: $Einmarsch<br>";
        $this->mailtext .= "Startnummer: $Startnummer<br>
                    Verein: $Verein<br> ";
    }
    
    
    protected function send_mail($Mail,$Verein) {
        $mailtext = '<html><head></head><body>
	                       <table style="margin-left: auto; margin-right: auto; width:75%; border-collapse:collapse; border:0; background:#ffffff; font-family:arial, sans-serif"><tr><td style="border-left: 10px solid #ffffff; border-right: 10px solid #ffffff"><br>';
        $mailtext .= "Hallo Alex,<br><br>";
        $mailtext .= "es wurde gerade eine neue Musikdatei hochgeladen:<br>";
       
        $mailtext .= $this->mailtext." <br>
                    E-Mail für Rückfragen: $Mail<br><br>";
        $mailtext .= '</body></html>';
        
        $zusatz = 'From: kontakt@ltkev.de'."\r\n";
        $zusatz .= 'Cc: '.$Mail . "\r\n";
        $zusatz .= 'Mime-Version: 1.0'. "\r\n";
        $zusatz .= "Content-type: text/html; charset=utf-8 \r\n";
        $zusatz .= "X-Mailer: PHP/". phpversion();
        $zusatz .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n";
        @mail( $this->tm_mail, 'Neuer Musikupload von '.$Verein, $mailtext, $zusatz);
        ;
    }
    
    public function get_registrations() {
        $output = "<table width=\"1200\" border=\"1\"><tr><td>Altersklasse</td><td>Disziplin</td><td>kein eig. Einmarsch</td><td>Startnummer</td><td>Verein</td><td>EMail</td><td>Musik</td><td>löschen</td></tr>";
        $rows = '';
        $result = $this->query("SELECT * FROM tm_anmeldung");
        
        while ($row = $result->fetch_assoc()) {
            $rows .= "<tr><td>".$this->AK[$row["AK"]]."</td><td>".$this->Disziplin[$row["Disziplin"]]."</td><td>".$row["Einmarsch"]."</td><td>".$row["Startnummer"]."</td>
                             <td>".$row["Verein"]."</td><td>".$row["Mail"]."</td><td><a href=\"https://upload.lkt-thueringen.de/".$this->upload_dir.$row["Dateiname"]."\" target=\"_blank\" download>".$row["Dateiname"]."</a></td><td><a href=\"".$_SERVER['SCRIPT_NAME']."?del=".$row["Dateiname"]."\"><img src=\"delete.png\" width=\"20\"></a></td></tr>";
        }
        
        if($rows == '') $rows = 'Noch keine Anmeldungen vorhanden.';
        return $output . $rows. "</table>";
    }
    
    public function delete($filename) {
        $this->query("DELETE FROM tm_anmeldung WHERE Dateiname='$filename'");
        unlink($this->upload_dir.$filename);
        ;
    }
}