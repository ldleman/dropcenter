var blockNewFolder = false;
var pendingTask = false;
$(function(){


	$(document).ajaxStop(function() {
		$('.preloader').hide();
	});
	$(document).ajaxStart(function() {
  		$('.preloader').show();
	});


	getFiles();
	addedFiles = Array();




$('.tooltips').poshytip({
		className: 'tooltip',
		showTimeout: 0,
		alignTo: 'target',
		alignX: 'center',
		offsetY: 10,
		allowTipHover: false
	});

	 imageExtension = Array();
		imageExtensionRoot = 'tpl/UnderBlack/img/extension/';
		imageExtensionMiniRoot = 'img/extension_mini/';
		imageExtension['sql']='sql.png';
		imageExtension['zip']='zip.png';
		imageExtension['rar']='rar.png';
		imageExtension['tar.gz']='archive.png';
		imageExtension['7z']='zip.png';
		imageExtension['gzip']='gzip.png';
		imageExtension['php']='php.png';
		imageExtension['py']='py.png';
		imageExtension['jsp']='html.png';
		imageExtension['html']='html.png';
		imageExtension['htm']='html.png';
		imageExtension['css']='css.png';
		imageExtension['java']='java.png';
		imageExtension['cpp']='cpp.png';
		imageExtension['c']='c.png';
		imageExtension['h']='h.png';
		imageExtension['hpp']='hpp.png';
		imageExtension['js']='js.png';
		imageExtension['rss']='rss.png';
		imageExtension['rb']='rb.png';
		imageExtension['vcard']='authors.png';
		imageExtension['exe']='exe.png';
		imageExtension['deb']='package.png';
		imageExtension['psd']='psd.png';
		imageExtension['nfo']='readme.png';
		imageExtension['csv']='calc.png';
		imageExtension['xls']='calc.png';
		imageExtension['xlsx']='calc.png';
		imageExtension['ppt']='pres.png';
		imageExtension['pptx']='pres.png';
		imageExtension['doc']='doc.png';
		imageExtension['odf']='doc.png';
		imageExtension['docx']='doc.png';
		imageExtension['otf']='doc.png';
		imageExtension['rtf']='rtf.png';
		imageExtension['txt']='txt.png';
		imageExtension['log']='log.png';
		imageExtension['src']='source.png';
		imageExtension['tex']='tex.png';
		imageExtension['bin']='bin.png';
		imageExtension['cd']='cd.png';
		imageExtension['sh']='script.png';
		imageExtension['bash']='script.png';
		imageExtension['bat']='script.png';
		imageExtension['vcal']='vcal.png';
		imageExtension['ical']='vcal.png';
		imageExtension['mp3']='playlist.png';
		imageExtension['avi']='playlist.png';
		imageExtension['mp4']='video.png';
		imageExtension['webm']='video.png';
		imageExtension['wmv']='video.png';
		imageExtension['mkv']='video.png';
		imageExtension['rpm']='rpm.png';
		imageExtension['tiff']='tiff.png';
		imageExtension['jpg']='jpg.png';
		imageExtension['jpeg']='jpg.png';
		imageExtension['png']='png.png';
		imageExtension['gif']='gif.png';
		imageExtension['bmp']='bmp.png';
		imageExtension['ico']='ico.png';
		imageExtension['eps']='draw.png';
		imageExtension['ai']='eps.png';
		imageExtension['pdf']='pdf.png';
		imageExtension['xml']='xml.png';
		imageExtension['fla']='makefile.png';
		imageExtension['swf']='makefile.png';
	
	var dropbox = $('.message'),
		message = $('.message', dropbox);
	
	dropbox.filedrop({
		// The name of the $_FILES entry:
		paramname:'pic',
		
		maxfiles: 10000000000,
    	maxfilesize: 10000000,
		url: 'php/action.php?action=upload',
		
		uploadFinished:function(i,file,response){
			$.data(file).addClass('done');
			/*alert(response.filePath);
			alert(response.file);*/
			addedFiles.push(response);
			if(!response.succes)tell(response.status);
			// response is the JSON object that post_file.php returns
		},
		
    	error: function(err, file) {
			switch(err) {
				case 'BrowserNotSupported':
					tell('Vous avez essay&eacute; d\'envoyer autre chose qu\'un fichier ou votre naviguateur ne supporte pas l\'upload en HTML5! (ps : DropCenter fonctionne tr&egrave;s bien sur des navigateurs s&eacute;rieux tels que google chrome ou firefox.)');
					break;
				case 'TooManyFiles':
					tell('Trops de fichiers envoy&eacute;s en m&ecirc;me temps');
					break;
				case 'FileTooLarge':
					tell(file.name+' est trop gros! ');
					break;
				default:
					break;
			}
		},
		
		afterAll: function() {
			var events = Array();
			for(i=0;i<addedFiles.length;i++){
				events.push([addedFiles[i]['file'],addedFiles[i]['filePath']]);
			}

			//rafraichissement du bousin
			getFiles(null,'//CURRENT');

			//enregistrement de l'evenement
			$.ajax({
				  url: "php/action.php?action=addEventForUpload",
				  data:{files:array2json(events)}
			});
			pendingTask = false;

		},

		// Called before each upload is started
		beforeEach: function(file){
		},
		
		uploadStarted:function(i, file, len){
			createImage(file);
			pendingTask = true;
		
		},
		
		progressUpdated: function(i, file, progress) {
			$.data(file).find('.progress').width(progress);
		}
    	 
	});

	
	var template = '<div class="preview">'+
						'<span class="imageHolder">'+
							'<img />'+'<span class="uploaded"></span>'+
							'<span class="fileName"></span>'+
						'</span>'+
						'<div class="progressHolder">'+
							'<div class="progress"></div>'+
						'</div>'+
					'</div>'; 
	

		
	function createImage(file){
		var preview = $(template), 
			image = $('img', preview);
			fileName = $('.fileName', preview);
		image.width = 48;
		image.height = 48;
		var extension = file.name.split('.');
		if(extension.length==1){
		extension = null;
		}else{
		extension = extension[extension.length-1];
		}
		fileName.html(file.name);
			if(imageExtension[extension]!=null){
				ext = imageExtensionRoot+imageExtension[extension] ;
			}else{
				ext = imageExtensionRoot+'unknown.png';
			}
			image.attr('src',ext);
		preview.appendTo($("#dropbox"));	
		$.data(file,preview);
	}

	function showMessage(msg){
		message.html(msg);
	}
	
	checkVersion();

});




