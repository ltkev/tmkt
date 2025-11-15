# Uploadportal für MP3-Dateien
## Datenbankverbindung
Die Verbindung zur Datenbank läuft über mysqli. Es wird zwischen der lokalen (localhost) und produktiven Installation unterschieden.
Die benötigte Datenbanktabelle kann aus tm_anmeldung.sql übernommen werden
## Captcha
Captchas sind mittels Google Captcha (https://www.google.com/recaptcha/admin) eingebunden.
Der Public Key ist in der index.php in der Variable $public_captcha zu hinterlegen. Der private Key ist in tmkt.php im Attribut $captcha_key zu hinterlegen.
## Auswertung
Die Anzeige der hochgeladenen Dateien und angemeldeten Starter kann über Anmeldungen.php angezeigt werden. Diese sollte nicht frei im Internet aufrufbar sein und entsprechend mit einem Passwort oder Login versehen werden.
