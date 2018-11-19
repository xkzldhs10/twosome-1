<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>



<div class="bnr_section bnr_section_right" id="notice_area">
    <div class="bnr_notice">
        <dl>
            <dt><? echo $bo_subject;?></dt>
            <dd>
				<ul id="noticeList">
				 <? for($i=0;$i<count($list);$i++){ ?>
					<li>
						<a href=""<?echo $list[$i]['href'];?>""><span class="ico ico_notice"></span> <? echo $list[$i]['subject'];?></a>
					</li>
					<li>
						<a href=""<?echo $list[$i]['href'];?>""><span class="ico ico_notice"></span> <? echo $list[$i]['subject'];?></a>
					</li>
					<li>
						<a href=""<?echo $list[$i]['href'];?>""><span class="ico ico_notice"></span>  <? echo $list[$i]['subject'];?></a>
					</li>
					 <?}?>
					 <?if(count($list)==0){?>
                            <li>게시물이 없습니다. </li>
                       <? }?>
				</ul>
			</dd>
		</dl>
		<a href="<?echo G5_BBS_URL ?>/board.php?bo_table=<? echo $bo_table;?>" class="btn_ico btn_more">더보기</a>
    </div>
</div>