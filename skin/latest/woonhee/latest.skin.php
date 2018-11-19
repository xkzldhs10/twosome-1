<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>


	<section id="section">
		<div class="wrap">
			<div class="section">
				<dis class="section_title">
					<h3><? echo $bo_subject;?></h3>
					 <a href="<?echo G5_BBS_URL ?>/board.php?bo_table=<? echo $bo_table;?>" class="more_btn">more</a>
				</dis>
				<div class="section_content">
					<ul class="news_list">
					 <? for($i=0;$i<count($list);$i++){ ?>
						<li>
							<a href="<?echo $list[$i]['href'];?>">
								<h4 class="news_title"> <? echo $list[$i]['subject'];?></h4>
								<span class="date"><? echo $list[$i]['datetime2'];?></span>
							</a>
						</li>
						<li>
							<a href="<?echo $list[$i]['href'];?>">
								<h4 class="news_title"> <? echo $list[$i]['subject'];?></h4>
								<span class="date"><? echo $list[$i]['datetime2'];?></span>
							</a>
						</li>
						<li>
							<a href="<?echo $list[$i]['href'];?>">
								<h4 class="news_title"> <? echo $list[$i]['subject'];?></h4>
								<span class="date"><? echo $list[$i]['datetime2'];?></span>
							</a>
						</li>
						
						 <?}?>
                      <?if(count($list)==0){?>
                            <li>게시물이 없습니다. </li>
                       <? }?>
					</ul>
				</div>
			</div>
		</div>
	</section>