function checkPendingTask(){
	if(pendingTask){
		alert('Certaines tâches sont encore en cours d\'execution, vous risquez de perdre des données.');
	}
}

function generateBreadCrumb(folder){
	returned = '';
	if(folder!=null){
	var dissolvedPath = explode('/',str_replace('../','',folder));
	var path = '../'; 
	for(i=0;i<dissolvedPath.length;i++){
		if(dissolvedPath[i]!=''){
			path +=dissolvedPath[i]+'/';
			returned +='<li alt="'+addslashes(path)+'" onclick="getFiles(null,\''+addslashes(path)+'\')">'+dissolvedPath[i]+'</li>';
		}
	}

	}
	return returned;
}
	function getFiles(keywords,folder){
		$('#dropbox .preview,.tooltip').remove();

		
		if(keywords==null){keywords='';}else{keywords = "&keywords="+keywords}
		if(folder==null){folderVar='';}else{folderVar = "&folder="+folder}
		$.ajax({
		url: "php/action.php?action=getFiles"+keywords+folderVar,
		success: function(returnedValue){
		
		
		response = $.parseJSON(returnedValue);
		if(response.succes){
		
		$('.breadcrumb').html(generateBreadCrumb(response.currentFolder));
		
		t= response.status;

		for(i=0;i<t.length;i++){
   			addFile(t[i]);
		}

		$('.imageHolder,.imageHolder .addOptions li,.lien,.folderHolder').poshytip({
		className: 'tooltip',
		showTimeout: 0,
		alignTo: 'target',
		alignX: 'center',
		offsetY: 10,
		allowTipHover: false
		});
		
		
		$('.fileOption').click(function(){getFileOption(this);});

		$(".imageHolder").draggable({ revert: "invalid" });
		
		
		$( ".folderPreview" ).droppable({
			activeClass: "folderPreviewDroppableHover",
			hoverClass: "folderPreviewDroppableHover",
			drop: function( event, ui ) {
				var parent = $( ui.draggable ).parent();
				var fileUrl = $('.fileUrl',parent).html();
				var fileName = $('.fileName',parent).attr('alt');
				var folder = $('.fileUrl',this).html();
				
				$.ajax({
				  url: "php/action.php?action=moveFile",
				  data:{fileName:fileName,fileUrl:fileUrl,folder:folder},
				  success: function(response){
					var response = $.parseJSON(response);
						parent.fadeOut(300);
						tell(response.status);
				  }
				});

				
			}
		});



   	}
  }
});
	

	}
	

	function addFile(file){
			if(imageExtension[file.extension]!=null){
				ext = imageExtensionRoot+imageExtension[file.extension] ;
			}else{
				ext = imageExtensionRoot+'unknown.png';
			}
		
			if(file.type=='folder')ext = imageExtensionRoot+'folder-page.png';
			if(file.name=='..')ext = imageExtensionRoot+'folder-parent.png';



		


					if(file.type=='file'){

	var tpl = '<div  class="preview filePreview" >'+
						'<div class="fileUrl">'+stripslashes(file.url)+'</div>'+
						'<span title="'+stripslashes(file.toolTipName)+'" class="imageHolder"><div onclick="deleteFile(this)" class="deleteFile">x</div>'+
							
							'<div onclick="focusFile(this)"  ondblclick="openFile(this)">'+

							'<img width="48px" height="48px"  src="'+ext+'"/>'+
							'<ul>'+
								'<li>Taille: '+file.size+'</li>'+
								'<li>Maj : '+file.mtimeDate+'</li>'+
								'<li>Heure: '+file.mtimeHour+'</li>'+
							
							'</ul>'+

							'</div>'+
							'<ul><li class="fileOption">+Options</li></ul>'+

							'<span ondblclick="renameFile(this)\" title="'+stripslashes(file.name)+'" alt="'+stripslashes(file.name)+'"  class="fileName">'+stripslashes(file.shortname)+'</span>'+
						'<div class="addOptions">'+
						'<ul>'+
						'<li onclick="$(\'.directLink\',$(this).parent().parent().parent()).fadeToggle(200).select();" alt="Copier le lien direct" title="Copier le lien direct" class="optionUrl"></li>'+
						//'<li alt="Envoyer par mail" title="Envoyer par mail" class="optionShare"></li>'+
						//'<li alt="Editer la source" title="Editer la source" class="optionEdit"></li>'+
						'<li onclick="zipFile(this)" alt="T&eacute;l&eacute;charger le fichier" title="T&eacute;l&eacute;charger le fichier" class="optionZip"></li>'+
						//'<li alt="Envoyer sur dropbox" title="Envoyer sur dropbox" class="optionDropbox"></li>'+
						'</ul><div class="clear"></div></div>'+
						'<textarea type="text" class="directLink">'+stripslashes(file.absoluteUrl)+'</textarea>'+
						'</span>'+
						'</div>'; 


					}else if(file.type=='folder'){
						var tpl = '<div  class="preview folderPreview">'+
						'<div class="fileUrl">'+stripslashes(file.url)+'</div>'+
						'<span title="'+stripslashes(file.name)+'" class="folderHolder ">';
						if(file.name!='..') tpl += '<div onclick="deleteFile(this)" class="deleteFile">x</div>';
							tpl += '<img width="48px" height="48px" onclick="getFiles(null,$(\'.fileUrl\',$(this).parent().parent()).html())" src="'+ext+'"/>'+
							'<span ';
							if(file.name!='..') tpl +='ondblclick="renameFile(this)\"';
							tpl += ' title="'+stripslashes(file.name)+'" alt="'+stripslashes(file.name)+'"  class="fileName">'+stripslashes(file.shortname)+'</span>'+
							'</span></div>'; 
					}




		$('#dropbox').append(tpl);
	}

