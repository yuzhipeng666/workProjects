<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header();
?>

<?php
/* 新闻 */
$newss = NEWSS;
/* DApps */
$dapps = DAPPS;
/* 活动 */
$activitys = ACTIVITYS;
/* 公链 */
$chains = CHAINS;
/* 人物 */
$characters = CHARACTERS;
/* 快讯 */
$newsletters = NEWSLETTERS;
///* 小道 */
//$trails = TRAILS;
/* 置顶 */
$topping = TRAILS;
/* 明星 */
$celebritys = CELEBRITYS;
/* 关于 */
$on = ON;
/* 顾问 */
$consultants = CONSULTANTS;
/* 合作 */
$cooperations = COOPERATIONS;
/* 头条 */
$tops = TOPS;
/* 条数 */
$number = 3;


//$newss_sort = $_GET['news'];
//
//if ($newss_sort == null) {
//    $newss_sort = $newss;
//}

$topping_top = get_posts("category=$topping&numberposts=2");

?>


    <div class="wrap" style="background: <?php echo get_content_ol($topping_top[0]->post_content)?>">
        <main id="main" class="site-main" role="main">
            <div class="container" style="background-color: <?php echo get_content_ol($topping_top[0]->post_content)?>">
                <div class="container-top">
                    <div class="img-container"
                         style="background-image:url('<?php echo catch_the_image($topping_top[0]->ID)?>')">
                    </div>
                    <div class="bottom-gradient"></div>
                    <div class="headline-back">

                        <div class="top-container">
                            <div class="top-container-left">
                                <div class="top-containerTielt">
                                    <a href="?p=<?php echo $topping_top[0]->ID?>"><span><?php echo $topping_top[0]->post_title?></span></a>
                                    <span></span>
                                </div>
<!--                                <div class="top-containerText">--><?php //get_text($topping_top[0]) ?><!--</div>-->
                                <a href="?p=<?php echo $topping_top[0]->ID?>" class="top-containerLink">查看详情  <span class="top-ckxq"></span></span></a>
                            </div>

                            <div class="clear"></div>
                        </div>
                    </div>

                </div>
                <div class="container-middle">
                    <div class="o-wrapper c-home">
                        <div class="o-wrapper-pc">
                        <div class="c-top clearfix">
                            <div class="top-con">
                                <ul>
                                    <?php $tops_data = get_posts("category=$tops&numberposts=3"); ?>
                                    <?php if( $tops_data ) : ?>
                                        <li>
                                            <a href="?p=<?php echo $tops_data[0]->ID?>">
                                                <div class="top-conleftimg"><img
                                                            src="<?php echo catch_the_image($tops_data[0]->ID)?>"
                                                            alt="">
                                                </div>
                                                <div class="top-conleftTitle1"><p>
                                                        <?php echo $tops_data[0]->post_title?>
                                                    </p></div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="?p=<?php echo $tops_data[1]->ID?>">
                                                <div class="top-conleftimg1"><img
                                                            src="<?php echo catch_the_image($tops_data[1]->ID)?>"
                                                            alt="">
                                                </div>
                                                <div class="top-conleftTitle2"><p><?php echo $tops_data[1]->post_title?></p></div>
                                            </a>
                                            <a href="?p=<?php echo $tops_data[2]->ID?>">
                                                <div class="top-conleftimg2"><img
                                                            src="<?php echo catch_the_image($tops_data[2]->ID)?>"
                                                            alt="">
                                                </div>
                                                <div class="top-conleftTitle3"><p><?php echo $tops_data[2]->post_title?></p></div>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="border-bottom"></div>
                        <div id="article-container" class="article-collection article-collection--list">

                            <div class="collection-container">
                                <div id="subNav" class="sub-nav  c-header-navbar__content" data-fixed-start="#subNav"
                                     data-fixed-end="#footer">
                                    <div class="navbar-container">
                                        <div class="navbar-box">
                                            <div class="inner-holder">
                                                <ul>
                                                    <li class="<?php echo  $newss?>">
                                                        <a href="jacascript::void(0)" class="newsActive">最新</a>
                                                    </li>
                                                    <?php $ab = get_category_root_id($newss) ?>
                                                    <?php $cates = get_categories("child_of=$ab&hide_empty=0") ?>
                                                    <?php foreach ($cates as $c): ?>
                                                        <li class="<?php echo $c->term_id ?>">
                                                            <!--                            <a href="?cat=--><?php //echo $c->term_id?><!--">-->
                                                            <?php //echo $c->name?><!--</a>-->
