<?php
$ul = Doo::conf()->APP_URL . "/global/";

ob_start();
?>
    <link href='<?php echo $ul; ?>fc/fullcalendar/fullcalendar.css' rel='stylesheet' />
    <link href='<?php echo $ul; ?>fc/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<?php
$data["head"] = ob_get_contents();
ob_end_clean();
ob_start();
?>

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

                            },success: function(data)
                            {
                               //alert(JSON.stringify(data));
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(arguments);
                                //alert("AJAX ERROR:" + errorThrown + "\n--\nTEXT STATUS: " + textStatus + "\n\n" + jqXHR.error + "\n\n" + jqXHR.toString() );
                            }
                        });
                    }
                }

                $('#mid').change(function() {

                    updateChanges(false);
                    window.upped = false;
                    $("#selected").val("");
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
                    $("#selected").val("");
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
                    timeFormat: 'Dalle ore H:mm',
                    eventClick: function(calEvent, jsEvent, view) {

                        curr_min = calEvent.start.getMinutes() + "";

                        if (curr_min.length == 1)
                        {
                            curr_min = "0" + curr_min;
                        }
                        data = calEvent.start.getDate() + "-" + (calEvent.start.getMonth() + 1) + "-" + calEvent.start.getFullYear() + " " + calEvent.start.getHours() + ":" + curr_min;

                        if (calEvent.title != "Occupato") {

                            $('#selected').val(data);
                            z = "<b>Prenotazione selezionata per il giorno " + data.toString().replace(" ", " dalle ore ") + "<br>Clicca sul pulsante Invia (in fondo alla pagina) per confermare</b>";
                            $("#infos").html(z);
                            //alert("AAA");
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

                            },success: function(data)
                            {
                                //alert(data);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(arguments);
                                //alert("AJAX ERROR:" + errorThrown + "\n--\nTEXT STATUS: " + textStatus + errorThrown.toString() );
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
<?php
$data['scripts'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
Inserisci prenotazione
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>


        <form id="add-prenotazione" name="add-prenotazione" method="post" action="">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Cognome e nome studente </label>

                <div class="col-sm-9">
                    <input type="text" name="studente" id="studente" placeholder="Cognome e nome Studente" class="col-xs-10 col-sm-5">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Classe </label>

                <div class="col-sm-9">
                    <input type="text" name="classe" id="classe" placeholder="Classe" class="col-xs-10 col-sm-5">
                </div>
            </div>
            <!--div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email </label>

                <div class="col-sm-9">
                    <input type="text" name="email" id="email" placeholder="Email" class="col-xs-10 col-sm-5">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Telefono </label>

                <div class="col-sm-9">
                    <input type="text" name="tel" id="tel" placeholder="Telefono" class="col-xs-10 col-sm-5">
                </div>
            </div-->

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Materia: </label>
                <select id="mid" name="mid">
                    <option value="" >Seleziona una materia</option>
                    <?php
                    foreach ($data['materie'] as $mid => $mnome) {

                        echo "<option value=\"" . $mid . "\" >" . $mnome . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Docente </label>
                <select id="did" name="did">
                    <option value="" >---</option>
                </select>
            </div>

            <div class="form-group">
                <span id="infos"></span>
                <input type="hidden" name="selected" id="selected" value="" />
            </div>

              <br />
    
            
            <input type="hidden" name="uid" value="<?php echo $data['uid']; ?>">
        <br>

        <div id='calendar'></div><br> <br>

        <button type="submit" name="button" id="button" class="btn btn-success">Invia</button>
        </form>


<?php
$data['content'] = ob_get_contents();
ob_end_clean();
?>