function zipFile(element){
	var parent = $(element).parent().parent().parent().parent();
	var file =$('.fileUrl',parent).html();
	 file = html_entity_decode(file);
		$.ajax({
  url: "php/action.php?action=zipFile",
  data:{file:file},
  success: function(response){
	var response = $.parseJSON(response);
	if(response.succes==true){
		window.location= './'+response.status;
	}else{
		tell(response.status);
	}
  }
});
}




function addFolder(){

	if(!blockNewFolder){
		blockNewFolder = true;
	$('.newFolder').hide();
	$.ajax({
		async:false,
  url: "php/action.php?action=addFolder",
  data:{name:$('input[name="folderName"]').val()},
  success: function(response){
	var response = $.parseJSON(response);
	if(response.succes==true){
		getFiles(null,'//CURRENT');

	}else{
		tell(response.status,0);
	}
  }
});

	$('.newFolder').fadeIn(300);
	blockNewFolder = false;
	}
}


function deleteUser(message,id){
	if(confirm(message))window.location="php/action.php?action=deleteUser&user="+id;
}



function tell(message,time){
	var fix = false;
	if(time==null)time = 3000;
	if(time==0)fix = true;
	var options = {
	position: 'top-right',
        timeout: time,
        sticky: fix
	};
	TINYPOP.show(message,options);
}




