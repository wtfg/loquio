<?php
$ul = Doo::conf()->APP_URL . "/global/";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title> </title>
        <link rel="stylesheet" media="screen" href="<?php echo $ul; ?>css/style2.css" />
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
        <!-- This makes HTML5 elements work in IE 6-8 -->
        <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <link href='<?php echo $ul; ?>fc/fullcalendar/fullcalendar.css' rel='stylesheet' />
        <link href='<?php echo $ul; ?>fc/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
        <script src='<?php echo $ul; ?>fc/lib/jquery.min.js'></script>
        <script src='<?php echo $ul; ?>fc/lib/jquery-ui.custom.min.js'></script>
        <script src='<?php echo $ul; ?>fc/fullcalendar/fullcalendar.js'></script>
        <script src='<?php echo $ul; ?>js/validate.js'></script>
        <script>

            window.calendarUrl = '<?php echo Doo::conf()->APP_URL; ?>pren.json';
            window.upped = false;

            $(document).ready(function() {
                function updateChanges(add) {
                    $('#calendar').fullCalendar('removeEventSource', {
                        url: window.calendarUrl
                    });
                    if (add) {
                        $('#calendar').fullCalendar('addEventSource', {
                            url: window.calendarUrl,
                            type: 'POST',
                            data: {
                                message: {
                                    did: $("#did").val()
                                }

                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert("AJAX ERROR:" + errorThrown + "\n--\nTEXT STATUS: " + textStatus + "\n\n" + jqXHR.error + "\n\n" + jqXHR.toString() );
                            }
                        });
                    }
                }

                $('#mid').change(function() {

                    updateChanges(false);
                    window.upped = false;
                    switch ($(this).val()) {
					<?php
					foreach ($data['mdocenti'] as $key => $dm) {

						echo "case \"" . $key . "\":\n";
						echo " $(\"#did\").empty();\n";
					
						if (sizeof($dm) != 0) {
							echo "$(\"#did\").html(\"<option value=''>---</option>";
							foreach ($dm as $key => $d) {
								echo "<option value='" . $key . "'>" . $d . "</option>";
							}
							echo "\");";
						} else {
							echo "$(\"#did\").html(\"<option value='' >---</option>\");";
						}
						echo " break;";
					}
					?>
                        default:
                            $("#did").html("<option value='' >---</option>");
                            break;
                    }
                });

                $('#did').change(function() {

                    updateChanges(true);
                    window.upped = false;
                    //alert($( "#did" ).val());

                });

                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();

                $('#calendar').fullCalendar({
                    defaultView: 'agendaWeek',
                    editable: false,
                    firstDay: 1,
                    timeFormat: 'H(:mm)',
                    eventClick: function(calEvent, jsEvent, view) {

                        curr_min = calEvent.start.getMinutes() + "";

                        if (curr_min.length == 1)
                        {
                            curr_min = "0" + curr_min;
                        }
                        data = calEvent.start.getDate() + "-" + (calEvent.start.getMonth() + 1) + "-" + calEvent.start.getFullYear() + " " + calEvent.start.getHours() + ":" + curr_min;

                        if (calEvent.title != "Occupato") {

                            $('#selected').val(data);

                        }
                        //alert('Event: ' + calEvent.title);

                        //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                        //alert('View: ' + view.name);

                        // change the border color just for fun
                        //$(this).css('border-color', 'red');

                    },
                    columnFormat: {
                        month: 'ddd', // Mon
                        week: 'ddd d/M', // Mon 9/7
                        day: 'dddd d/M'  // Monday 9/7
                    },
                    eventSources: [
                        // your event source
                        {
                            url: window.calendarUrl,
                            type: 'POST',
                            data: {
                                message: {
                                    did: $("#did").val()
                                }

                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert(errorThrown + "\n--\n" + textStatus);
                            }
                        }

                        // any other sources...

                    ],
                    eventAfterAllRender: gotoFirstFreeEvent,
                    eventColor: '#000044'
                });
                function gotoFirstFreeEvent() {
                    if (window.upped == false) {
                        thedate = "";
                        events = $('#calendar').fullCalendar('clientEvents');
                        if (events.length > 1) {
                            for (var i = 0; i < events.length; i++) {
                                if (events[i]['start'] !== undefined) {
                                    thedate = events[i]['start'];
                                    break;
                                }
                                // Iterates over numeric indexes from 0 to 5, as everyone expects.
                            }


                            y = new Date(thedate).getFullYear();
                            m = new Date(thedate).getMonth();
                            d = new Date(thedate).getDate();

                            //alert(y+" "+m+" "+d);

                            $('#calendar').fullCalendar('gotoDate', y, m, d);
                            window.upped = true;
                        }
                    }
                }
            });

        </script>
        <style>


            #calendar {
                width: 900px;
                margin: 0 auto;
            }

        </style>
    </head>

    <body>

        <h1>Inserisci prenotazione</h1>

        <form id="add-prenotazione" name="add-prenotazione" method="post" action="">
            <table align="center" width="40%">
                <tr>
                    <td> <h2>Nome studente</h2></td>
                    <td><input type="text" name="studente" id="studente" /></td>
                </tr>
                <tr>
                    <td> <h2>Classe</h2></td>
                    <td><input type="text" name="classe" id="classe" /></td>
                </tr>
                <tr>
                    <td> <h2>Email</h2></td>
                    <td><input type="text" name="email" id="email" /></td>
                </tr>
                <tr>
                    <td> <h2>Telefono</h2></td>
                    <td><input type="text" name="tel" id="tel" /></td>
                </tr>
                <tr>
                    <td> <h2>Materia</h2></td>
                    <td>
                        <select id="mid" name="mid">
                            <option value="" >Seleziona una materia</option>
                            <?php
                            foreach ($data['materie'] as $mid => $mnome) {

                                echo "<option value=\"" . $mid . "\" >" . $mnome . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td> <h2>Docente</h2></td>
                    <td>
                        <select id="did" name="did">
                            <option value="" >---</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td> <h2>Giorno Selezionato</h2></td>
                    <td><input type="text" readonly="readonly" name="selected" id="selected" value="" /></td>
                </tr>
           
            </table>
              <br />
    
            
            <input type="hidden" name="uid" value="<?php echo $data['uid']; ?>">
            
            
            
          
        
        <br>

        <div id='calendar'></div><br>
<br>

        <input type="submit" name="button" id="button" value="Invia" />
        </form>
        <a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
            <a class='back' href="javascript:history.go(-1);">&Lt;</a>
<script>
var v = new FormValidator("add-prenotazione",
    [
    {
        name: "studente", 
        display: "Studente",
        rules: "required"
    },{
        name: "classe", 
        display: "Classe",
        rules: "valid_class|required"
    },{
        name: "email", 
        display: "Email",
        rules: "valid_email|required"
    },{
        name: "tel", 
        display: "Telefono",
        rules: "numeric|required"
    },{
        name: "selected", 
        display: "Giorno Selezionato",
        rules: "required"
    }],function(errors, event){
        if(errors.length > 0){
            msg="";
            for(er in errors){
                msg += errors[er].message+"\n";
                
            }
            alert(msg);
        }
    }
);
</script>
    </body>
</html>