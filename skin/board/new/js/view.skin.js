$(function(){

	$('#view_skin a.download').on('click', function(){

		var $download = parseInt($(this).attr('rel'));
		if($download >= 0){
			return true;
		}

		if(g5_is_member == ''){
			window.alert('로그인 이후에 이용할 수 있습니다.');
			return false;
		}

		if(window.confirm(number_format(String($download)) + ' 포인트를 1회에 한하여 차감합니다.\n\n그래도 다운로드받겠습니까?') == true){
			$(this).attr('href', $(this).attr('href') + '&js=on');
			return true;
		} else{
			return false;
		}

	});

	$('#view_skin a.view_image').on('click', function(){

		window.open($(this).attr('href'), '', 'top=0, left=0, width=100, height=100, scrollbars=auto');
		return false;

	});

	$('#view_skin div.content').viewimageresize();

	$('#view_skin a.copy, #view_skin a.move').on('click', function(){

		window.open($(this).attr('href'), 'copy_move', 'top=0, left=0, width=500, height=500, scrollbars=auto');
		return false;

	});

	$('#view_skin a.delete').on('click', function(){

		del($(this).attr('href'));
		return false;

	});

	$('#view_skin a.good, #view_skin a.nogood').on('click', function(){

		var $object = $(this).children('span');
		$.ajax({
			url: $(this).attr('href'),
			type: 'post',
			data: {js: 'on'},
			dataType: 'json',
			success: function(data){
				if(data.error){
					window.alert(data.error);
				} else if(data.count){
					$object.text(number_format(String(data.count)));
				}
			}
		});
		return false;

	});

	$('#view_skin a.scrap').on('click', function(){

		win_scrap($(this).attr('href'));
		return false;

	});

});