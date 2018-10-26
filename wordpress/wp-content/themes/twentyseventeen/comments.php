<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				/* translators: %s: post title */
				printf( _x( 'One Reply to &ldquo;%s&rdquo;', 'comments title', 'twentyseventeen' ), get_the_title() );
			} else {
				printf(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s Reply to &ldquo;%2$s&rdquo;',
						'%1$s Replies to &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'twentyseventeen'
					),
					number_format_i18n( $comments_number ),
					get_the_title()
				);
			}
			?>
		</h2>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'avatar_size' => 100,
					'style'       => 'ol',
					'short_ping'  => true,
					'reply_text'  => twentyseventeen_get_svg( array( 'icon' => 'mail-reply' ) ) . __( 'Reply', 'twentyseventeen' ),
				) );
			?>
		</ol>

		<?php the_comments_pagination( array(
			'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous', 'twentyseventeen' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
		) );

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyseventeen' ); ?></p>
	<?php
	endif;

	comment_form();
    /* 新闻 */
    $newsletters = NEWSLETTERS;
	?>

    <div class="popular">
        <section class="buzz-widget" data-component="BuzzWidget">
            <div class="widget-header">
                <h3><span>热门快讯</span>
<!--                    <a href="?cat=--><?php //echo $newss?><!--">查看更多</a>-->
                </h3>
            </div>
            <ul  data-component="RankingList" data-order="reputation">
                <?php $newsletters_data = get_posts("category=$newsletters&numberposts=4"); ?>
                <?php if( $newsletters_data ) : ?>
                    <?php foreach( $newsletters_data as $newsletters ):  ?>
                        <li class="app-ranking-list__item">
                            <div class="app-ranking-list__link app-ranking-list__link_kuaix clearfix newsletter-con" >
                                <div class="app-ranking-list__content"><h5
                                            class="app-ranking-list__name app-ranking-list__name_h5"><a href="?p=<?php echo $newsletters->ID?>"><?php echo $newsletters->post_title?></a></h5>
                                    <div class="app-ranking-list__data"><?php echo date("m-d", strtotime($newsletters->post_date_gmt))?></div>
                                    <p class="app-ranking-list__name_kuaix"><?php get_text($newsletters) ?></p>
                                    <div class="app-ranking-link__kuaix"><?php echo get_content_link($newsletters->post_content) ?></div>
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

</div><!-- #comments -->


