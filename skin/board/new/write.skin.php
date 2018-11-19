<?php

add_stylesheet("<link rel=\"stylesheet\" href=\"{$board_skin_url}/css/write.skin.css\" />", 0);
add_javascript("<script src=\"{$board_skin_url}/js/write.skin.js\"></script>", 0);
if($is_member){
	add_javascript("<script src=\"" . G5_JS_URL . "/autosave.js\"></script>", 0);
	add_javascript($editor_content_js, 0);
}

?>

<script>
function editor_js(){
	<?php echo $editor_js; ?>
	return true;
}
function captcha_js(){
	<?php echo $captcha_js; ?>
	return true;
}
</script>

<form id="write_skin" name="fwrite" method="post" action="<?php echo $action_url; ?>" enctype="multipart/form-data" style="width: <?php echo $width; ?>;">

	<h1 class="title"><?php echo $board['bo_subject']; ?></h1>

	<table class="write">
		<tbody>
			<?php if($is_name){ ?>
			<tr>
				<th>
					<img src="<?php echo $board_skin_url; ?>/img/required.png" alt="필수입력" />
					작성자
				</th>
				<td><input type="text" name="wr_name" value="<?php echo $name; ?>" title="작성자" class="required" /></td>
			</tr>
			<?php } ?>
			<?php if($is_password){ ?>
			<tr>
				<th>
					<?php if($password_required){ ?>
					<img src="<?php echo $board_skin_url; ?>/img/required.png" alt="필수입력" />
					<?php } ?>
					비밀번호
				</th>
				<td><input type="password" name="wr_password" <?php if($password_required) echo 'title="비밀번호" class="required"'; ?> /></td>
			</tr>
			<?php } ?>
			<?php if($is_email){ ?>
			<tr>
				<th>이메일</th>
				<td><input type="text" name="wr_email" value="<?php echo $email; ?>" title="이메일" class="email wide" /></td>
			</tr>
			<?php } ?>
			<?php if($is_homepage){ ?>
			<tr>
				<th>홈페이지</th>
				<td><input type="text" name="wr_homepage" value="<?php echo $homepage; ?>" class="full" /></td>
			</tr>
			<?php } ?>
			<?php if($is_category){ ?>
			<tr>
				<th>
					<img src="<?php echo $board_skin_url; ?>/img/required.png" alt="필수입력" />
					분류
				</th>
				<td>
					<select name="ca_name" title="분류" class="required">
						<option value="">선택하세요</option>
						<?php echo $category_option; ?>
					</select>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<th>
					<img src="<?php echo $board_skin_url; ?>/img/required.png" alt="필수입력" />
					제목
				</th>
				<td>
					<input type="text" id="wr_subject" name="wr_subject" value="<?php echo $subject; ?>" title="제목" class="required full" />
					<?php if($is_member){ ?>
					<button id="btn_autosave" type="button" name="open">불러오기 (<span id="autosave_count"><?php echo $autosave_count; ?></span>)</button>
					<div>
						<div id="autosave_pop">
							<p>
								<span>제목을 클릭하면 임시로 저장된 글을 불러올 수 있습니다.</span>
								<img src="<?php echo $board_skin_url; ?>/img/close.png" alt="닫기" class="autosave_close" />
							</p>
							<ul></ul>
						</div>
					</div>
					<?php } ?>
				</td>
			</tr>
			<?php for($num = 1, $key = 1; $is_link && $key <= G5_LINK_COUNT; $num++, $key++){ ?>
			<tr>
				<th>링크 #<?php echo $num; ?></th>
				<td><input type="text" name="wr_link<?php echo $key; ?>" value="<?php echo $write['wr_link' . $key]; ?>" class="full" /></td>
			</tr>
			<?php } ?>
			<?php for($num = 1, $key = 0; $is_file && $key < $file_count; $num++, $key++){ ?>
			<tr>
				<th>파일 #<?php echo $num; ?></th>
				<td>
					<input type="file" name="bf_file[]" />
					<?php if($w == 'u' && $file[$key]['file']){ ?>
					<label><input type="checkbox" name="bf_file_del[<?php echo $key; ?>]" value="1" /> <?php echo $file[$key]['source']; ?> 삭제</label>
					<?php } ?>
				</td>
			</tr>
			<?php if($is_file_content){ ?>
			<tr>
				<th>파일 #<?php echo $num; ?> 설명</th>
				<td><input type="text" name="bf_content[]" value="<?php if($w == 'u' && $file[$key]['bf_content']) echo $file[$key]['bf_content']; ?>" class="wide" /></td>
			</tr>
			<?php } ?>
			<?php } ?>
			<?php if($is_guest){ ?>
			<tr>
				<th>
					<img src="<?php echo $board_skin_url; ?>/img/required.png" alt="필수입력" />
					자동등록방지
				</th>
				<td><?php echo $captcha_html; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>

	<div class="content">
		<?php
		echo $editor_html;
		if($is_notice){
			echo "<label><input type=\"checkbox\" name=\"notice\" value=\"1\" {$notice_checked} /> 공지글</label>";
		}
		if($is_secret){
			if($is_admin || $is_secret == 1){
				echo "<label><input type=\"checkbox\" name=\"secret\" value=\"secret\" {$secret_checked} /> 비밀글</label>";
			} else{
				echo "<input type=\"hidden\" name=\"secret\" value=\"secret\" />";
			}
		}
		if($is_html){
			if($is_dhtml_editor){
				echo "<input type=\"hidden\" name=\"html\" value=\"html1\" />";
			} else{
				echo "<label><input type=\"checkbox\" name=\"html\" value=\"{$html_value}\" {$html_checked} /> HTML</label>";
			}
		}
		if($is_mail){
			echo "<label><input type=\"checkbox\" name=\"mail\" value=\"mail\" {$recv_email_checked} /> 답변메일</label>";
		}
		if($write_min || $write_max){
			echo "<strong>현재 <span id=\"char_count\"></span>글자 (";
			if($write_min){
				echo "최소 {$write_min}글자부터";
			}
			if($write_min && $write_max){
				echo ' ';
			}
			if($write_max){
				echo "최대 {$write_max}글자까지";
			}
			echo ")</strong>";
		}
		?>
	</div>

	<p class="button">
		<input type="submit" name="save" value="저장하기" />
		<a href="board.php?bo_table=<?php echo $bo_table; ?>">목록보기</a>
	</p>

	<fieldset>
		<input type="hidden" name="token" />
		<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>" />
		<input type="hidden" name="w" value="<?php echo $w; ?>" />
		<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>" />
		<input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>" />
		<input type="hidden" name="sca" value="<?php echo $sca; ?>" />
		<input type="hidden" name="sfl" value="<?php echo $sfl; ?>" />
		<input type="hidden" name="stx" value="<?php echo $stx; ?>" />
		<input type="hidden" name="sst" value="<?php echo $sst; ?>" />
		<input type="hidden" name="sod" value="<?php echo $sod; ?>" />
		<input type="hidden" name="sop" value="<?php echo $sop; ?>" />
		<input type="hidden" name="spt" value="<?php echo $spt; ?>" />
		<input type="hidden" name="page" value="<?php echo $page; ?>" />
		<input type="hidden" name="char_min" value="<?php echo (int)$write_min; ?>" />
		<input type="hidden" name="char_max" value="<?php echo (int)$write_max; ?>" />
	</fieldset>

</form>