function openFile(element){

	var parent = $(element).parent().parent();
	var file = str_replace('&amp;','&',$('.fileUrl',parent).html());
	window.open(file);
}

function focusFile(element){
	var parent = $(element).parent().parent();
	$('.imageHolder').css("color","#C9C9C9");
	$('.imageHolder').css("font-weight","normal");
	$('.imageHolder',parent).css("color","#ffffff");
	$('.imageHolder',parent).css("font-weight","bold");
}



function deleteFile(element){

	var parent = $(element).parent().parent();
	var file =$('.fileUrl',parent).html();
	 file = html_entity_decode(file);
		$.ajax({
  url: "php/action.php?action=deleteFiles",
  data:{file:file},
  success: function(response){
  var response = $.parseJSON(response);
  	tell(response.status);
	if(response.succes)$(element).parent().parent().fadeOut(300);
	
  }
});
	}

	function searchFiles(){
		var keywords = $('input[name="search"]').val();
		keywords = keywords.replace(' ',',');
		keywords = keywords.split(',');
		getFiles(keywords);
	}
	
	function renameFile(element){
		parent = $(element).parent();
		file = $('.fileUrl',parent.parent()).html();
		value = $('.fileName',parent).attr("title");
		$('.fileName',parent).html('');
		$('.fileName',parent).append('<input type="text" value="'+value+'" class="fileNameArea">');
		pressEnter('.fileNameArea',function(){
		newValue = $('.fileNameArea',parent).val();
		
		if(newValue!=value){
		
		$.ajax({
  url: "php/action.php?action=renameFile",
  data:{file:file,newName:newValue},
  success: function(response){
  var response = $.parseJSON(response);
	if(!response.succes){
		tell(response.status);
		$('.fileName',parent).html(value);
	}else{
		$('.fileName',parent).html(newValue);
		$('.fileName',parent).attr("title",newValue);
		$('.fileName',parent).attr("alt",newValue);
		$('.fileUrl',parent.parent()).html($('.fileUrl',parent.parent()).html().replace(value,newValue));
		
		parent.poshytip('destroy');
		parent.attr("title",newValue);
		parent.poshytip({

			content:newValue,
		className: 'tooltip',
		showTimeout: 0,
		alignTo: 'target',
		alignX: 'center',
		offsetY: 10,
		allowTipHover: false


		});



	}
	
  }
});
	
	}else{
		$('.fileName',parent).html(value);
	}
		});
	}
	
	function checkVersion(){
	if(typeof(lastVersion) != 'undefined' && typeof(lastVersionNumber) != 'undefined' && typeof(lastVersionName) != 'undefined' && typeof(lastVersionUrl) != 'undefined'){
		   $.ajax({
		  url: "php/action.php?action=checkVersion",
		  success: function(response){
		  if(response<lastVersionNumber || (typeof(specialMessage)!= 'undefined' && specialMessage!='')){
		  
		  var status= 'La nouvelle version '+lastVersion+' ('+lastVersionName+' - N&deg; '+lastVersionNumber+') de DropCenter est <a target="_blank" href="'+lastVersionUrl+'">disponible ici.</a>'
			
			if(typeof(specialMessage)!= 'undefined' && specialMessage!='') status = specialMessage;
			
			$('#versionBloc').html(status);
			$('#versionBloc').fadeIn(300);
			}}});
	}
}
	
	
function pressEnter(input,func){
var  testTextBox = $(input);
        var code =null;
        testTextBox.keypress(function(e)
        {
            code= (e.keyCode ? e.keyCode : e.which);
            if (code == 13) func();
           // e.preventDefault();
        });

}  

function getFileOption(elem){
	$(elem+":parent .addOptions").fadeToggle();
}

