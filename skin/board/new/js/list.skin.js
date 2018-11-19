$(function(){

	$('#bo_cate_on').parent('li').addClass('on');

	$('#list_skin p.subject').each(function(){

		var $height = parseInt($(this).attr('rel'));
		$height -= parseInt($(this).css('height'));
		$height -= parseInt($(this).css('margin-bottom'));
		$height = Math.ceil($height / 16) * 16;
		$(this).next('div').css('height', $height + 'px');

	});

	$('#list_skin input[name="all_wr_id"]').on('click', function(){

		$('#list_skin input[name="chk_wr_id[]"]').prop('checked', $(this).prop('checked'));
		return true;

	});

	$('#list_skin button[name="copy"], #list_skin button[name="move"]').on('click', function(){

		if($('#list_skin input[name="chk_wr_id[]"]:checked').size() == 0){
			window.alert('게시글을 하나 이상 선택해주세요.');
			return false;
		}

		window.open('', 'copy_move', 'top=0, left=0, width=500, height=500, scrollbars=auto');
		var $form = $(this).parents('form');
		$form.find('input[name="sw"]').val($(this).attr('name'));
		$form.find('input[name="btn_submit"]').val($(this).text());
		$form.attr('target', 'copy_move');
		$form.attr('action', g5_bbs_url + '/move.php');
		return true;

	});

	$('#list_skin button[name="delete"]').on('click', function(){

		if($('#list_skin input[name="chk_wr_id[]"]:checked').size() == 0){
			window.alert('게시글을 하나 이상 선택해주세요.');
			return false;
		}

		var $form = $(this).parents('form');
		$form.find('input[name="btn_submit"]').val($(this).text());
		$form.removeAttr('target');
		$form.attr('action', g5_bbs_url + '/board_list_update.php');
		return window.confirm('한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?');

	});

});