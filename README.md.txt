# Uploadportal für MP3-Dateien
## Datenbankverbindung
Die Verbindung zur Datenbank läuft über mysqli. Es wird zwischen der lokalen (localhost) und produktiven Installation unterschieden.
Die benötigte Datenbanktabelle kann aus tm_anmeldung.sql übernommen werden
## Captcha
Captchas sind mittels Google Captcha (https://www.google.com/recaptcha/admin) eingebunden.
Der Public Key ist in der index.php in der Variable $public_captcha zu hinterlegen. Der private Key ist in tmkt.php im Attribut $captcha_key zu hinterlegen.
