loquio
======
0.0.1

+ Guardare INSTALL.txt per le istruzioni di installazione!

Un'applicazione cloud per gestire facilmente le prenotazioni online
Totalmente italiana e in italiano, da impacchettare e da utilizzare

Sviluppata in PHP, utilizza il framework gratuito DooPhp


======

Bug da fixare:
* http://www.retinavision.it/loquio/prenotazioni/list
    i menù multipli si aprono e si richiudono subito
* http://www.retinavision.it/loquio/register/ -inserire l'asterico per i dati obbligatori (oppure scrivere tutti i dati sono obbligatori)
    + eliminare email alternativa
    + aggiungere la pagina trattamento dati personali (blank)
* http://www.retinavision.it/loquio/admin/materie
    + ogni volta che inserisco una materia
    + dopo l'inserimento mi riporta alla Dashboard (invece dovrebbe rimanere nella sezione finché io non cambio. Questo comportamento sembra essere presente in tutti gli altri inserimenti
    + c'è un bug negli inserimenti degli apostrofi (presente anche in altri inserimenti)
* http://www.retinavision.it/loquio/admin/docenti
    + il nome del docente dovrebbe essere visualizzabile per cognome e nome e non il contrario
    + dovrebbe essere possibile un sort (alfabetico)
    + Inoltre anche in tutti gli inserimenti (in visualizzazione) c'è un ordinamento in base all'inserimento e non alfabetico
    + l'attività e la disattività di un docente dovrebbe essere eseguita direttamente dalla visualizzazione e non solo andando in modifica
* nel fare le prenotazionì staccare nome studente da cognome studente
* Mostrare seats disponibili sulla prenotazione
* Inserisci pannello utente (modifica password e dati personali)
* Sulle config generali nome scuola
* Nel titolo di ogni pagina mettere il nome della scuola
* ???? Email della prenotazione mandata in automatico (e anche il telefono)
* Non deve mostrare l'orario nello slot per la prenotazione nella lista
* Inserire spiegazioni
* Lato admin: inserire dei filtri per tutto (giorno, docente bla bla bla)
    + Sort dei docenti
    + Export dati



Possibili migliorie opzionali
+ Introdurre sliders
+ IMPORTANTE: Refactoring del codice
+ Refactoring del javascript, introduzione di minifiers
+ Cambio dei controller UI nei timeslot in range multipli
+ Tool di filtraggio liste (successivo)