
function showDropdownMenu() {

	var myDropdown = $('#myDropdown');
	var arrowDirection;

	document.getElementById('myDropdown').classList.toggle('show');

	if(myDropdown.hasClass('show')){

		arrowDirection = 'up';
	}
	else{
		arrowDirection = 'down';
	}

	$('#fam-menu-arrow').attr('src', '/images/'+arrowDirection+'_arrow_12x12.png');
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {

	if (!event.target.matches('.dropbtn')) {

   	var dropdowns = document.getElementsByClassName('dropdown-content');
      var i;

      for (i = 0; i < dropdowns.length; i++) {
      
			var openDropdown = dropdowns[i];
         
			if (openDropdown.classList.contains('show')) {
         	openDropdown.classList.remove('show');
				$('#fam-menu-arrow').attr('src', '/images/down_arrow_12x12.png');
         }
		}
	}

}
