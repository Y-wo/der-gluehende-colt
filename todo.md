# todo

1. CHECK - Datentypen in den tables der Datenbank anpassen
2. CHECK - crossOrigin-Zugriff erlauben
3. CHECK - index.php entfernen aus url
4. CHECK - ManyToOne-Shit
5. CHECK - Daten einspielen
6. CHECK - API testen
7. CHECK - Html-Dokument wie bisher einbauen
8. CHECK - Masl und Thalia die API schicken
9. CHECK Js checken 
10. Login
    1. DB-Admin-table
        - eigene admin table anlegen
          - dort foreign Key auf user_id machen
        - in member dann isAdmin entfernen
        - nur eventuell Möglichkeit schaffen, dass Admin einen neuen Admin anlegen kann.
    2. wenn Einloggen -> test -> jwt-Generierung -> speichern in sessionStorage -> jedes Mal jwt prüfen
    3. Projekt updaten 
       1. Zugang für Masl und Thalia ermöglichen
    4. überlegen, ob bootstrap-Maske so Sinn macht

11. Logout
12. Helper functions erstellen (sinnvolle Funktionen)
    1. fetchSomething (PostFetch/GetFetch/...)
13. Bootstrap ohne die crossorigin Links versuchen
14. Zugriff auf Git Repository geben
15. Geburtstag in memberEntity reinschreiben.
16. Fragen, wie sie das mit der Admin-Relation sehen (Wie wollen wir das am besten machen?)


- bottstrap login Maske funktioniert in kleinem fenster nicht
- administrator relation irgendwie einbinden oder Passwort
- wahrscheinlich bald git-token erneuern

## Zum Schluss
- Env auf prod ändern
- bootstrap links + webpack shit evtl. löschen
- Code bereinigen
- gucken, ob css anders wirkt auf /member oder /index.php/member


## Befehle
- für jwt:
  * composer require firebase/php-jwt
