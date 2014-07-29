
container = "#container";
str = "";
cleaning = false;
debug = false;
orelibere = "#value";
$(document).ready(function() {
    js = JSON.parse($(orelibere).val());
    //alert(JSON.stringify(js));
    timeslot = ["8:00", "8:10", "8:20", "8:30", "8:40", "8:50",
        "9:00", "9:10", "9:20", "9:30", "9:40", "9:50",
        "10:00", "10:10", "10:20", "10:30", "10:40", "10:50",
        "11:00", "11:10", "11:20", "11:30", "11:40", "11:50",
        "12:00", "12:10", "12:20", "12:30", "12:40", "12:50",
        "13:00", "13:10", "13:20", "13:30", "13:40", "13:50",
        "14:00", "14:10", "14:20", "14:30", "14:40", "14:50",
        "15:00", "15:10", "15:20", "15:30", "15:40", "15:50"
    ];


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
