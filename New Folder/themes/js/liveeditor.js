Event.observe(window, 'load', init, false);

function init(){
	makeEditable('livedesc');
}

function makeEditable(id){
	Event.observe(id, 'click', function(){edit(me(id))}, false);
	Event.observe(id, 'mouseover', function(){showAsEditable(me(id))}, false);
	Event.observe(id, 'mouseout', function(){showAsEditable(me(id), true)}, false);
}

function edit(obj){
	Element.hide(obj);

	
	var textarea = '<div id="'+obj.id+'_editor"><input type="text" id="'+obj.id+'_edit" name="'+obj.id+'_edit" value="'+obj.innerHTML+'" />';
	var button	 = '<div><input id="'+obj.id+'_save" type="button" value="SAVE" /> OR <input id="'+obj.id+'_cancel" type="button" value="CANCEL" /></div></div>';
	
	new Insertion.After(obj, textarea+button);	
		
	Event.observe(obj.id+'_save', 'click', function(){saveChanges(obj)}, false);
	Event.observe(obj.id+'_cancel', 'click', function(){cleanUp(obj)}, false);
	
}

function showAsEditable(obj, clear){
	if (!clear){
		Element.addClassName(obj, 'editable');
	}else{
		Element.removeClassName(obj, 'editable');
	}
}

function saveChanges(obj){
	
	var new_content	=  escape($F(obj.id+'_edit'));

	   if ((new_content.length==0) ||

	   (new_content==null)) {

		alert("Language name cannot be blank");

		

		  return false;

	   }

	   

   
	obj.innerHTML	= "Saving... <img src='/themes/css/default/loading.gif' alt='saving'/>";
	cleanUp(obj, true);

	var success	= function(t){editComplete(t, obj);}
	var failure	= function(t){editFailed(t, obj);}

  	var url = '/manage/system/language.php';
	var pars = 'id='+obj.id+'&editlang=1&newname='+new_content;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:success, onFailure:failure, encoding:'UTF-8'});

}

function cleanUp(obj, keepEditable){
	Element.remove(obj.id+'_editor');
	Element.show(obj);
	if (!keepEditable) showAsEditable(obj, true);
}

function editComplete(t, obj){
	obj.innerHTML	= t.responseText;
	showAsEditable(obj, true);
}

function editFailed(t, obj){
	obj.innerHTML	= 'Sorry, the update failed.';
	cleanUp(obj);
}

