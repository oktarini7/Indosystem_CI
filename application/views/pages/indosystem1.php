<script>
function generate(){
	var c1input = _("c1input").value;
	if(c1input == ""){
		_("status").innerHTML = "Please fill in the input value";
	} else {
		_("c1button").style.display = "none";
		_("status").innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "<?php echo base_url('indosystem1/processc1'); ?>");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	        	_("status").innerHTML = ajax.responseText;
	            _("c1button").style.display = "block";
	        }
        }
        ajax.send("c1input="+c1input);
	}
}
</script>
<hr>
<br />
<form name="challenge1_form" id="challenge1_form" onsubmit="return false;">
    <div>Please enter the size of array preferred: </div>
    <div>(1 &le; input value &le; 25, enter 5 for the result specified in the test)</div>
    <br />
    <input id="c1input" type="number" maxlength="3" size="4"><br />
    <br />
    <button id="c1button" onclick="generate()">Generate</button>
    <p id="status"></p>
 </form>