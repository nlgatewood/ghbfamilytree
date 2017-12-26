$(document).ready(function() {

	//popup when a member of the 'newPopup' class is clicked
	$('.newPopup').click(function (event){
 
		var url = $(this).attr("href");
		var windowName = "popUp";
		var winVars = "height=700,width=1000,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no";

		var popup = window.open(url, windowName, winVars);
 		popup.focus();
 
		event.preventDefault();
    });
   
   /*---------------------------------------
    * When ft_form is submitted, generate the
    * query string
    *---------------------------------------*/
	$("#ft_form").submit( function(eventObj) {

		var queryArray = [];

		//Remove any search
		$('.search-input').each(function(index,obj){

			var type = $(this).attr('type');
			var name = $(this).attr('name');
         var id = $(this).attr('id');
			var fldObject = $('[name='+name+']');

			//For radio fields, add the selected value
			if(type == "radio"){

				if($("input[id="+id+"]:checked").val() != undefined){

					queryArray.push(name+":"+$("input[name="+name+"]:checked").val());
				}
			}
			//For all the other fields, add the value
			else if(fldObject.val() != ""){

				queryArray.push(name+":"+fldObject.val());
			}

			//"Remove" the get field
      	fldObject.attr("disabled","disabled");
		});

		//Create the query field
		if(queryArray.length > 0){

	      $('<input />').attr('type', 'hidden')
	      				  .attr('name', "query")
	         			  .attr('value', queryArray.join('~'))
	         			  .appendTo('#ft_form');
	      	return true;
		}
  	});
});

/*------------------------------------------------------------------------------------
 * clearSearchFields() - Clear the search fields in the Family Tree search box
 *------------------------------------------------------------------------------------*/
function clearSearchFields() {
 
	$('.search-input').each(function(index,obj){

		var type = $(this).attr('type');
		var name = $(this).attr('name');
       
      //Clear the radio buttons
      if(type == "radio"){
       
      	$(this).prop('checked', false);
      }
		// Change search spec back to exact
      else if(name == "search_spec"){

			$(this).val("exact");
		}
		// Change the sort by back to name
      else if(name == "sort_by"){

			$(this).val("name");
		}
      //Clear everything else
		else{
      	$(this).val("");
      }
    });
 }

/*------------------------------------------------------------------------------------
 * popupWindow(url, name) - create/open a pop-up window with the passed 'url' and 'name' 
 *------------------------------------------------------------------------------------*/
function popupWindow(url, name) {

   popupWindow = window.open(url, name,'height=700,width=1000,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
   popupwindow.focus();
}

//Unused, but may use in the future or use for reference

/*------------------------------------------------------------------------------------
 * selectFamilyMember() - selects and focuses the family member the user selected
 *------------------------------------------------------------------------------------*/
/*
function selectFamilyMember(){

	var url = $(location).attr('href');
   var id = url.match(/mid=(\d+)$/);

	if(id != null){

		var parentIdString = $("#member"+id[1]).parent().attr("id");
		var parentIdInt = parentIdString.match(/^(\d+)-member-list/);

		$(".ft-members-header > li").css("background-color","#222223");
		$("#member"+id[1]).css("background-color","#c8c8ca");

		//If the newly selected name is invisible, make it visible
		if(!$('#'+parentIdInt[1]+'-member-list > li').is(':visible')){

			collapseExpandTree(parentIdInt[1]);
		}

		//Get the position of the selected element and move the div to that location
		var newPos = document.getElementById("member"+id[1]).offsetTop - document.getElementById("tree-members").offsetTop;
		$("#tree-members").scrollTop(newPos);
	}
}
*/

/*------------------------------------------------------------------------------------
 *	refreshFTFrame(id) - refresh the Family Tree member details iframe 
 *------------------------------------------------------------------------------------*/
/*
function refreshFTFrame(id) {

	var ftFrame = document.getElementById('tree-member-iframe');
	ftFrame.src = "/?pg=ft_frame&id="+id;
}
*/

/*------------------------------------------------------------------------------------
 * collapseExpandTree(id) - Collapse/Expand the Family Tree Sub-families
 *------------------------------------------------------------------------------------*/
/*
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
*/

