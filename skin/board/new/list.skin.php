<?php

add_stylesheet("<link rel=\"stylesheet\" href=\"{$board_skin_url}/css/list.skin.css\" />", 0);
add_javascript("<script src=\"{$board_skin_url}/js/list.skin.js\"></script>", 0);
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

?>

<div id="list_skin" style="width: <?php echo $width; ?>;">

	<h1 class="title"><?php echo $board['bo_subject']; ?></h1>

	<?php if($is_category){ ?>
	<ul class="category"><?php echo $category_option; ?></ul>
	<?php } ?>

	<p class="total">
		전체 <?php echo number_format($total_count); ?>건
		<span>(현재 <?php echo $page; ?>페이지)</span>
		<?php if($admin_href){ ?>
		<a href="<?php echo $admin_href; ?>"><img src="<?php echo $board_skin_url; ?>/img/admin.png" alt="ADMIN" /></a>
		<?php } ?>
		<?php if($rss_href){ ?>
		<a href="<?php echo $rss_href; ?>"><img src="<?php echo $board_skin_url; ?>/img/rss.png" alt="RSS" /></a>
		<?php } ?>
	</p>

	<form method="post" class="list">

		<table>
			<thead>
				<tr>
					<?php if($is_checkbox){ ?>
					<th class="slim"><input type="checkbox" name="all_wr_id" /></th>
					<?php } ?>
					<th>번호</th>
					<?php if($is_category){ ?>
					<th class="wide">분류</th>
					<?php } ?>
					<th class="auto">제목</th>
					<th class="wide">작성자</th>
					<th><?php echo subject_sort_link('wr_datetime', $qstr2, 1); ?>등록일 <img src="<?php echo $board_skin_url; ?>/img/sorting.png" alt="정렬" /></a></th>
					<th><?php echo subject_sort_link('wr_hit', $qstr2, 1); ?>조회수 <img src="<?php echo $board_skin_url; ?>/img/sorting.png" alt="정렬" /></a></th>
					<?php if($is_good){ ?>
					<th><?php echo subject_sort_link('wr_good', $qstr2, 1); ?>좋아요 <img src="<?php echo $board_skin_url; ?>/img/sorting.png" alt="정렬" /></a></th>
					<?php } ?>
					<?php if($is_nogood){ ?>
					<th><?php echo subject_sort_link('wr_nogood', $qstr2, 1); ?>싫어요 <img src="<?php echo $board_skin_url; ?>/img/sorting.png" alt="정렬" /></a></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($list as $rows){ ?>
				<tr <?php if($rows['is_notice']) echo 'class="notice"'; ?>>
					<?php if($is_checkbox){ ?>
					<td><input type="checkbox" name="chk_wr_id[]" value="<?php echo $rows['wr_id']; ?>" /></td>
					<?php } ?>
					<td>
						<?php
						if($rows['is_notice']){
							echo '공지글';
						} else if($rows['wr_id'] == $wr_id){
							echo '현재글';
						} else{
							echo $rows['num'];
						}
						?>
					</td>
					<?php if($is_category){ ?>
					<td><?php echo $rows['ca_name']; ?></td>
					<?php } ?>
					<td class="left">
						<?php
						$thumb = get_list_thumbnail($bo_table, $rows['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height']);
						if($thumb['src']){
							echo "<a href=\"{$rows['href']}\"><img src=\"{$thumb['src']}\" alt=\"{$thumb['alt']}\" /></a>";
						}
						?>
						<p class="subject" rel="<?php echo $board['bo_gallery_height']; ?>">
							<?php echo $rows['icon_reply']; ?>
							<?php echo $rows['icon_new']; ?>
							<a href="<?php echo $rows['href']; ?>"><?php echo $rows['subject']; ?></a>
							<?php echo preg_replace('/([0-9]+)/', '(\1)', $rows['comment_cnt']); ?>
							<?php echo $rows['icon_hot']; ?>
							<?php echo $rows['icon_file']; ?>
							<?php echo $rows['icon_link']; ?>
							<?php echo $rows['icon_secret']; ?>
						</p>
						<div><?php echo $rows['content']; ?></div>
					</td>
					<td><?php echo $rows['name']; ?></td>
					<td><?php echo $rows['datetime2']; ?></td>
					<td><?php echo $rows['wr_hit']; ?></td>
					<?php if($is_good){ ?>
					<td><?php echo $rows['wr_good']; ?></td>
					<?php } ?>
					<?php if($is_nogood){ ?>
					<td><?php echo $rows['wr_nogood']; ?></td>
					<?php } ?>
				</tr>
				<?php } ?>
			</tbody>
		</table>

		<?php if($is_checkbox || $write_href){ ?>
		<p>
			<?php if($is_checkbox){ ?>
			<button type="submit" name="copy">선택복사</button>
			<button type="submit" name="move">선택이동</button>
			<button type="submit" name="delete">선택삭제</button>
			<?php } ?>
			<?php if($write_href){ ?>
			<a href="<?php echo $write_href; ?>">작성하기</a>
			<?php } ?>
		</p>
		<?php } ?>

		<?php
		$write_pages = str_replace('처음', "<img src=\"{$board_skin_url}/img/prevprev.png\" alt=\"처음\" />", $write_pages);
		$write_pages = str_replace('이전', "<img src=\"{$board_skin_url}/img/prev.png\" alt=\"이전\" />", $write_pages);
		$write_pages = str_replace('다음', "<img src=\"{$board_skin_url}/img/next.png\" alt=\"다음\" />", $write_pages);
		$write_pages = str_replace('맨끝', "<img src=\"{$board_skin_url}/img/nextnext.png\" alt=\"맨끝\" />", $write_pages);
		echo $write_pages;
		?>

		<fieldset>
			<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>" />
			<input type="hidden" name="sca" value="<?php echo $sca; ?>" />
			<input type="hidden" name="sfl" value="<?php echo $sfl; ?>" />
			<input type="hidden" name="stx" value="<?php echo $stx; ?>" />
			<input type="hidden" name="sst" value="<?php echo $sst; ?>" />
			<input type="hidden" name="sod" value="<?php echo $sod; ?>" />
			<input type="hidden" name="sop" value="<?php echo $sop; ?>" />
			<input type="hidden" name="spt" value="<?php echo $spt; ?>" />
			<input type="hidden" name="page" value="<?php echo $page; ?>" />
			<input type="hidden" name="sw" />
			<input type="hidden" name="btn_submit" />
		</fieldset>

	</form>

	<form method="get" class="search">
		<select name="sfl">
			<option value="wr_subject||wr_content" <?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
			<option value="wr_subject" <?php echo get_selected($sfl, 'wr_subject'); ?>>제목</option>
			<option value="wr_content" <?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
			<option value="wr_name,0" <?php echo get_selected($sfl, 'wr_name,0'); ?>>작성자</option>
			<option value="mb_id,0" <?php echo get_selected($sfl, 'mb_id,0'); ?>>아이디</option>
		</select>
		<input type="text" name="stx" value="<?php echo $stx; ?>" title="검색어" class="required" />
		<button type="submit" name="search">검색하기</button>
		<?php if($list_href){ ?>
		<a href="<?php echo $list_href; ?>">목록보기</a>
		<?php } ?>
		<fieldset>
			<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>" />
			<input type="hidden" name="sca" value="<?php echo $sca; ?>" />
			<input type="hidden" name="sop" value="<?php echo $sop; ?>" />
		</fieldset>
	</form>

</div>