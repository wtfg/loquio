
container = "#container";
str = "";
cleaning = false;
debug = false;
orelibere = "#value";
$(document).ready(function() {
    js = JSON.parse($(orelibere).val());
    //alert(JSON.stringify(js));
    timeslot = ["8:00", "8:15", "8:30", "8:45", "9:00", "9:15", "9:30", "9:45",
        "10:00", "10:15", "10:30", "10:45", "11:00", "11:15", "11:30", "11:45",
        "12:00", "12:15", "12:30", "12:45", "13:00", "13:15", "13:30", "13:45",
        "14:00", "14:15", "14:30", "14:45", "15:00", "15:15", "15:30", "15:45",
        "16:00", "16:15", "16:30", "16:45", "17:00", "17:15", "17:30", "17:45",
        "18:00", "18:15", "18:30", "18:45", "19:00", "19:15", "19:30", "19:45"];


    str = '<div style="text-align:center;background-color:#fafafa; padding:5px; margin:1px; width:10%; display:inline-block; "><div class="th">Orario:</div>';
    //str += '<br /><label style="font-size:11px" for="' + day + 'Max">Max pren.</label> <input name="' + day + 'Max" type="text" value="' + jgiorno + '" id="' + day + 'Max" size="2" maxlength="2" />  <br /><br />';
    for (t in timeslot) {
        var time = timeslot[t];
        var checked = "";
        if (js["timeslot"] !== undefined) {
            if (js["timeslot"].indexOf(time) !== -1) {
                checked = 'checked="checked"';
            }
        }
        str += '<label for="' + time + '">' + time + ' </label><input type="checkbox" ' + checked + ' name="' + time + '" id="' + time + '" /><br />';
    }
    str += "</div>"

    $(container).html(str);
    function clean() {
        newjs = {};
        for (dy in js) {

                newjs[dy] = js[dy];
        }

        js = newjs;
    }


    $("input").each(function() {
        $(this).click(function() {
            if (cleaning) {
                return;
            }
            timeval = $(this).attr("id");

            if (timeval) {
                var buff = [];
                for (i in timeslot) {
                    ts = timeslot[i];
                    if ($("#" + ts.replace(":", "\\:")).prop("checked") == true) {
                        buff.push(ts);
                    }
                }
                js  = {"timeslot": buff}
                clean();
                if (debug) {
                    alert(JSON.stringify(js));
                }

                $(orelibere).val(JSON.stringify(js));
            }
        });
    });
});
