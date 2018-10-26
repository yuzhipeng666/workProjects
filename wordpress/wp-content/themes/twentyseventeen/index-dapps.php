<?php
/* DApps */
$dapps = DAPPS;
$paged = get_query_var('page');
if ($paged == null) {
    $paged = 1;
}
$p = $paged - 1;
// 总条数
$total = get_posts("numberposts=-1&category=$cat_ID");
// 显示多少条
$number = 10;
$offset = $p * $number;

?>
<div class="top-bg">
    <div class="top-bghei"></div>
    <img src="/wp-content/themes/twentyseventeen/assets/images/logo@3x.png" alt="">
</div>
<div class="ming">
    <div class="Ming-bg">
    <div class="dap-main">
        <div class="dat-hidden">
        <div class="dap-mainLeft" id="container-async">
            <ul>
                <li class="Active" id="<?php echo  $cat_ID?> ">
                    <a href="jacascript::void(0)" class="dapActive">全部</a>
                </li>
                <?php $ab = get_category_root_id($cat_ID) ?>
                <?php $cates = get_categories("child_of=$ab&hide_empty=0") ?>
                <?php foreach ($cates as $c): ?>
                    <li id="<?php echo $c->term_id ?>">
                        <a href="jacascript::void(0)" ><?php echo $c->name ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        </div>
        <div class="miniapp-list-content--main" id="dap-mainRight">
            <div class="content-main">
                <ul class="miniapp-list-content-ul clearfix js-miniapp-list">
                    <?php $tops = get_posts("category=$cat_ID&numberposts=$number&offset=$offset"); ?>
                    <?php if( $tops ) : ?>
                    <div class="dApps-pc">
                        <?php foreach( $tops as $top ):  ?>
                        <li class="miniapp-item js-miniapp-item ">
                                <div class="miniapp-header"><div><img
                                                class="miniapp-header__app-icon js-app-link"
                                                src="<?php echo catch_the_image($top->ID)?>"
                                                alt="app icon"></div>
                                    <div class="app-header-corp"><a href="?p=<?php echo $top->ID?>"
                                                                    class="app-header-corp__app-name js-app-link"
                                                                    target="_blank"><?php echo $top->post_title?></a>
                                        <span class="app-header-corp__auth-name">
                                            <?php echo get_content_link($top->post_content) ?>
                                        </span>
                                    </div>
                                <div class="miniapp-footer">
                                    <?php get_text($top) ?>
                                </div>
                        </li>
                        <?php endforeach; ?>
                     </div>
                    <div class="dApps-app">
                        <?php foreach( $tops as $top ):  ?>
                                <li class="app-ranking-list__item ">
                                    <div class="app-ranking-list__link clearfix" ><a
                                                href="?p=<?php echo $top->ID?>" ga-bind="click"
                                                ga-category="widget" ga-label="newlist1"
                                                ga-action="NewList"><img class="app-ranking-list__image"
                                                                         src="<?php echo catch_the_image($top->ID)?>"
                                                                         alt="app icon"></a>
                                        <div class="app-ranking-list__content"><h5
                                                    class="app-ranking-list__name"><a href="?p=<?php echo $top->ID?>"><?php echo $top->post_title?></a></h5>
                                            <p class="app-ranking-list__name"><?php get_text($top) ?></p>
                                            <div class="app-ranking-list__stars"></div>

                                        </div>
                                    </div>
                                </li>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="clear"></div>
                </ul>
                <div class="pagena">
                    <?php echo get_pagenavis('4', $total, $number,$paged); ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<script>
    var ajaxurl = '<?php echo admin_url('admin-ajax.php')?>';
    $(".dap-mainLeft ul li").on("click", function (){
        var _this = this;
        var id = $(this).attr("id");
        var data={
            tape:id,
            action : 'get_ajax_dapps',
        }
        $.ajax({
            type:'post',
            url:ajaxurl,
            data:data,
            cache:false,
            dataType:'html',
            success:function(result){
                $(".dap-mainLeft ul li ").removeClass("Active")
                $(_this).addClass("Active");
                $(".dap-mainLeft ul li a").removeClass("dapActive")
                $(_this).find("a").addClass("dapActive");
                $('.content-main').empty();
                $(".content-main").append(result);
            },
            error:function(data){
                alert("err");
            }
        });
        return false;

    });

    $(".content-main").on("click", ".page-numbers", function (){
        var paged_id = $(this).attr("id");
        var id = $(".dap-mainLeft ul .Active").attr("id");
        var data={
            tape:id,
            page:paged_id,
            action : 'get_ajax_dapps',
        }
        $.ajax({
            type:'post',
            url:ajaxurl,
            data:data,
            cache:false,
            dataType:'html',
            success:function(result){
                $('.content-main').empty();
                $(".content-main").append(result);
            },
            error:function(data){
                alert("err");
            }
        });
        return false;

    });

    $(document).ready(function(){
        $(window).scroll(function(event){
            if(document.documentElement.scrollTop > 340) {
                $(".dat-hidden").addClass("dat-hidden-scroll");
                $(".miniapp-list-content--main").addClass("miniapp-list-content-scroll");
            } else {
                $(".dat-hidden").removeClass("dat-hidden-scroll");
                $(".miniapp-list-content--main").removeClass("miniapp-list-content-scroll");
            }
        });
    });

</script>



