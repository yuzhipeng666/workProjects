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

$cat_ID = get_query_var('cat');
$po =  get_category($cat_ID);
$cID = $po->parent;
if($cID == 0) {
    $cID = $cat_ID;
}
$number = 15;

?>

<?php //echo $cat_ID?>


<div>
<!--    --><?php //include 'container-top.php'; ?>
    <?php
        if ($cID == NEWSS) {
             include 'index-news.php';
        } else if ($cID == DAPPS) {
            include 'index-dapps.php';
        } else if ($cID == ACTIVITYS) {
            include 'index-activity.php';
        } else if ($cID == CHAINS) {
            include 'index-chain.php';
        } else if ($cID == CHARACTERS) {
            include 'index-character.php';
//            include 'index-character-details.php';
        } else if ($cID == NEWSLETTERS) {
            include 'index-newsletter.php';
        } else if ($cID == TRAILS) {
            include 'index-trail.php';
        } else if ($cID == CELEBRITYS) {
            include 'index-celebrity.php';
        } else if ($cID == ON) {
            include 'index-on.php';
        } else if ($cID == CONSULTANTS) {
            include 'index-consultant.php';
        } else if ($cID == COOPERATIONS) {
            include 'index-cooperation.php';
        } else if ($cID == TOPS) {
            include 'index-headline.php';
        }
        get_footer();
    ?>

</div>


