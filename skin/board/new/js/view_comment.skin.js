$(function(){

	$('#view_comment_skin li.reply').each(function(){

		var $left = parseInt($(this).css('padding-left'));
		if($left == 0){
			$left = 20;
		}
		$left += $left * parseInt($(this).attr('rel').length);
		$(this).css('padding-left', $left + 'px');

	});

	var $char_min = parseInt($('#view_comment_skin input.char_min').val());
	var $char_max = parseInt($('#view_comment_skin input.char_max').val());

	if($char_min > 0 || $char_max > 0){

		check_byte('wr_content', 'char_count');
		$('#view_comment_skin').on('keyup', '#wr_content', function(){
			check_byte('wr_content', 'char_count');
		});

	}

	var $form_html = $('#view_comment_form').html();

	$('#view_comment_skin a.reply, #view_comment_skin a.update').on('click', function(){

		var $comment_id = $(this).attr('rel');
		$('#view_comment_skin form.view_comment_form').html('').hide();
		$('#view_comment_form_' + $comment_id).html($form_html).show();
		$('#comment_id').val($comment_id);
		$('#captcha_reload').trigger('click');

		if($(this).attr('class') == 'reply'){
			$('#w').val('c');
		} else{
			$('#w').val('cu');
			$('#wr_content').val($('#wr_content_' + $comment_id).val());
			if($('#wr_secret_' + $comment_id).val()){
				$('#wr_secret').prop('checked', true);
			} else{
				$('#wr_secret').prop('checked', false);
			}
			if($char_min > 0 || $char_max > 0){
				check_byte('wr_content', 'char_count');
			}
		}
		return false;

	});

	$('#view_comment_skin a.delete').on('click', function(){
		return window.confirm('정말로 삭제하겠습니까?');
	});

	$('#view_comment_skin').on('click', 'form.view_comment_form button[name="save"]', function(){

		var $content;
		$.ajax({
			url: g5_bbs_url + '/ajax.filter.php',
			type: 'post',
			data: {'content': $('#wr_content').val()},
			dataType: 'json',
			async: false,
			cache: false,
			success: function(data){
				$content = data.content;
			}
		});
		if($content){
			window.alert('내용 : 금지단어(' + $content + ')는 입력할 수 없습니다.');
			$('#wr_content').focus();
			return false;
		}

		if($char_min > 0 || $char_max > 0){
			var $char_cnt = parseInt(check_byte('wr_content', 'char_count'));
			if($char_min > 0 && $char_min > $char_cnt){
				window.alert('내용 : 최소 ' + $char_min + ' 글자 이상으로 입력해주세요.');
				$('#wr_content').focus();
				return false;
			}
			if($char_max > 0 && $char_max < $char_cnt){
				window.alert('내용 : 최대 ' + $char_max + ' 글자 이하로 입력해주세요.');
				$('#wr_content').focus();
				return false;
			}
		}

		$.ajax({
			url: g5_bbs_url + '/ajax.comment_token.php',
			type: 'GET',
			dataType: 'json',
			async: false,
			cache: false,
			success: function(data){
				$('#token').val(data.token);
			}
		});
		return true;

	});

});