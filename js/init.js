(function($){
  $(function(){
  	$('.dropdown-button').dropdown({hover:false});
    $('.button-collapse').sideNav();
    $('select').material_select();

  }); // end of document ready
})(jQuery); // end of jQuery name space

function like_add(project_id) {
	$.post('functions/like_add.php', {project_id:project_id}, function(data) {
		if (data == 'liked') {
			like_get(project_id);
		} else {
			like_remove(project_id);
		}
	});
}

function like_get(project_id) {
	$.post('functions/like_get.php', {project_id:project_id}, function(data) {
		$('i.project-' + project_id).text(data)
									.addClass('liked');
	});
}

function like_remove(project_id) {
	$.post('functions/like_get.php', {project_id:project_id}, function(data) {
		$('i.project-' + project_id).text(data)
									.removeClass('liked');
	});
}