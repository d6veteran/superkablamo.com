// $Id: fivestarextra-admin.js,v 1.1 2008/10/27 12:34:28 likeless Exp $

/**
 * Fivestarextra admin interface enhancments.
 */
if (Drupal.jsEnabled) {
  $(document).ready(function() {
    
    function fivestarextra_noderestrict_nodetypes() {
      if ($('#edit-fivestar-noderestrict-enable').attr('checked')) {
        $('div.fivestarextra_noderestrict_nodetypes input').
          attr('disabled', false);
      }
      else {
        $('div.fivestarextra_noderestrict_nodetypes input').
          attr('disabled', 'disabled');
      }
    }
    
    $('#edit-fivestar-noderestrict-enable')
      .change( fivestarextra_noderestrict_nodetypes );
    
    fivestarextra_noderestrict_nodetypes();
    function hideUnwanted() {
    var numText =  $("#edit-fivestar-stars1").val();
//    alert(numText);
     for(cnt=1;cnt<=10;cnt++){
     	if(cnt>numText)
     		$("#fivestar1-label-"+cnt).hide();
     	else
     		$("#fivestar1-label-"+cnt).show();
     	
     
     }
    }
	
  $("#edit-fivestar-stars1").change(function(){
  hideUnwanted();
//  alert($(this).val());
   //$.get('getformelement/ajax?num='+$(this).val(),null,responsehandler,'text');
  });
    hideUnwanted();
    
  });
  
};
