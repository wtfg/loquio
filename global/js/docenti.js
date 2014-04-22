
container = "#container";
str = "";
cleaning = false;
debug = false;
orelibere = "#orelibere";
$(document).ready(function() {
    js = JSON.parse($("#orelibere").val());

    days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
    giorni = ["Lun", "Mar", "Mer", "Gio", "Ven", "Sab", "Dom"];
    timeslot = ["8:00", "8:15", "8:30", "8:45", "9:00", "9:15", "9:30", "9:45",
        "10:00", "10:15", "10:30", "10:45", "11:00", "11:15", "11:30", "11:45",
        "12:00", "12:15", "12:30", "12:45", "13:00", "13:15", "13:30", "13:45",
        "14:00", "14:15", "14:30", "14:45", "15:00", "15:15", "15:30", "15:45",
        "16:00", "16:15", "16:30", "16:45", "17:00", "17:15", "17:30", "17:45",
        "18:00", "18:15", "18:30", "18:45", "19:00", "19:15", "19:30", "19:45"];
    for (i in days) {
        var day = days[i];
        var giorno = giorni[i];
        jgiorno = (js[day] !== undefined) ? js[day].seats : 0;
        str += '<div style="text-align:center;background-color:#fafafa; padding:5px; margin:1px; width:10%; display:inline-block; "><div class="th">' + giorno + '</div>';
        str += '<br /><label style="font-size:11px" for="' + day + 'Max">Max pren.</label> <input name="' + day + 'Max" type="text" value="' + jgiorno + '" id="' + day + 'Max" size="2" maxlength="2" />  <br /><br />';
        for (t in timeslot) {
            var time = timeslot[t];
            var checked = "";
            if (js[day] !== undefined) {
                if (js[day].timeslot.indexOf(time) !== -1) {
                    checked = 'checked="checked"';
                }
            }
            str += '<label for="' + day + time + '">' + time + ' </label><input type="checkbox" ' + checked + ' name="' + day + time + '" id="' + day + time + '" /><br />';
        }
        str += "</div>"
    }
    $(container).html(str);
    function clean() {
        newjs = {};
        for (dy in js) {
            if (js[dy].seats == 0) {
                if (debug) {
                    alert("seats di " + dy + " e zero");
                }
                // alert(JSON.stringify(js));
                ts = ts.replace(":", "\\:");
                alert(ts);
                for (i in timeslot) {
                    var ts = timeslot[i];
                    if ($("#" + dy + ts).prop("checked")) {
                        cleaning = true;
                        $("#" + dy + ts).click();
                        cleaning = false;
                    }
                }
            } else {
                newjs[dy] = js[dy];
            }


        }

        js = newjs;
    }


    $("input").each(function() {
        $(this).change(function() {
            selectedDay = $(this).attr("id").substring(0, 3);
            if ($(this).attr("id").substring(3) == "Max") {
                if (a = parseInt($(this).val())) {

                    if (js[selectedDay] !== undefined) {

                        js[selectedDay].seats = a;
                    } else {

                        js[selectedDay] = {"seats": a, "timeslot": []}
                    }

                    clean();
                    if (debug) {
                        alert(JSON.stringify(js));
                    }
                    $(orelibere).val(JSON.stringify(js));

                } else {
                    js[selectedDay].seats = 0;
                    $(this).val(0);
                    clean();
                    if (debug) {
                        alert(JSON.stringify(js));
                    }
                    $(orelibere).val(JSON.stringify(js));
                }

            }
        });
        $(this).click(function() {
            if (cleaning) {
                return;
            }
            selectedDay = $(this).attr("id").substring(0, 3);
            timeval = $(this).attr("id").substring(3);

            if (timeval) {
                alert(timeval);
                var buff = [];
                for (i in timeslot) {
                    ts = timeslot[i];

                    if ($("#" + selectedDay + ts.replace(":", "\\:")).prop("checked") == true) {
                        buff.push(ts);

                    }

                }
                alert(buff);
                if (js[selectedDay] !== undefined) {
                    js[selectedDay].timeslot = buff;
                } else {
                    if (a = parseInt($("#" + selectedDay + "Max").val())) {

                    } else {
                        a = 0;
                        $("#" + selectedDay + "Max").val(a);
                    }

                    js[selectedDay] = {"seats": a, "timeslot": buff}

                }

                clean();
                if (debug) {
                    alert(JSON.stringify(js));
                }

                $(orelibere).val(JSON.stringify(js));
            }
        });
    });
});
