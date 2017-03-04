//li background changing color for the list of FT members
$( document ).ready(function() {

	$("#tree-details-frame").on("load", function () {
    
   	var url = document.getElementById("tree-details-frame").contentWindow.location.href;
    	var id = url.match(/id=(\d+)$/);

		if(id != null){

			$(".ft_members").css("background-color","#222223");
    		$("#member"+id[1]).css("background-color","#c8c8ca");

    		var parentIdString = $("#member"+id[1]).parent().attr("id");
    		var parentIdInt = parentIdString.match(/^(\d+)-member-list/);


			//If the newly selected name is invisible, make it visible
			if(!$('#'+parentIdInt[1]+'-member-list > li').is(':visible')){

				collapseExpandTree(parentIdInt[1]);
			}
    	}
    });
});

/*------------------------------------------------------------------------------------
 *	refreshFTFrame(id) - refresh the Family Tree member details iframe 
 *------------------------------------------------------------------------------------*/
function refreshFTFrame(id) {

	var ftFrame = document.getElementById('tree-details-frame');
	ftFrame.src = "/?pg=ft_frame&id="+id;
}

/*------------------------------------------------------------------------------------
 * collapseExpandTree(id) - Collapse/Expand the Family Tree Sub-families
 *------------------------------------------------------------------------------------*/
function collapseExpandTree(id){

	var members = $('#'+id+'-member-list > li');

   var myDropdown = $('#myDropdown');
   var arrowDirection;

	if(members.is(':visible')){

		members.hide();
      arrowDirection = 'down';
	}
	else if(!members.is(':visible')){

		members.show();
      arrowDirection = 'up';
	}

   $('#'+id+'-fam-arrow').attr('src', '/images/'+arrowDirection+'_arrow_12x12.png');
}
