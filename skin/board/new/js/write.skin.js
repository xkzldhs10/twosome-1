$(function(){

	var $char_min = parseInt($('#write_skin input[name="char_min"]').val());
	var $char_max = parseInt($('#write_skin input[name="char_max"]').val());

	if($char_min > 0 || $char_max > 0){

		check_byte('wr_content', 'char_count');
		$('#wr_content').on('keyup', function(){
			check_byte('wr_content', 'char_count');
		});

	}

	$('#write_skin input[name="html"]').on('click', function(){

		if($(this).prop('checked') == true){
			$(this).val('html2');
		} else{
			$(this).val('html1');
		}
		return true;

	});

	$('#write_skin input[name="save"]').on('click', function(){

		if(editor_js() == false){
			return false;
		}

		var $subject;
		var $content;
		$.ajax({
			url: g5_bbs_url + '/ajax.filter.php',
			type: 'post',
			data: {
				'subject': $('#wr_subject').val(),
				'content': $('#wr_content').val()
			},
			dataType: 'json',
			async: false,
			cache: false,
			success: function(data){
				$subject = data.subject;
				$content = data.content;
			}
		});
		if($subject){
			window.alert('제목 : 금지단어(' + $subject + ')는 입력할 수 없습니다.');
			$('#wr_subject').focus();
			return false;
		}
		if($content){
			window.alert('내용 : 금지단어(' + $content + ')는 입력할 수 없습니다.');
			if(typeof(ed_wr_content) == 'undefined'){
				$('#wr_content').focus();
			} else{
				ed_wr_content.returnFalse();
			}
			return false;
		}

		if($char_min > 0 || $char_max > 0){
			var $char_cnt = parseInt(check_byte('wr_content', 'char_count'));
			if($char_min > 0 && $char_min > $char_cnt){
				window.alert('내용 : 최소 ' + $char_min + ' 글자 이상으로 입력해주세요.');
				if(typeof(ed_wr_content) == 'undefined'){
					$('#wr_content').focus();
				} else{
					ed_wr_content.returnFalse();
				}
				return false;
			}
			if($char_max > 0 && $char_max < $char_cnt){
				window.alert('내용 : 최대 ' + $char_max + ' 글자 이하로 입력해주세요.');
				if(typeof(ed_wr_content) == 'undefined'){
					$('#wr_content').focus();
				} else{
					ed_wr_content.returnFalse();
				}
				return false;
			}
		}

		if(captcha_js() == false){
			return false;
		}
		return true;

	});

});