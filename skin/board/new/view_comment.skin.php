<?php

add_stylesheet("<link rel=\"stylesheet\" href=\"{$board_skin_url}/css/view_comment.skin.css\" />", 0);
add_javascript("<script src=\"{$board_skin_url}/js/view_comment.skin.js\"></script>", 0);
if($w == 'cu'){
	$comment = sql_fetch("
		SELECT `wr_option`, `wr_content`, `mb_id`
		FROM `{$write_table}`
		WHERE `wr_id` = '{$c_id}' AND `wr_is_comment` = '1'
	");
	if(!$is_admin && (!$comment['mb_id'] || $comment['mb_id'] != $member['mb_id'])){
		$comment['wr_option'] = $comment['wr_content'] = null;
	}
}

?>

<div id="view_comment_skin" style="width: <?php echo $width; ?>;">

	<?php if(count($list) > 0){ ?>
	<ul class="list">

		<?php foreach($list as $rows){ ?>
		<li id="c_<?php echo $rows['wr_id']; ?>" <?php if($rows['wr_comment_reply']) echo "class=\"reply\" rel=\"{$rows['wr_comment_reply']}\""; ?>>

			<p>
				<?php if($rows['wr_comment_reply']){ ?>
				<img src="<?php echo $board_skin_url; ?>/img/icon_reply.gif" alt="답변글" />
				<?php } ?>
				<?php echo $rows['name']; ?>
				<?php if($is_ip_view){ ?>
				(<?php echo $rows['ip']; ?>)
				<?php } ?>
				<em><?php echo $rows['datetime']; ?></em>
				<?php if($rows['is_reply']){ ?>
				<a href="board.php?<?php echo clean_query_string($_SERVER['QUERY_STRING']); ?>&c_id=<?php echo $rows['wr_id']; ?>&w=c#view_comment_form" class="reply" rel="<?php echo $rows['wr_id']; ?>"><img src="<?php echo $board_skin_url; ?>/img/reply.png" alt="답변" /></a>
				<?php } ?>
				<?php if($rows['is_edit']){ ?>
				<a href="board.php?<?php echo clean_query_string($_SERVER['QUERY_STRING']); ?>&c_id=<?php echo $rows['wr_id']; ?>&w=cu#view_comment_form" class="update" rel="<?php echo $rows['wr_id']; ?>"><img src="<?php echo $board_skin_url; ?>/img/update.png" alt="수정" /></a>
				<?php } ?>
				<?php if($rows['is_del']){ ?>
				<a href="<?php echo $rows['del_link']; ?>" class="delete"><img src="<?php echo $board_skin_url; ?>/img/delete.png" alt="삭제" /></a>
				<?php } ?>
			</p>

			<div <?php if(strstr($rows['wr_option'], 'secret')) echo 'class="secret"'; ?>>
				<?php if(strstr($rows['wr_option'], 'secret')){ ?>
				<img src="<?php echo $board_skin_url; ?>/img/icon_secret.gif" alt="비밀글" />
				<?php } ?>
				<?php echo preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $rows['content']); ?>
				<?php include(G5_SNS_PATH . '/view_comment_list.sns.skin.php'); ?>
			</div>

			<form id="view_comment_form_<?php echo $rows['wr_id']; ?>" method="post" action="write_comment_update.php" class="view_comment_form">
			</form>

			<fieldset>
				<input type="hidden" id="wr_secret_<?php echo $rows['wr_id']; ?>" value="<?php echo strstr($rows['wr_option'], 'secret'); ?>" />
				<textarea id="wr_content_<?php echo $rows['wr_id']; ?>"><?php echo get_text($rows['content1'], 0); ?></textarea>
			</fieldset>

		</li>
		<?php } ?>

	</ul>
	<?php } ?>

	<?php if($is_comment_write){ ?>
	<form id="view_comment_form" method="post" action="write_comment_update.php" class="view_comment_form">

		<?php if($is_guest){ ?>
		<table>
			<tbody>
				<tr>
					<th>
						<img src="<?php echo $board_skin_url; ?>/img/required.png" alt="필수입력" />
						작성자
					</th>
					<td><input type="text" id="wr_name" name="wr_name" value="<?php echo get_cookie('ck_sns_name'); ?>" title="작성자" class="required" /></td>
				</tr>
				<tr>
					<th>
						<img src="<?php echo $board_skin_url; ?>/img/required.png" alt="필수입력" />
						비밀번호
					</th>
					<td><input type="password" id="wr_password" name="wr_password" title="비밀번호" class="required" /></td>
				</tr>
				<tr>
					<th>
						<img src="<?php echo $board_skin_url; ?>/img/required.png" alt="필수입력" />
						자동등록방지
					</th>
					<td><?php echo $captcha_html; ?></td>
				</tr>
			</tbody>
		</table>
		<?php } ?>

		<div>
			<p><textarea id="wr_content" name="wr_content" title="내용" class="required"><?php echo $comment['wr_content']; ?></textarea></p>
			<div>
				<label><input type="checkbox" id="wr_secret" name="wr_secret" value="secret" <?php if(strstr($comment['wr_option'], 'secret')) echo 'checked="checked"'; ?> /> 비밀글</label>
				<?php
				if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])){
					include_once(G5_SNS_PATH . '/view_comment_write.sns.skin.php');
				}
				if($comment_min || $comment_max){
					echo "<strong>현재 <span id=\"char_count\"></span>글자 (";
					if($comment_min){
						echo "최소 {$comment_min}글자부터";
					}
					if($comment_min && $comment_max){
						echo ' ';
					}
					if($comment_max){
						echo "최대 {$comment_max}글자까지";
					}
					echo ")</strong>";
				}
				?>
			</div>
		</div>

		<button type="submit" name="save">확인</button>

		<fieldset>
			<input type="hidden" id="token" name="token" />
			<input type="hidden" id="w" name="w" value="<?php if($w) echo $w; else echo 'c'; ?>" />
			<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>" />
			<input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>" />
			<input type="hidden" id="comment_id" name="comment_id" value="<?php echo $c_id; ?>" />
			<input type="hidden" name="sca" value="<?php echo $sca; ?>" />
			<input type="hidden" name="sfl" value="<?php echo $sfl; ?>" />
			<input type="hidden" name="stx" value="<?php echo $stx; ?>" />
			<input type="hidden" name="sst" value="<?php echo $sst; ?>" />
			<input type="hidden" name="sod" value="<?php echo $sod; ?>" />
			<input type="hidden" name="sop" value="<?php echo $sop; ?>" />
			<input type="hidden" name="spt" value="<?php echo $spt; ?>" />
			<input type="hidden" name="page" value="<?php echo $page; ?>" />
			<input type="hidden" name="char_min" value="<?php echo (int)$comment_min; ?>" />
			<input type="hidden" name="char_max" value="<?php echo (int)$comment_max; ?>" />
		</fieldset>

	</form>
	<?php } ?>

</div>