<!--                                                            <a href="?news=--><?php //echo $c->term_id ?><!--"-->
                                                                <a href="jacascript::void(0)"
                                                               class="<?php if ($c->term_id == $newss) echo 'newsActive' ?>"><?php echo $c->name ?></a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                    <div class="clear"></div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sub-nav-bar--fixed__border"></div>
                                </div>
                                <div id="collectionList" class="collection-list" style="margin-top: 0px;">
                                    <?php $newss_data = get_posts("category=$newss&numberposts=9")?>
                                    <?php if( $newss_data ) : ?>
                                    <?php  foreach( $newss_data as $news ):  ?>

                                    <div class="article-item article-item--list ">
                                        <div class="article-image cover-image">
                                            <a href="?p=<?php echo $news->ID?>"
                                               class="article-link cover-block"
                                               style="background-image:url('<?php echo catch_the_image($news->ID)?>')">
                                            </a>
                                        </div>
                                        <div class="article-info js-transform">
                                            <h3><a class="js-title-transform" href="?p=<?php echo $news->ID?>"><?php echo $news->post_title?></a></h3>
                                            <div class="article-summary"><?php get_text($news)?></div>
                                            <div class="article-meta">
                                                <time> <span><?php echo date("m-d", strtotime($news->post_date_gmt))?></span>
                                                <?php $tt = wp_get_post_tags($news->ID); foreach ($tt as $t): ?>
                                                    <span><?php echo $t->name ?></span>
                                                <?php endforeach; ?>
                                                </time>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <a class="link-button-news" href="?cat=<?php echo $newss?>">查看更多<span class="top-gray"></a>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="collection-sidebar">
                                <div class="widget-container">
                                    <section class="buzz-widget" data-component="BuzzWidget">
                                        <div class="widget-header">
                                            <h3><span><?php  $cat = get_category($dapps);echo $cat->name;?></span><a href="?cat=<?php echo $dapps?>">查看更多<span class="top-gray"></span></a></h3>
                                        </div>
                                        <ul data-component="RankingList" data-order="reputation">
                                            <?php $dappss_data = get_posts("category=$dapps&numberposts=6"); ?>
                                            <?php if( $dappss_data ) : ?>
                                            <?php foreach( $dappss_data as $dappss ):  ?>
                                            <li class="app-ranking-list__item">
                                                <div class="app-ranking-list__link clearfix" ><a
                                                            href="?p=<?php echo $dappss->ID?>" ga-bind="click"
                                                            ga-category="widget" ga-label="newlist1"
                                                            ga-action="NewList"><img class="app-ranking-list__image"
                                                                                     src="<?php echo catch_the_image($dappss->ID)?>"
                                                                                     alt="app icon"></a>
                                                    <div class="app-ranking-list__content"><h5
                                                                class="app-ranking-list__name"><a href="?p=<?php echo $dappss->ID?>"><?php echo $dappss->post_title?></a></h5>
                                                        <p class="app-ranking-list__name"><?php get_text($dappss) ?></p>
                                                        <div class="app-ranking-list__stars"></div>

                                                    </div>
                                                </div>
                                            </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                        <div class="clear"></div>
                                    </section>

                                </div>
                                <div class="border-bottom"></div>
                                <!-- 快讯 -->
                                <div class="widget-container">
                                    <section class="buzz-widget" data-component="BuzzWidget">
                                        <div class="widget-header">
                                            <h3><span><?php  $cat = get_category($newsletters);echo $cat->name;?></span><a href="?cat=<?php echo $newsletters?>">查看更多<span class="top-gray"></span></a></h3>
                                        </div>
                                        <ul  data-component="RankingList" data-order="reputation">
                                            <?php $newsletters_data = get_posts("category=$newsletters&numberposts=6"); ?>
                                            <?php if( $newsletters_data ) : ?>
                                                <?php foreach( $newsletters_data as $newsletters ):  ?>
                                                    <li class="app-ranking-list__item">
                                                        <div class="app-ranking-list__link app-ranking-list__link_kuaix clearfix newsletter-con" >
                                                            <div class="app-ranking-list__content"><h5
                                                                        class="app-ranking-list__name app-ranking-list__name_h5"><a href="?p=<?php echo $newsletters->ID?>"><?php echo $newsletters->post_title?></a></h5>
                                                                <p class="app-ranking-list__name_kuaix"><?php get_text($newsletters) ?></p>
                                                                <div class="app-ranking-link__kuaix">                                                                <div class="app-ranking-list__data"><?php echo date("m-d", strtotime($newsletters->post_date_gmt))?></div>
                                                                    <?php echo get_content_link($newsletters->post_content) ?></div>
                                                                <div class="app-ranking-list__stars"></div>

                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                        <div class="clear"></div>
                                    </section>

                                </div>
                                <div class="border-bottom"></div>
                                <div class="ads-container">
                                </div>
                            </div>
                            <div class="evaluate">
                                <div class="widget-header">
                                    <h3><span><?php  $cat = get_category($characters);echo $cat->name;?></span><a href="?cat=<?php echo $characters?>">查看更多<span class="top-gray"></span></a></h3>
                                </div>
                                <ul>
                                    <?php $characters_data = get_posts("category=$characters&numberposts=6"); ?>
                                    <?php if( $characters_data ) : ?>
                                    <?php foreach( $characters_data as $characterss ):  ?>
                                    <li>
                                        <a href="?cat=<?php echo $characters ?>&details=<?php echo $characterss->ID ?>">
                                        <div class="content-border">
                                            <div class="left-img">
                                                <img  src="<?php echo catch_the_image($characterss->ID)?>">
                                            </div>
                                            <div class="content-outer">
                                                <div class="p-outer"><p class="p1"><?php echo $characterss->post_title?></p>
                                                    <p class="p3"><?php echo get_content_strong($characterss->post_content) ?></p>
                                                     <p class="p4"><?php get_text($characterss) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        </a>
                                    </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <div style="clear: both;"></div>
                                </ul>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="recommend">
                                <div class="widget-header">
                                    <h3><span><?php  $cat = get_category($chains);echo $cat->name;?></span><a href="?cat=<?php echo $chains?>">查看更多<span class="top-gray"></span></a></h3>
                                </div>
                                <ul>
                                    <?php $chains_data = get_posts("category=$chains&numberposts=6"); ?>
                                    <?php if( $chains_data ) : ?>
                                    <?php foreach( $chains_data as $chainss ):  ?>
                                    <li>
                                        <a href="?p=<?php echo $chainss->ID?>">
                                                <div class="left-font"><p class="p1"><?php echo $chainss->post_title?></p>
                                                    <p class="p2"><?php get_text($chainss) ?></p>
                                                    <div class="p3">
                                                        <div class="score">项目评分 ：
                                                            <div class="cleanfloat">
                                                                <?php
                                                                $score_data = get_content_score($chainss->post_content);
                                                                ?>
                                                                <?php if( $score_data <= 0) : ?>
                                                                    <span>无</span>
                                                                <?php else:  ?>
                                                                    <?php for( $i=0; $i<$score_data; $i++ ):  ?>
                                                                        <div class="cleanfloat-li">&#9733;</div>
                                                                    <?php endfor; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="right-img"
                                                         style="background-image: url(&quot;<?php echo catch_the_image($chainss->ID)?>&quot;);"></div>
                                                </div>
                                         </a>
                                       </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <div style="clear: both;"></div>
                                </ul>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="event-con">
                                <div class="widget-header">
                                    <h3><span><?php  $cat = get_category($activitys);echo $cat->name;?></span><a href="?cat=<?php echo $activitys?>">查看更多<span class="top-gray"></span></a></h3>
                                </div>
                                <ul>
                                    <?php $activitys_data = get_posts("category=$activitys&numberposts=3"); ?>
                                    <?php if( $activitys_data ) : ?>
                                    <li>
                                        <a href="?p=<?php echo $activitys_data[0]->ID?>">
                                        <div class="event-conleftimg"><img
                                                    src="<?php echo catch_the_image($activitys_data[0]->ID)?>"
                                                    alt="">
                                            <div class="activity-conleftTitle"><p><?php echo $activitys_data[0]->post_title?></p></div>
                                        </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?p=<?php echo $activitys_data[1]->ID?>">
                                        <div class="event-conrighttimg1"><img
                                                    src="<?php echo catch_the_image($activitys_data[1]->ID)?>"
                                                    alt="">
                                            <div class="activity-conleftTitle conleftTitle-right"><p><?php echo $activitys_data[1]->post_title?></p></div>
                                        </div>
                                        </a>
                                        <a href="?p=<?php echo $activitys_data[2]->ID?>">
                                        <div class="event-conrighttimg2"><img
                                                    src="<?php echo catch_the_image($activitys_data[2]->ID)?>"
                                                    alt="">
                                            <div class="activity-conleftTitle conleftTitle-right"><p><?php echo $activitys_data[2]->post_title?></p></div>
                                        </div>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="management">
                                <div class="consultant">
                                    <div class="widget-header">
                                        <h3><span><?php  $cat = get_category($consultants);echo $cat->name;?></span><a href="?cat=<?php echo $consultants?>">查看更多<span class="top-gray"></span></a></h3>
                                    </div>
                                    <?php $consultants = get_posts("category=$consultants&numberposts=6"); ?>
                                    <?php if( $consultants ) : ?>
                                        <ul>
                                            <!--获取分类和分类下的文章列表-->
                                            <?php foreach( $consultants as $consultant ):  ?>
                                                <li>
                                                    <a href="?p=<?php echo $consultant->ID?>">
                                                        <div class="consultant">
                                                            <div class="consultant-listImg">
                                                                <img src="<?php echo catch_the_image($consultant->ID)?>" alt="">
                                                            </div>
                                                            <div class="consultant-content">
                                                                <div class="consultant-contentName"><?php echo $consultant->post_title?></div>
                                                                <div class="consultant-contentText"><?php get_text($consultant) ?></div>
                                                                <div class="consultant-contentLink"><?php echo get_content_link($consultant->post_content) ?></div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <div class="clear"></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="cooperation">
                                <div class="iconList">
                                    <div class="widget-header">
                                        <h3><span><?php  $cat = get_category($cooperations);echo $cat->name;?></span></h3>
                                    </div>
                                    <div class="icons">
                                        <?php $cooperations = get_posts("numberposts=-1&category=$cooperations"); ?>
                                        <?php if( $cooperations ) : ?>
                                        <?php foreach( $cooperations as $cooperation ):  ?>
                                        <div class="iconBox"><a
                                                    href=""
                                                     class="iconLink"><img
                                                        src="<?php echo catch_the_image($cooperation->ID)?>" alt=""
                                                        class="icon"></a></div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="border-bottom"></div>
                        <div class="on-widget-header">
                            <div class="widget-header">
                                <h3><span><?php  $cat = get_category($on);echo $cat->name;?></span></h3>
                            </div>
                        </div>
                    </div>
                    <section class="section-about">

                        <div class="about">
                            <div class="about-content">
                                <?php $on = get_posts("category=$on&numberposts=1"); ?>
                                <?php if( $on ) : ?>
                                    <div class="about-contentTitle">关于我们</div>
                                    <!-- <div class="about-contentTitle-span">About us</div> -->
                                    <div class="about-contentText"><?php get_text($on[0]) ?></div>
                                    <div class="about-contentLink"><?php echo get_content_link($on[0]->post_content) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- .wrap -->
    <script>
        var ajaxurl = '<?php echo admin_url('admin-ajax.php')?>';
        $(".inner-holder ul li").on("click", function (){
            var _this = this;
            var id = $(this).attr("class");
            var data={
                tape:id,
                action : 'get_ajax_newa',
            }
            $.ajax({
                type:'post',
                url:ajaxurl,
                data:data,
                cache:false,
                dataType:'html',
                success:function(result){
                    $(".inner-holder ul li a").removeClass("newsActive")
                    $(_this).find("a").addClass("newsActive");
                    $('.collection-list').empty();
                    $(".collection-list").append(result);
                },
                error:function(data){
                    alert("err");
                }
            });
            return false;

        });


    </script>
<?php get_footer();