function explode(delimiter,string,limit){var emptyArray={0:''};if(arguments.length<2||typeof arguments[0]=='undefined'||typeof arguments[1]=='undefined'){return null;}
if(delimiter===''||delimiter===false||delimiter===null){return false;}
if(typeof delimiter=='function'||typeof delimiter=='object'||typeof string=='function'||typeof string=='object'){return emptyArray;}
if(delimiter===true){delimiter='1';}
if(!limit){return string.toString().split(delimiter.toString());}
var splitted=string.toString().split(delimiter.toString());var partA=splitted.splice(0,limit-1);var partB=splitted.join(delimiter.toString());partA.push(partB);return partA;}
function str_replace(search,replace,subject,count){var i=0,j=0,temp='',repl='',sl=0,fl=0,f=[].concat(search),r=[].concat(replace),s=subject,ra=Object.prototype.toString.call(r)==='[object Array]',sa=Object.prototype.toString.call(s)==='[object Array]';s=[].concat(s);if(count){this.window[count]=0;}
for(i=0,sl=s.length;i<sl;i++){if(s[i]===''){continue;}
for(j=0,fl=f.length;j<fl;j++){temp=s[i]+'';repl=ra?(r[j]!==undefined?r[j]:''):r[0];s[i]=(temp).split(f[j]).join(repl);if(count&&s[i]!==temp){this.window[count]+=(temp.length-s[i].length)/f[j].length;}}}
return sa?s:s[0];}
function addslashes(str){return(str+'').replace(/[\\"']/g,'\\$&').replace(/\u0000/g,'\\0');}
function stripslashes(str){return(str+'').replace(/\\(.?)/g,function(s,n1){switch(n1){case'\\':return'\\';case'0':return'\u0000';case'':return'';default:return n1;}});}

function html_entity_decode (string, quote_style) {
    var hash_map = {},
        symbol = '',
        tmp_str = '',
        entity = '';    tmp_str = string.toString();
 
    if (false === (hash_map = this.get_html_translation_table('HTML_ENTITIES', quote_style))) {
        return false;
    } 
    delete(hash_map['&']);
    hash_map['&'] = '&amp;'; 
    for (symbol in hash_map) {
        entity = hash_map[symbol];
        tmp_str = tmp_str.split(entity).join(symbol);
    }    tmp_str = tmp_str.split('&#039;').join("'");
 
    return tmp_str;
}
function get_html_translation_table (table, quote_style) {
    var entities = {},
        hash_map = {},        decimal;
    var constMappingTable = {},
        constMappingQuoteStyle = {};
    var useTable = {},
        useQuoteStyle = {}; 
    constMappingTable[0] = 'HTML_SPECIALCHARS';
    constMappingTable[1] = 'HTML_ENTITIES';
    constMappingQuoteStyle[0] = 'ENT_NOQUOTES';    constMappingQuoteStyle[2] = 'ENT_COMPAT';
    constMappingQuoteStyle[3] = 'ENT_QUOTES';
 
    useTable = !isNaN(table) ? constMappingTable[table] : table ? table.toUpperCase() : 'HTML_SPECIALCHARS';
    useQuoteStyle = !isNaN(quote_style) ? constMappingQuoteStyle[quote_style] : quote_style ? quote_style.toUpperCase() : 'ENT_COMPAT'; 
    if (useTable !== 'HTML_SPECIALCHARS' && useTable !== 'HTML_ENTITIES') {
        throw new Error("Table: " + useTable + ' not supported');
    } 
    entities['38'] = '&amp;';
    if (useTable === 'HTML_ENTITIES') {
        entities['160'] = '&nbsp;';
        entities['161'] = '&iexcl;';        entities['162'] = '&cent;';
        entities['163'] = '&pound;';
        entities['164'] = '&curren;';
        entities['165'] = '&yen;';
        entities['166'] = '&brvbar;';        entities['167'] = '&sect;';
        entities['168'] = '&uml;';
        entities['169'] = '&copy;';
        entities['170'] = '&ordf;';
        entities['171'] = '&laquo;';        entities['172'] = '&not;';
        entities['173'] = '&shy;';
        entities['174'] = '&reg;';
        entities['175'] = '&macr;';
        entities['176'] = '&deg;';        entities['177'] = '&plusmn;';
        entities['178'] = '&sup2;';
        entities['179'] = '&sup3;';
        entities['180'] = '&acute;';
        entities['181'] = '&micro;';        entities['182'] = '&para;';
        entities['183'] = '&middot;';
        entities['184'] = '&cedil;';
        entities['185'] = '&sup1;';
        entities['186'] = '&ordm;';        entities['187'] = '&raquo;';
        entities['188'] = '&frac14;';
        entities['189'] = '&frac12;';
        entities['190'] = '&frac34;';
        entities['191'] = '&iquest;';        entities['192'] = '&Agrave;';
        entities['193'] = '&Aacute;';
        entities['194'] = '&Acirc;';
        entities['195'] = '&Atilde;';
        entities['196'] = '&Auml;';        entities['197'] = '&Aring;';
        entities['198'] = '&AElig;';
        entities['199'] = '&Ccedil;';
        entities['200'] = '&Egrave;';
        entities['201'] = '&Eacute;';        entities['202'] = '&Ecirc;';
        entities['203'] = '&Euml;';
        entities['204'] = '&Igrave;';
        entities['205'] = '&Iacute;';
        entities['206'] = '&Icirc;';        entities['207'] = '&Iuml;';
        entities['208'] = '&ETH;';
        entities['209'] = '&Ntilde;';
        entities['210'] = '&Ograve;';
        entities['211'] = '&Oacute;';        entities['212'] = '&Ocirc;';
        entities['213'] = '&Otilde;';
        entities['214'] = '&Ouml;';
        entities['215'] = '&times;';
        entities['216'] = '&Oslash;';        entities['217'] = '&Ugrave;';
        entities['218'] = '&Uacute;';
        entities['219'] = '&Ucirc;';
        entities['220'] = '&Uuml;';
        entities['221'] = '&Yacute;';        entities['222'] = '&THORN;';
        entities['223'] = '&szlig;';
        entities['224'] = '&agrave;';
        entities['225'] = '&aacute;';
        entities['226'] = '&acirc;';        entities['227'] = '&atilde;';
        entities['228'] = '&auml;';
        entities['229'] = '&aring;';
        entities['230'] = '&aelig;';
        entities['231'] = '&ccedil;';        entities['232'] = '&egrave;';
        entities['233'] = '&eacute;';
        entities['234'] = '&ecirc;';
        entities['235'] = '&euml;';
        entities['236'] = '&igrave;';        entities['237'] = '&iacute;';
        entities['238'] = '&icirc;';
        entities['239'] = '&iuml;';
        entities['240'] = '&eth;';
        entities['241'] = '&ntilde;';        entities['242'] = '&ograve;';
        entities['243'] = '&oacute;';
        entities['244'] = '&ocirc;';
        entities['245'] = '&otilde;';
        entities['246'] = '&ouml;';        entities['247'] = '&divide;';
        entities['248'] = '&oslash;';
        entities['249'] = '&ugrave;';
        entities['250'] = '&uacute;';
        entities['251'] = '&ucirc;';        entities['252'] = '&uuml;';
        entities['253'] = '&yacute;';
        entities['254'] = '&thorn;';
        entities['255'] = '&yuml;';
    } 
    if (useQuoteStyle !== 'ENT_NOQUOTES') {
        entities['34'] = '&quot;';
    }
    if (useQuoteStyle === 'ENT_QUOTES') {        entities['39'] = '&#39;';
    }
    entities['60'] = '&lt;';
    entities['62'] = '&gt;';
 
    for (decimal in entities) {
        if (entities.hasOwnProperty(decimal)) {
            hash_map[String.fromCharCode(decimal)] = entities[decimal];        }
    }
 
    return hash_map;
}

function array2json(arr) {
    var parts = [];
    var is_list = (Object.prototype.toString.apply(arr) === '[object Array]');

    for(var key in arr) {
    	var value = arr[key];
        if(typeof value == "object") { //Custom handling for arrays
            if(is_list) parts.push(array2json(value)); /* :RECURSION: */
            else parts[key] = array2json(value); /* :RECURSION: */
        } else {
            var str = "";
            if(!is_list) str = '"' + key + '":';

            //Custom handling for multiple data types
            if(typeof value == "number") str += value; //Numbers
            else if(value === false) str += 'false'; //The booleans
            else if(value === true) str += 'true';
            else str += '"' + value + '"'; //All other things
            // :TODO: Is there any more datatype we should be in the lookout for? (Functions?)

            parts.push(str);
        }
    }
    var json = parts.join(",");
    
    if(is_list) return '[' + json + ']';//Return numerical JSON
    return '{' + json + '}';//Return associative JSON
}