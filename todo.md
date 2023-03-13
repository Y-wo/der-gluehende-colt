# todo

- Geburtstags Attribut einpferchen
- Geburtstage ausgeben
- member anlegen
- member bearbeiten
- member löschen
- admin anlegen
- admin ändern
- login (bootstrap Maske entfernen)
- logout
- auf Server legen
- optisch anpassen (?)


14. Login
        - nur eventuell Möglichkeit schaffen, dass Admin einen neuen Admin anlegen kann.
    2. wenn Einloggen -> test -> jwt-Generierung -> speichern in sessionStorage -> jedes Mal jwt prüfen
    3. Projekt updaten
    4. überlegen, ob bootstrap-Maske so Sinn macht
15. Logout
16. Zugriff auf Git Repository geben
17. Helper functions erstellen (sinnvolle Funktionen)
    1. fetchSomething (PostFetch/GetFetch/...)
18. Bootstrap ohne die crossorigin Links versuchen
19. Geburtstag in memberEntity reinschreiben.
20. Fragen, wie sie das mit der Admin-Relation sehen (Wie wollen wir das am besten machen?)
21. 


- bottstrap login Maske funktioniert in kleinem fenster nicht
- administrator relation irgendwie einbinden oder Passwort
- wahrscheinlich bald git-token erneuern

## Zum Schluss
- hier ist noch ein manueller loginPath gesetzt: C:\xampp\htdocs\der-gluehende-colt\der-gluehende-colt\templates\navbar.html.twig
- Env auf prod ändern
- bootstrap links + webpack shit evtl. löschen
- Code bereinigen
- gucken, ob css anders wirkt auf /member oder /index.php/member
- attendencesPerYearForGunAuhorization auf 12 erhöhen
- login Route anpassen in public/js/base.js:17 auf dem server

## Befehle
- für jwt:
  * composer require firebase/php-jwt
