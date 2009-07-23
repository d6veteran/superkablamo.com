// HACK: make Edit this work?



(function() {

    // preview requires 'a' tag with link to freebase
    $.fn.freebaseMiniTopicPreview = function() {
	return this.each(function() {
	    var miniTopicNode = this;
	    //var aNode = $('a', miniTopicNode);
	    $('a',miniTopicNode).after(' <a href="#">[preview]</a> ');

	    $('a:last',miniTopicNode)
	    .click(runMiniTopicPreivew);
	    
	});
    };
	
   

    function hidePreview() {
	var previewLink = this;
	var containerNode = previewLink.parentNode;
	$('.jqmWindow',containerNode).jqmHide();
    }

    function runMiniTopicPreivew() {
	var previewLink = this;
	var containerNode = previewLink.parentNode;

	if ( $('.jqmWindow',containerNode).length ) {
	    $('.jqmWindow',containerNode).jqmShow(); //if the dialog has already been created then just show it
	} else {
	    $(previewLink).after('<div class="jqmWindow"><div class="fbase-bm-window-header"><div id="fbase-bm-logo">Freebase</div><a href="" class="jqmClose">x</a></div><div class="fbase-bm-header">Add a Freebase MiniTopic to this Page</div><div>miniTopic goes here</div></div> ')

	    var topciId = idFromHref(containerNode);
	    $('div:contains(miniTopic goes here):last',containerNode).freebaseMiniTopic(topciId);
	    $('.jqmWindow',containerNode).jqm().jqmShow();
	}

	return false; // don't follow link
    }
    //	    var minitopicDiv = $(this).find('span')[0];
//	    runMiniTopic(minitopicDiv,topicId);
//	    $(minitopicDiv).parent().jqm()


    
    $.fn.freebaseMiniTopic = function(fbaseId) {
	return this.each(function() {
	    var topicId = fbaseId || idFromHref(this);
	    runMiniTopic(this,topicId);
	});
    };

    function idFromHref(div) {
	var href = $('a',div)[0].href;
	var fbaseId = href.replace(/http:.+freebase\.com\/view\//,'');
	if (fbaseId.indexOf('/') != 0) { fbaseId = '/topic/en/'+fbaseId; }   // convert 'edinburgh' to '/topic/en/edinburgh'
	//TODO: put more robust ID tests here
	if (!fbaseId) { error(div,'Could not find Freebase Topic ID in url '+href); }
	return fbaseId;
    }

    function error(div,message) {
	$(div).append( '<div style="color:red;">Error: '+message+'</div>');
    }

    /*************/
    /* AJAX part */
    /*************/


   /* $.fn.getReleaseDate=function(ttopicId,tguid,tname){
	
	strguid=tguid;
	strname=tname;
	strtopicId=ttopicId;
	var json = getDate(ttopicId);

	$.ajax({
	    url: 'http://www.freebase.com/api/service/mqlread',
	    dataType: "jsonp",
	    cache: false, 
	    success: date_det,
	    data: { query: json }
	});
	
	function date_det(response){
		
	  	if(response.result.initial_release_date.length>0){
			strdate = response.result.initial_release_date[0].value;
			funccall();		
		}else{
			document.getElementById('miniTopic').innerHTML = '<strong><center>NO DATA FOUND</center></strong>';
		}
		
		
	}
	function get_id(strtopicId){
		return strtopicId;
	}
			
	
	
	
   }

  
     function getDate(topicId) {	
	var json = '{'+
	'   "query":{'+
	'   "initial_release_date" : [{'+
	'   }],'+
	'   "id":"'+topicId+'",'+
	'   "type" : "/film/film"'+
	'   }'+
	'}';
	
	// Remove all whitespace (also inside quotes but this doesn't matter for my query)
	var compressed = json.replace(/\s+/g,'');
	return compressed;
    }	*/

  //  function runMiniTopic(miniTopicDiv,topicId) {

  $.fn.getReleaseDate=function(ttopicId,tguid,tname){
	
	strguid=tguid;
	strname=tname;
	strtopicId=ttopicId;
	
	var json = getQuery(ttopicId);
	
	$.ajax({
	    url: 'http://www.freebase.com/api/service/mqlread',
	    dataType: "jsonp",
	    cache: true, // don't append _=23233434 to url
	    success: starring_det,
	    data: { queries: json }
	});

	function starring_det(response){
 	        values = response.q1.result;
		
		if(values == null){
			
			document.getElementById('miniTopic').innerHTML="<strong><center>NO DATA FOUND</center></strong><br/><br/><br/>";
			return;
		}
		query_string="{";
	  	 if (response.code != '/api/status/ok') { 
			document.getElementById('miniTopic').innerHTML="<strong><center>NO DATA FOUND</center></strong><br/><br/><br/>";
			return;
 	  	 }else if (!response.q1.result) { 
			document.getElementById('miniTopic').innerHTML="<strong><center>NO DATA FOUND</center></strong><br/><br/><br/>";
			return;;
	         }else{
				
		/*if(values.initial_release_date.length > 0){
			query_string+='"initial_release_date":"'+ values.initial_release_date[0].value+'",';
		}*/

		if(values.initial_release_date.length > 0){
			query_string+='"initial_release_date":"'+ values.initial_release_date[0].value+'",';
		}else{
			document.getElementById('miniTopic').innerHTML="<strong><center>NO DATA FOUND</center></strong><br/><br/><br/>";
			return;;
	         }

		if(values.directed_by.length>0){
			query_string+='"directed_by":['
			for(i=0;i<values.directed_by.length;i++){
				query_string+='{"name":"'+ values.directed_by[i].name+'"},';
			}
			var strLen = query_string.length;
			if(query_string.charAt(strLen-1)==',')
				query_string=query_string.slice(0,strLen-1);
			query_string+='],';
		}
		if(values.starring.length>0){
			query_string+='"starring":['
			for(i=0;i<values.starring.length;i++){
				if(values.starring[i].actor){
					var actor_name = values.starring[i].actor;
					for(j=0;j<actor_name.length;j++){
						actor_nam = actor_name.replace('"',"");
						actor_name = actor_nam;					
					}
					query_string+='{"actor":"'+actor_name+'",';
				}else{
					query_string+='{"actor":"null",';
				}
			
				if(values.starring[i].character){
					var char_name = values.starring[i].character;
					for(k=0;k<char_name.length;k++){
						char_nam = char_name.replace('"',"");
						char_name = char_nam;					
					}
					query_string+='"character":"'+char_nam+'"},';
				}else{
					query_string+='"character":"null"},';
				}
			}
			var strLen = query_string.length;
			if(query_string.charAt(strLen-1)==',')
				query_string=query_string.slice(0,strLen-1);
			query_string+='],';
		}
		if(values.produced_by.length>0){
			query_string+='"produced_by":['
			for(i=0;i<values.produced_by.length;i++){
				query_string+='{"name":"'+ values.produced_by[i].name+'"},';
			}
			var strLen = query_string.length;
			if(query_string.charAt(strLen-1)==',')
				query_string=query_string.slice(0,strLen-1);
			query_string+='],';
		}
		if(values.written_by.length>0){
			query_string+='"written_by":['
			for(i=0;i<values.written_by.length;i++){
				query_string+='{"name":"'+ values.written_by[i].name+'"},';
			}
			var strLen = query_string.length;
			if(query_string.charAt(strLen-1)==',')
				query_string=query_string.slice(0,strLen-1);
			query_string+='],';
		}
		if(values.story_by.length>0){
			query_string+='"story_by":['
			for(i=0;i<values.story_by.length;i++){
				query_string+='{"name":"'+ values.story_by[i].name+'"},';
			}
			var strLen = query_string.length;
			if(query_string.charAt(strLen-1)==',')
				query_string=query_string.slice(0,strLen-1);
			query_string+='],';
		}
		if(values.cinematography.length>0){
			query_string+='"cinematography":['
			for(i=0;i<values.cinematography.length;i++){
				query_string+='{"name":"'+ values.cinematography[i].name+'"},';
			}
			var strLen = query_string.length;
			if(query_string.charAt(strLen-1)==',')
				query_string=query_string.slice(0,strLen-1);
			query_string+='],';
		}
		if(values.genre.length>0){
			query_string+='"genre":['
			for(i=0;i<values.genre.length;i++){
				query_string+='{"name":"'+ values.genre[i].name+'"},';
			}
			var strLen = query_string.length;
			if(query_string.charAt(strLen-1)==',')
				query_string=query_string.slice(0,strLen-1);
			query_string+='],';
		}
		if(values.country.length>0){
			query_string+='"country":['
			for(i=0;i<values.country.length;i++){
				query_string+='{"name":"'+ values.country[i].name+'"},';
			}
			var strLen = query_string.length;
			if(query_string.charAt(strLen-1)==',')
				query_string=query_string.slice(0,strLen-1);
			query_string+='],';
		}
		if(values.rating.length > 0){
			query_string+='"rating":"'+ values.rating[0].name+'",';
		}
		if(values.netflix_id.length > 0){
			query_string+='"netflix_id":"'+ values.netflix_id[0].value+'"';
		}
		if(query_string.charAt(strLen-0)==',')
				query_string=query_string.slice(0,strLen-0);
		query_string+='}';
		

		var nam = strname;
		film_name=nam.replace(/[';!:\?,$&]?/g,"");
		for(i=0;i<film_name.length;i++){
			film_nam = film_name.replace("*","-");
			film_name = film_nam;
		}

		query_string=query_string.replace(/[';!\?$&]?/g,"");
		
		$.get("http://"+document.domain+"/film_search/details?qvalue="+query_string+"&id="+strtopicId+"&name="+film_name+"&guid="+strguid.substring(1),null,func,'html');	

		//$.get("http://localhost/filmography/film_search/details?qvalue="+query_string+"&id="+strtopicId+"&name="+film_name+"&guid="+strguid.substring(1),null,func,'html');

		//$.get("http://localhost/filmography/film_search/details?qvalue="+query_string+"&id="+topicId,null,func,'html');
		//alert("http://localhost/filmography/film_search/details?qvalue="+query_string+"&id="+topicId);

	  }
		function func(data){
			location.href=data;
		}
		
		
     }







	function mqlread_cb(response) {
		
	    if (response.code != '/api/status/ok') { error(miniTopicDiv,'Freebase error: mqlread failed'); return; }
	    if (!response.q1.result) { error(miniTopicDiv,'mqlread: empty result'); return; }
	    var summary = processResult(response.q1);
	    var html = makeHtml(response.q1,summary);
	    $(miniTopicDiv).html(html);
	   // doBlurb(response.q1);*/
	}

	function doBlurb(query) {
	    var articles = $.map(
		query.result['/type/reflect/any_master'],
		function(m) {
		    if (m.link.master_property.id=='/common/topic/article') { return m;}
		});
	    
	    if (articles.length) {
		var article_id = articles[0].id;
		$.ajax({
		    url: 'http://www.freebase.com/api/trans/blurb/'+article_id,
		    dataType: "jsonp",
		    cache: true, // don't append _=23233434 to url
		    success: blurb_cb,
		    data: { maxlength: 300 }
		});
		
	    } else {
		//miniTopicReady();
	    }
	}

	function blurb_cb(response) {
	    var text = response.result.body;     //TODO: deal with error codes
	    $('.fbase-mt-desc',miniTopicDiv).text(text); 
	    //miniTopicReady();
	}

    }

    function getQuery(topicId) {
	/*var json = '{'+
	    '  "q1":{'+
	    '    "query":{'+
	    '	"/type/reflect/any_master":[{'+
	    '	    "id":null,'+
	    '	    "link":{"master_property":{"id":null,"name":null}},'+
	    '	    "name":null,'+
	    '           "optional":true'+
	    '	}],'+
	    '	"/type/reflect/any_reverse":[{'+
	    '	    "id":null,'+
	    '	    "link":{"master_property":{ "reverse_property":{"id":null,"name":null}}},'+
	    '	    "name":null,'+
	    '           "optional":true'+
	    '	}],'+
	    '	"/type/reflect/any_value":[{'+
	    '	    "link":{"master_property":{"id":null,"name":null}},'+
	    '           "optional":true,'+
	    '	    "value":null'+
	    '	}],'+
	    '	"id":"'+topicId+'",'+
	    '   "starring" : [{'+
	    '   "*" : null'+
	    '   }],'+
	    '   "type" : "/film/film"'+
	    '    }'+
	    '  }'+
	    '}';*/
	    var json = '{'+
	'   "q1":{'+
	'   "query":{'+
	'   "name" : null,'+
	'   "initial_release_date" : [{'+
	'   }],'+
	'   "directed_by" : [{'+
	'   }],'+
	'   "id":"'+topicId+'",'+
	'   "starring" : [{'+
        '   "*" : null'+
	'   }],'+
	'   "produced_by" : [{'+
	'   }],'+
	'   "written_by" : [{'+
	'   }],'+
	'   "story_by" : [{'+
	'   }],'+
	'   "music" : [{'+
	'   }],'+
	'   "cinematography" : [{'+
	'   }],'+
	'   "genre" : [{'+
	'   }],'+
	'   "country" : [{'+
	'   }],'+
	'   "rating" : [{'+
	'   }],'+
	'   "netflix_id" : [{'+
	'   }],'+
	'   "type" : "/film/film"'+
	'   }'+
	'   }'+
	'}';

	// Remove all whitespace (also inside quotes but this doesn't matter for my query)
	var compressed = json.replace(/\s+/g,'');
	return compressed;
    }

    /*********************/
    /* Data manipulation */
    /*********************/

    function processResult(query) {
	// convert the complex response into 3 lists of { name, id, label }

	//  { /type/reflect/any_value[].link.master_property. name,value } --> [ {label,name} ]
	// NB: We cheat here and call the value 'name' so that values can be treated the same as reverses or masters
	var values = $.map(
	    query.result['/type/reflect/any_value'],
	    function(m) { 
		if (!isBoring(m.link.master_property.id)) {
		    return {label:m.link.master_property.name, name:m.value}; 
		} else { return undefined; }
	    });

	// { /type/reflect/any_reverse[]. name, id, link.master_property.reverse_property.name --> [ {name, id, label} ]
	var reverses = $.map(
	    query.result['/type/reflect/any_reverse'],
	    function(m) { 
		if (m.name && !isBoring(m.link.master_property.reverse_property.id)) { // some of the reverse links don't store the name, just the id of the topic. Eg. Spouse
		    return {name:m.name, id:m.id, label:m.link.master_property.reverse_property.name }; 
		} else { return undefined; }
	    });

	// { /type/reflect/any_master[]. name, id, link.master_property.name } --> [ { name, id, label } ]
	var masters = $.map(
	    query.result['/type/reflect/any_master'],
	    function(m) { 
		if (!isBoring(m.link.master_property.id)) {
		    return {name:m.name, id:m.id, label:m.link.master_property.name}; 
		} else { return undefined; }
	    });

	var summary={};
	var all = masters.concat(reverses,values); // add values and reverses into masters.

	$.each(all,function() {shove(summary,this.label,this) }); // group by label N.B. assume labels are unique!
	return summary;

    }

    // is this a boring property?
    function isBoring(typeId) {
	if (typeId.indexOf('/type/object/') == 0) { return true; } // permission & type
	if (typeId.indexOf('/common/topic') == 0) { return true; } // alias, image, article, web links
	return false;
    }

    // enables array['not existing yet'].push(val);
    function shove(array,prop,val) {
	if (!array[prop]) { array[prop] = []; } //initalise
	array[prop].push(val);
    }


    /*******************************/
    /*        HTML Generation      */
    /*******************************/

   

    function makeHtml(query,summary) {
	
	var starring =	query.result.starring;
	
	var h=[]; // html

	h[h.length]='<div id="newdiv"><table class="fbase-mt-box"><tr><td><div>';
	//h[h.length]='<div class="fbase-mt-tag">freebase</div>';

	
	if(starring.length >0){
		starring_det(starring,h);
	}

	doImage(h,query);

	//h[h.length]='<div class="fbase-mt-body">';
	//h[h.length]='<div class="fbase-mt-head"><a href="http://www.freebase.com/view/'+query.result.id+'" class="fbase-mt-link">'+query.result.name+'</a></div>';
	//h[h.length]='<div class="fbase-mt-desc"></div>'; // blurb is loaded later
	//h[h.length]='</div>';

	doPlist(h,summary,starring);

	doNav(h,query.result.id);

	var html=h.join('');
	return html;
    }

     
    function doLink(topic) {
	var h=[];
	h[h.length]='<span class="fbase-mt-value">';
	if (topic.id) { h[h.length] = topic.name; }//'<a class="fbase-mt-link" href="http://www.freebase.com/view/'+topic.id+'">'+topic.name+'</a>'; }
	else          { h[h.length] = topic.name; } // (.value is renamed .name)
	h[h.length]='</span>'
	return h.join('');
    }

    function doPlist(h,summary,starring) {
	var MAX_CHARS = 100 - 3;
	var MAX_ENTRIES = 100;
	var entries=0;
	h[h.length]='<div class="fbase-mt-plist">';
	$.each(summary, function(label) {
	    entries++;
	    if (entries>MAX_ENTRIES) { return; }
		
	    if((label == "Initial release date") || (label == "Directed by") || (label == "Produced by") || (label == "Screenplay by") || (label == "Story by") || (label == "Music by") || (label == "Cinematography") || (label == "Genres") || (label == "Genre") || (label == "Country of origin") || (label == "Rated") || (label == "Notable filming locations")){
	    h[h.length] = '<div class="fbase-mt-prop" >'; 
	    h[h.length] = '<br><span class="fbase-mt-name">'+ label +'</span><br><br>';
	    var len=label.length;
	    var trimmed = $.map(this, function(topic) { len += ('<br>'+topic.name).length+1; if (len<MAX_CHARS) { return topic; } } )
	    h[h.length] = $.map(trimmed, doLink).join('<br>');
	    var missing = this.length - trimmed.length;
	    if (missing) { h[h.length] = '...'; }
	    h[h.length] = '</div>'; // end fbase-mt-prop
 	    }
	});
	h[h.length]='</div>'; // end fbase-mt-plist
    }

    function doImage(h,query) {
	var images = $.map(query.result['/type/reflect/any_master'], function(m) { if (m.link.master_property.id=='/common/topic/image') { return m;} } );
	if (images.length) {
	    var image_id = images[0].id;
	    var image_title = images[0].name || 'Image of ???'; //TODO: use topic name
	    h[h.length]='<table align="right"><tr><td><div class="fbase-mt-imgframe">';
	    h[h.length]='<img src="http://www.freebase.com/api/trans/image_thumb/'+image_id+'?maxwidth=250&maxheight=8000" alt="'+image_title+'" title="'+image_title+'" border="0" class="fbase-mt-img" />';
	    h[h.length]='</div></td></tr></table>';
	}
	// else ??
    }

    function doNav(h,id) {
	/*h[h.length]='<div class="fbase-mt-nav">';
	h[h.length]='<a onclick="return (function(link) {window.freebase_link=link; var e = document.createElement(\'script\'); e.src=\'http://mqlx.com/bookmarklets/miniTopic/loaders/load_iframe_editor.js\'; document.body.appendChild(e); return false; })(this);" href="http://www.freebase.com/view/'+id+'" class="fbase-mt-link">Edit This!</a> ';
	h[h.length]='<a href="http://www.freebase.com/view/'+id+'" class="fbase-mt-link">More on Freebase &raquo;</a>';
	h[h.length]='</div>'; //end fbase-mt-nav
	h[h.length]='</div></td></tr></table>'; //end fbase-mt-box*/
    }


    // WILL: TODO: modify query so I can get name of topic
    //function getEnglishName(result) {
    //return result.name.USE GREP!( function(name) {return name.lang=='/lang/en'})[0].value;
    //}
})(jQuery);

