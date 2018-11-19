<?php

add_stylesheet("<link rel=\"stylesheet\" href=\"{$board_skin_url}/css/view.skin.css\" />", 0);
add_javascript("<script src=\"{$board_skin_url}/js/view.skin.js\"></script>", 0);
add_javascript("<script src=\"" . G5_JS_URL . "/viewimageresize.js\"></script>", 0);
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

?>

<div id="view_skin" style="width: <?php echo $width; ?>;">

	<h1 class="title"><?php echo $board['bo_subject']; ?></h1>

	<h2 class="subject">
		<?php if($category_name){ ?>
		[<?php echo $view['ca_name']; ?>]
		<?php } ?>
		<?php echo get_text($view['wr_subject']); ?>
	</h2>

	<table class="view">
		<tbody>
			<tr>
				<td class="auto">
					작성자
					<span>
						<?php echo $view['name']; ?>
						<?php if($is_ip_view){ ?>
						(<?php echo $ip; ?>)
						<?php } ?>
					</span>
				</td>
				<td class="wide">
					등록일
					<span><?php echo $view['wr_datetime']; ?></span>
				</td>
				<td>
					조회수
					<span><?php echo number_format($view['wr_hit']); ?>회</span>
				</td>
				<td>
					댓글수
					<span><?php echo number_format($view['wr_comment']); ?>건</span>
				</td>
			</tr>
		</tbody>
	</table>

	<?php
	for($num = $key = 1; $key <= count($view['link']); $key++){
		if($view['link'][$key]){
	?>
	<table class="view">
		<tbody>
			<tr>
				<td class="auto">
					링크 #<?php echo $num; ?>
					<a href="<?php echo $view['link_href'][$key]; ?>" target="_blank"><?php echo $view['link'][$key]; ?></a>
				</td>
				<td>
					클릭수
					<span><?php echo $view['link_hit'][$key]; ?>회</span>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
			$num++;
		}
	}
	?>

	<?php for($num = 1, $key = 0; $key < $view['file']['count']; $num++, $key++){ ?>
	<table class="view">
		<tbody>
			<tr>
				<td class="auto">
					파일 #<?php echo $num; ?>
					<a href="<?php echo $view['file'][$key]['href']; ?>" class="download" rel="<?php echo $board['bo_download_point']; ?>">
						<?php echo $view['file'][$key]['source']; ?>
						<?php if($view['file'][$key]['content']){ ?>
						(<?php echo $view['file'][$key]['content']; ?>)
						<?php } ?>
					</a>
				</td>
				<td class="wide">
					첨부일
					<span><?php echo $view['file'][$key]['datetime']; ?></span>
				</td>
				<td>
					사이즈
					<span><?php echo $view['file'][$key]['size']; ?></span>
				</td>
				<td>
					다운수
					<span><?php echo $view['file'][$key]['download']; ?>회</span>
				</td>
			</tr>
		</tbody>
	</table>
	<?php } ?>

	<div class="content">
		<?php
		for($key = 0; $key < $view['file']['count']; $key++){
			if($view['file'][$key]['view']){
				echo get_view_thumbnail($view['file'][$key]['view']);
			}
		}
		?>
		<div><?php echo get_view_thumbnail($view['content']); ?></div>
		<?php include_once(G5_SNS_PATH . '/view.sns.skin.php'); ?>
		<?php if($is_signature && $signature){ ?>
		<p><?php echo $signature; ?></p>
		<?php } ?>
	</div>

	<?php if($prev_href){ ?>
	<table class="view">
		<tbody>
			<tr>
				<td class="auto">
					이전글
					<a href="<?php echo $prev_href; ?>"><?php echo $prev_wr_subject; ?></a>
				</td>
			</tr>
		</tbody>
	</table>
	<?php } ?>

	<?php if($next_href){ ?>
	<table class="view">
		<tbody>
			<tr>
				<td class="auto">
					다음글
					<a href="<?php echo $next_href; ?>"><?php echo $next_wr_subject; ?></a>
				</td>
			</tr>
		</tbody>
	</table>
	<?php } ?>

	<p class="button">
		<?php if($copy_href){ ?>
		<a href="<?php echo $copy_href; ?>" class="copy">복사하기</a>
		<?php } ?>
		<?php if($move_href){ ?>
		<a href="<?php echo $move_href; ?>" class="move">이동하기</a>
		<?php } ?>
		<?php if($delete_href){ ?>
		<a href="<?php echo $delete_href; ?>" class="delete">삭제하기</a>
		<?php } ?>
		<?php if($update_href){ ?>
		<a href="<?php echo $update_href; ?>">수정하기</a>
		<?php } ?>
		<?php if($good_href){ ?>
		<a href="<?php echo "{$good_href}&{$qstr}"; ?>" class="good">
			좋아요
			(<span><?php echo number_format($view['wr_good']); ?></span>)
		</a>
		<?php } ?>
		<?php if($nogood_href){ ?>
		<a href="<?php echo "{$nogood_href}&{$qstr}"; ?>" class="nogood">
			싫어요
			(<span><?php echo number_format($view['wr_nogood']); ?></span>)
		</a>
		<?php } ?>
		<?php if($scrap_href){ ?>
		<a href="<?php echo $scrap_href; ?>" class="scrap" target="_blank">스크랩</a>
		<?php } ?>
		<?php if($reply_href){ ?>
		<a href="<?php echo $reply_href; ?>">답변하기</a>
		<?php } ?>
		<?php if($search_href){ ?>
		<a href="<?php echo $search_href; ?>">목록보기</a>
		<?php } else{ ?>
		<a href="<?php echo $list_href; ?>">목록보기</a>
		<?php } ?>
	</p>

</div>

<?php include_once(G5_BBS_PATH . '/view_comment.php'); ?>