
container = "#container";
str = "";
cleaning = false;
debug = false;
orelibere = "#orelibere";
$(document).ready(function() {
    js = JSON.parse($("#orelibere").val());

    days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
    giorni = ["Lun", "Mar", "Mer", "Gio", "Ven", "Sab", "Dom"];
    timeslot = ["8:00", "8:10", "8:20", "8:30", "8:40", "8:50",
        "9:00", "9:10", "9:20", "9:30", "9:40", "9:50",
        "10:00", "10:10", "10:20", "10:30", "10:40", "10:50",
        "11:00", "11:10", "11:20", "11:30", "11:40", "11:50",
        "12:00", "12:10", "12:20", "12:30", "12:40", "12:50",
        "13:00", "13:10", "13:20", "13:30", "13:40", "13:50",
        "14:00", "14:10", "14:20", "14:30", "14:40", "14:50",
        "15:00", "15:10", "15:20", "15:30", "15:40", "15:50"
    ];
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


                for (i in timeslot) {
                    var ts = timeslot[i];
                    if ($("#" + dy + ts.replace(":", "\\:")).prop("checked")) {
                        cleaning = true;
                        $("#" + dy + ts.replace(":", "\\:")).click();
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

                var buff = [];
                for (i in timeslot) {
                    ts = timeslot[i];

                    if ($("#" + selectedDay + ts.replace(":", "\\:")).prop("checked") == true) {
                        buff.push(ts);

                    }

                }

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
