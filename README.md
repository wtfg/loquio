loquio
======
0.0.1

+ Guardare INSTALL.txt per le istruzioni di installazione!

Un'applicazione cloud per gestire facilmente le prenotazioni online
Totalmente italiana e in italiano, da impacchettare e da utilizzare

Sviluppata in PHP, utilizza il framework gratuito DooPhp


======

Bug da fixare:
* inconsistenza di mysql nell update, fixare in generale il problema nel codice sorgente del framework
* nelle prenotazoni mettere "dalle ore" nello slot di loquio dev prenotazioni
* http://www.loquio.it/cavour/prenotazioni/list
    i menù multipli si aprono e si richiudono subito
* http://www.loquio.it/cavour/register/ -inserire l'asterico per i dati obbligatori (oppure scrivere tutti i dati sono obbligatori)
    + aggiungere la pagina trattamento dati personali (blank)
* http://www.loquio.it/cavour/admin/materie
    + ogni volta che inserisco una materia
    + dopo l'inserimento mi riporta alla Dashboard (invece dovrebbe rimanere nella sezione finché io non cambio. Questo comportamento sembra essere presente in tutti gli altri inserimenti
* http://www.loquio.it/cavour/admin/docenti
    + il nome del docente dovrebbe essere visualizzabile per cognome e nome e non il contrario
* nel fare le prenotazionì staccare nome studente da cognome studente
* Inserisci pannello utente (modifica password e dati personali)
* Sulle config generali nome scuola
* Nel titolo di ogni pagina mettere il nome della scuola
* ???? Email della prenotazione mandata in automatico (e anche il telefono)
* Inserire spiegazioni
* Lato admin: inserire dei filtri per tutto (giorno, docente bla bla bla)
    + Export dati
* Pomeridiani
    + MODELLO IN ATTESA
* Lato admin:
    + Inserire in configurazioni un flag per disabilitare/abilitare la vista e le prenotazioni mattutine
    + Inserire in configurazioni un flag per disabilitare/abilitare la vista dei pomeridiani

Possibili migliorie opzionali
+ Introdurre sliders
+ IMPORTANTE: Refactoring del codice
+ Refactoring del javascript, introduzione di minifiers
+ Cambio dei controller UI nei timeslot in range multipli
+ Tool di filtraggio liste (successivo)