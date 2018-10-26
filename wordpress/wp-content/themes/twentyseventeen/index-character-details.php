<?php
    /* 人物 */
    $characters = CHARACTERS;
    $paged = get_query_var('page');
    if($paged==null){
       $paged = 1;
    }
    $p = $paged - 1;
    // 总条数
    $total = get_posts("category=$cat_ID");
    // 显示多少条
    $number = 5;

    $details_ID = get_query_var('details');
    $D =  get_category($details_ID);
    var_dump($D);
?>

<style>
    .active{
        color: #00b9eb;
    }
</style>

<div>
        <div class="character-ming">
            <div class="character-mingTop"></div>
                <div class="details-mainRight" id="character-mainRight">
                    <div class="details-introduction">
                        <div class="details-introductionImg">
                            <img src="/wp-content/themes/twentyseventeen/assets/images/pic_banner_img_normal@2x.png" alt="">
                        </div>
                        <div class="details-introductionCon">
                            <div class="details-introductionTitle">莱昂纳德</div>
                            <div class="details-introductionText">莱昂纳德</div>
                            <div class="details-introductionLord">姚明（Yao Ming），1980年9月12日出生于上海市徐汇区，祖籍江苏省苏州市吴江区震泽镇，前中国职业篮球运动员，司职中锋，现任中职联公司董事长兼总经理 Ώ]  。
                                1998年4月，姚明入选王非执教的国家队，开始篮球生涯。2001夺得CBA常规赛MVP，2002年夺得CBA总冠军以及总决赛MVP，分别3次当选CBA篮板王以及盖帽王，2次当选CBA扣篮王。在2002年NBA选秀中，他以状元秀身份被NBA的休斯敦火箭队选中，2003-09年连续6个赛季（生涯共8次）入选NBA全明星阵容，2次入选NBA最佳阵容二阵，3次入选NBA最佳阵容三阵。2009年，姚明收购上海男篮，成为上海大鲨鱼篮球俱乐部老板。2011年7月20日，姚明正式宣布退役。
                                2013年，姚明当选为第十二届全国政协委员。2014年6月，参加湖南卫视《爸爸去哪儿》客串嘉宾。2015年2月10日，姚明正式成为北京申办冬奥会形象大使之一。2016年4月4日，姚明正式入选2016年奈·史密斯篮球名人纪念堂，成为首位获此殊荣的中国人。10月，姚明成为中国"火星大使"。11月，当选CBA公司副董事长 ΐ]  。</div>
                        </div>
                    </div>
                    <div class="span-title"><span>相关信息</span></div>
                    <div class="related-information">
                        <ul>
                            <li>
                                <div class="related-informationImg">
                                    <img src="/wp-content/themes/twentyseventeen/assets/images/pic_banner_img_normal@2x.png" alt="">
                                </div>
                                <div class="related-informationCon">
                                    <div class="related-informationTiele">莱昂纳德不呢看，不会吧翻译</div>
                                    <div class="related-informationText">爱词霸英语为广大网友提供在线翻译、在线词典、英语口语、英语学习资料、汉语
                                        词典,金山词霸下载等服务…</div>
                                </div>
                                <a class="related-mainRigLink" href="?p=<?php echo $top->ID?>">
                                    <img src="/wp-content/themes/twentyseventeen/assets/images/btn_content_more_normal@3x.png" alt="">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="pagena" style="justify-content: center">
                        <?php echo get_pagenavi('4', $total);?>
                    </div>
                </div>
        </div>



</div>



