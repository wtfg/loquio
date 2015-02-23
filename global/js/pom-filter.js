/**
 * maschera
 + seleziona numero giorni campo:       days_num
 + quali sono i giorni? campo:          days[]
 + criteri (niente, blocchi, canali):   criterion
 + N insiemi a cui assegnare docenti:   set[0..days][]
 + ricorreggi esporta
 */
var _form = "#form";
var steps = ["#step1", "#step2", "#step3", "#step4"];
var days_array = [];
var days_n = 0;
var current_step = 0;

function step1() {

}
function step2() {
    days_n = $("#days_num").val();
    // alert(days_n);

    var _html = "";
    for (i = 0; i < days_n; i++) {
        _html += '<div class="control-group"><div class="row-fluid input-append"><input class="span10 date-picker" id="day' + i + '"  name="days[]" type="text" data-date-format="dd-mm-yyyy"><span class="add-on"><i class="icon-calendar"></i></span></div></div>';
    }

    $("#step2").html(_html);
    $('.date-picker').datepicker({orientation: "top right", autoclose: true}).next().on(ace.click_event, function () {
        $(this).prev().focus();
    });
}
function step3() {
    var inputs = document.getElementsByClassName('date-picker');
    window.days_array = [].map.call(inputs, function (input) {
        return input.value;
    });

    $("#criterion").change(function(){
        if($("#criterion").val() != "none"){
            $("#criterion-type").show();
        }else{
            $("#criterion-type").hide().val("");
        }
    });
    _html = "";
    for (i = 0; i < days_n; i++) {
        options = "";
        for (id in teachers) {
            options += "<option value=\"" + id + "\">" + teachers[id] + "</option>\n";
        }
        _html += '<div class="row-fluid"><label for="form-field-select-4">' + days_array[i] + '</label><select multiple="multiple" class="form-control" name="set[' + i + '][]">' + options + '</select></div>';
    }
    $("#step4").html(_html);
}
function step4(){}
$(document).ready(function () {
    $("fieldset").hide();
    $("#criterion-type").hide();
    $(steps[current_step]).show();
    $("#nextbutton").click(function () {

        $(steps[current_step]).hide();
        current_step++;
        if(current_step==steps.length){
            $(_form).submit();
        }
        //(steps[current_step].substr(1));
        _call(steps[current_step].substr(1));
        $(steps[current_step]).show();
    });

});
function _call(str) {
    window[str]();
}
$(function () {
    $('.date-picker').datepicker({orientation: "top right", autoclose: true}).next().on(ace.click_event, function () {
        $(this).prev().focus();
    });
});