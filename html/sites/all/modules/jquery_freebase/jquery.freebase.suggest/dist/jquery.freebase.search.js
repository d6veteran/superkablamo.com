function runMiniTopic(miniTopicDiv,topicId) {	
	$.ajax({
	    url: 'http://www.freebase.com/api/service/mqlread',
	    dataType: "jsonp",
	    cache: true, // don't append _=23233434 to url
	    success: mqlread_cb,
	    data: { queries: json }
	});
}

	function mqlread_cb(response) {
		
	    if (response.code != '/api/status/ok') { error(miniTopicDiv,'Freebase error: mqlread failed'); return; }
	    if (!response.q1.result) { error(miniTopicDiv,'mqlread: empty result'); return; }
	    var summary = processResult(response.q1);
	    var html = makeHtml(response.q1,summary);
	    $(miniTopicDiv).html(html);
	   // doBlurb(response.q1);
	}
  


function makeHtml(query,summary) {
	alert(query.result.name);
	
	var h=[]; // html

	h[h.length]='<table class="fbase-mt-box"><tr><td><div>';
	h[h.length]='<div class="fbase-mt-tag">freebase</div>';

	doImage(h,query);

	//h[h.length]='<div class="fbase-mt-body">';
	h[h.length]='<div class="fbase-mt-head"><a href="http://www.freebase.com/view/'+query.result.id+'" class="fbase-mt-link">'+query.result.name+'</a></div>';
	//h[h.length]='<div class="fbase-mt-desc"></div>'; // blurb is loaded later
	//h[h.length]='</div>';

	doPlist(h,summary);

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

    function doPlist(h,summary) {
	var MAX_CHARS = 100 - 3;
	var MAX_ENTRIES = 10;
	var entries=0;
	h[h.length]='<div class="fbase-mt-plist">';
	$.each(summary, function(label) {
	    entries++;
	    if (entries>MAX_ENTRIES) { return; }
	    h[h.length] = '<div class="fbase-mt-prop">';
	    h[h.length] = '<br><span class="fbase-mt-name">'+ label +'</span><br><br>';
	    var len=label.length;
	    var trimmed = $.map(this, function(topic) { len += ('<br>'+topic.name).length+1; if (len<MAX_CHARS) { return topic; } } )
	    h[h.length] = $.map(trimmed, doLink).join('<br>');
	    var missing = this.length - trimmed.length;
	    if (missing) { h[h.length] = '...'; }
	    h[h.length] = '</div>'; // end fbase-mt-prop
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
