//é
var blockNewFolder = false;
var pendingTask = false;
$(function(){


	$(document).ajaxStop(function() {
		$('.preloader').fadeOut(200);
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
	
	// var dropbox = $('.message'),
	// 	message = $('.message', dropbox);




	$(function () {
    $('#uploadButton').fileupload({
        dataType: 'json',
        autoUpload: true,
        dropZone : '#uploadButton',
        maxFileSize: 5000000,
        sequentialUploads: true,
        add: function (e, data) {
        	createImage(data.files[0]);
			pendingTask = true;
        	data.submit();
        },
        done: function (e, data) {
        	console.log(data.result);
			addedFiles.push({name:data.files[0].name,size:data.files[0].size,type:data.result.extension,path:data.result.filePath});
        },
       	stop: function (e, data) {
       		//enregistrement de l'evenement
			$.ajax({
				  url: "php/action.php?action=addEventForUpload",
				  data:{files:array2json(addedFiles)}
			});
			addedFiles = Array();
			pendingTask = false;
			//rafraichissement du bousin
			getFiles(null,'//CURRENT');
			
       	},
        progress: function (e, data) {
	         var progress = parseInt(data.loaded / data.total * 100, 10);
	        $.data(data.files[0]).find('.progress').width(progress+'%');
	
    	}
    });
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
						'<span title="'+stripslashes(file.toolTipName)+'" class="imageHolder'+(file.published?' filePublished':'')+'"><div onclick="deleteFile(this)" class="deleteFile">x</div>'+
							
							'<div onclick="focusFile(this)"  ondblclick="openFile(this)">'+

							'<img width="48px" height="48px"  src="'+ext+'"/>'+
							'<ul>'+
								'<li>'+file.size+'</li>'+
								'<li>'+file.mtimeDate+' '+file.mtimeHour+'</li>'+
							
							'</ul>'+

							'</div>'+
							'<ul><li class="fileOption">+Options</li></ul>'+

							'<span ondblclick="renameFile(this)\" title="'+stripslashes(file.name)+'" alt="'+stripslashes(file.name)+'"  class="fileName">'+stripslashes(file.shortname)+'</span>'+
						'<div class="addOptions">'+
						'<ul>'+
						'<li onclick="$(\'.directLink\',$(this).parent().parent().parent()).fadeToggle(200).select();" alt="Copier le lien direct" title="Copier le lien direct" class="optionUrl"></li>'+
						//'<li alt="Envoyer par mail" title="Envoyer par mail" class="optionShare"></li>'+
						//'<li alt="Editer la source" title="Editer la source" class="optionEdit"></li>'+
						'<li onclick="zipFile(this)" alt="T&eacute;l&eacute;charger le fichier compressé" title="T&eacute;l&eacute;charger le fichier compressé" class="optionZip"></li>'+
						'<li onclick="'+(file.published?'un':'')+'publishFile(this)" title="Public/Privé" class="optionDropbox"></li>'+
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


function publishFile(element){
	var parent = $(element).parent().parent().parent().parent();
	var file =$('.fileUrl',parent).html();
	
		$.ajax({
  url: "php/action.php?action=publishFile",
  data:{file:file},
  success: function(response){
	var response = $.parseJSON(response);
	if(response.succes==true){

		$(element).attr('onclick','unpublishFile(this);');
		$(element).parent().parent().parent().addClass('filePublished');

		tell(response.status);
	}else{
		tell(response.status);
	}
  }
});
}

function unpublishFile(element){
	var parent = $(element).parent().parent().parent().parent();
	var file =$('.fileUrl',parent).html();
	
		$.ajax({
  url: "php/action.php?action=unpublishFile",
  data:{file:file},
  success: function(response){
	var response = $.parseJSON(response);
	if(response.succes==true){
		$(element).parent().parent().parent().removeClass('filePublished');
		$(element).attr('onclick','publishFile(this);');
		tell(response.status);
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
	if(response.succes){
		getFiles(null,'//CURRENT');
		$('.folderNameBloc').fadeOut(150);
		$('.folderNameBloc input').val('');
	}else{
		tell(response.status,3000);
	}
  }
});

	$('.newFolder').fadeIn(300);
	blockNewFolder = false;
	}
}


function deleteUser(message,id,tmpToken){
	if(confirm(message))window.location="php/action.php?action=deleteUser&user="+id+"&tmpToken="+tmpToken;
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
	message = '<i style="height: 20px; width: 20px; display: block; float: left; margin-right: 5px;" class="icon-ok"></i>'+message;
	TINYPOP.show(message,options);
}




function openFile(element){
	var parent = $(element).parent().parent();
	var file = $('.fileUrl',parent).html();

	window.location='./php/action.php?action=openFile&file='+file;
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
	 file = file;
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
		var parent = $(element).parent();
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
	$(".addOptions",$(elem).parent().parent()).slideToggle(200);
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