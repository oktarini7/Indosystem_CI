<hr>
<br />
<?php echo $hello; ?>
<?php echo $loginout; ?><br />
<hr>
<br />
<script>
function sendWishes(){
	var name = _("name").value;
	var address = _("address").value;
	var phone = _("phone").value;
	var note = _("note").value;
	if(name == "" || address == "" || phone == "" || note == ""){
		_("status").innerHTML = "Fill out all input";
	} else {
    _("status").innerHTML = "";
		_("submitButton").style.display = "none";
		_("status").innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "<?php echo base_url('indosystem3/submitNote'); ?>");
        ajax.onreadystatechange = function() {
            _("submitButton").style.display = "block";
	        if(ajaxReturn(ajax) == true) {
                _("status").innerHTML = ajax.responseText;
                var wish = ajax.responseText.split("|");
                if(wish[0] == "insert_ok"){
                    var id = wish[1];
                    _("status").innerHTML = "Your good wishes have been sent";
                    var currentHTML = _("wishesArea").innerHTML;
                    if(<?php echo $loggedin; ?>){
                      var onewish= '<div class="wishes" id="wish_'+id+'">';
                      onewish+='<div id="name_'+id+'">Name: '+wish[2]+'</div>';
                      onewish+='<div id="address_'+id+'">Address: '+wish[3]+'</div>';
                      onewish+='<div id="phone_'+id+'">Phone: '+wish[4]+'</div>';
                      onewish+='<div id="note_'+id+'">Note: '+wish[5]+'</div>';
                      onewish+='<div id="db_'+id+'"><a href="#" onclick="return false;" onmousedown="deleteNote(\''+id+'\',\'wish_'+id+'\');" title="DELETE NOTE">delete note</a></div></div>';
                      _("wishesArea").innerHTML= onewish+currentHTML;
                    } else {
                      _("wishesArea").innerHTML= '<div class="wishes" id="wish_'+id+'"><div id="name_'+id+'">Name: '+wish[2]+'</div><div id="note_'+id+'">Note: '+wish[5]+'</div></div>'+currentHTML;
                    }
                } else {
                    _("status").innerHTML = ajax.responseText;
                }
	        }
        }
        ajax.send("name="+name+"&address="+address+"&phone="+phone+"&note="+note);
	}
}
function deleteNote(noteid,notebox){
  var conf = confirm("Press OK to confirm deletion of this note");
  if(conf != true){
    return false;
  }
  var ajax = ajaxObj("POST", "<?php echo base_url('indosystem3/deleteNote'); ?>");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      if(ajax.responseText == "delete_ok"){
        _(notebox).style.display = 'none';
      } else {
        alert(ajax.responseText);
      }
    }
  }
  ajax.send("noteid="+noteid);
}

</script>
  <form id="guestnote" onsubmit="return false;">
    <div>Name:</div>
    <input type="text" id="name" size="36">
    <div>Address:</div>
    <textarea form ="guestnote" name="address" id="address" cols="35" rows="2" wrap="soft"></textarea>
    <div>Phone:</div>
    <input type="tel" id="phone" size="36">
 	  <div>Note:</div>
    <textarea form ="guestnote" name="note" id="note" cols="35" rows="5" wrap="soft"></textarea>
    <br /><br />
    <button id="submitButton" onclick="sendWishes()">send wishes</button> 
  </form>
  <p id="status"> </p>
  <hr>
  <br />
  <h2>Wishes List</h2>
  <div id="wishesArea"><?php echo $allWishes; ?></div>