loquio
======
0.0.1

+ Guardare INSTALL.txt per le istruzioni di installazione!

Un'applicazione cloud per gestire facilmente le prenotazioni online
Totalmente italiana e in italiano, da impacchettare e da utilizzare

Sviluppata in PHP, utilizza il framework gratuito DooPhp


======

Bug da fixare:
* [GENERALE] inconsistenza di mysql nell update, fixare in generale il problema nel codice sorgente del framework
* bug consistente nell usercontroller tra docente e utente
* prenotazioni/list rendere stampabile la tabella della lista
* prenotazioni/list separare la nelle liste classe
* register/ inserisci voce "password dimenticata?".
    + inserisci la mail e se la mail esiste verra mandato un link per resettare la password valido entro 24 ore.
    + reset pass
* http://www.loquio.it/cavour/register/
    + aggiungere la pagina trattamento dati personali (blank)

* ???? Email della prenotazione mandata in automatico (e anche il telefono)


pomeridiani
======

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


todo x deploy
======

* Fare una guida in PDF per gli utenti
* Fare una videoguida con un doppiatore
* Bootstrap a una pagina che illustra i vantaggi di loquio
    + guida e documentazione in PDF
    + videoguida su youtube
* Domini di terzo livello
* Grafiche, loghi eccetera