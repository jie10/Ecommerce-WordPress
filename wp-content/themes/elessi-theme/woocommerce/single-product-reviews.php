<?php
/**
 * Display single product reviews (comments)
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 4.3.0
 */
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly.
endif;

if (!comments_open()) :
    return;
endif;

global $product;

$ratings = $product->get_rating_count();
$rating_item = array(
    5 => $product->get_rating_count(5),
    4 => $product->get_rating_count(4),
    3 => $product->get_rating_count(3),
    2 => $product->get_rating_count(2),
    1 => $product->get_rating_count(1)
);

$count = $product->get_review_count();

$reviewForm = (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product->get_id())) ? true : false;

$classStatistic = 'nasa-statistic-ratings';
if (!$reviewForm) :
    $classStatistic .= ' fullwidth';
endif;

?>
<div id="reviews" class="woocommerce-Reviews">
    <!-- Show statistic Ratings -->
    <div class="<?php echo esc_attr($classStatistic); ?>">
        <h2>
            <?php echo sprintf(esc_html__('Based on %s reviews', 'elessi-theme'), $count); ?>
        </h2>
        <div class="nasa-avg-rating">
            <span class="avg-rating-number">
                <?php echo 0 < $count ? $product->get_average_rating() : '0.00'; ?>
            </span>
            <?php esc_html_e('Overall', 'elessi-theme'); ?>
        </div>

        <table class="nasa-rating-bars">
            <tbody>
                <?php for ($i = 5; $i >= 1; $i--): ?>
                    <?php
                    echo '<!-- ' . $i . ' stars -->';
                    $per = ($ratings > 0 && isset($rating_item[$i])) ? round($rating_item[$i] / $ratings * 100, 2) : 0;
                    $width = $i/5 * 100;
                    ?>

                    <tr class="nasa-rating-bar">
                        <td class="star-rating-wrap">
                            <div class="star-rating">
                                <span style="width: <?php echo esc_attr($width); ?>%"></span>
                            </div>
                        </td>
                        <td class="nasa-rating-per-wrap">
                            <div class="nasa-rating-per">
                                <span style="width: <?php echo esc_attr($per); ?>%" class="nasa-per-content"></span>
                            </div>
                        </td>
                        <td class="nasa-ratings-number text-center">
                            <?php echo $per; ?>%
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>

    <?php if ($reviewForm) : ?>
        <div id="review_form_wrapper">
            <div id="review_form">
                <?php
                $commenter = wp_get_current_commenter();

                $comment_form = array(
                    /* translators: %s is product title */
                    'title_reply' => have_comments() ? __('Add a review', 'elessi-theme') : sprintf(__('Be the first to review &ldquo;%s&rdquo;', 'elessi-theme'), get_the_title()),
                    /* translators: %s is product title */
                    'title_reply_to' => __('Leave a Reply to %s', 'elessi-theme'),
                    'title_reply_before' => '<span id="reply-title" class="comment-reply-title">',
                    'title_reply_after' => '</span>',
                    'comment_notes_after' => '',
                    'fields' => array(
                        'author' => '<p class="comment-form-author"><label for="author">' . esc_html__('Name', 'elessi-theme') . '&nbsp;<span class="required">*</span></label> ' .
                        '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" required /></p>',
                        'email' => '<p class="comment-form-email"><label for="email">' . esc_html__('Email', 'elessi-theme') . '&nbsp;<span class="required">*</span></label> ' .
                        '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" required /></p>',
                    ),
                    'label_submit' => __('Submit', 'elessi-theme'),
                    'logged_in_as' => '',
                    'comment_field' => '',
                );

                $account_page_url = wc_get_page_permalink('myaccount');
                if ($account_page_url) {
                    /* translators: %s opening and closing link tags respectively */
                    $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf(esc_html__('You must be %1$slogged in%2$s to post a review.', 'elessi-theme'), '<a href="' . esc_url($account_page_url) . '">', '</a>') . '</p>';
                }

                if (wc_review_ratings_enabled()) {
                    $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__('Your rating', 'elessi-theme') . '</label><select name="rating" id="rating" required>' .
                        '<option value="">' . esc_html__('Rate&hellip;', 'elessi-theme') . '</option>' .
                        '<option value="5">' . esc_html__('Perfect', 'elessi-theme') . '</option>' .
                        '<option value="4">' . esc_html__('Good', 'elessi-theme') . '</option>' .
                        '<option value="3">' . esc_html__('Average', 'elessi-theme') . '</option>' .
                        '<option value="2">' . esc_html__('Not that bad', 'elessi-theme') . '</option>' .
                        '<option value="1">' . esc_html__('Very poor', 'elessi-theme') . '</option>' .
                    '</select></div>';
                }

                $comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__('Your review', 'elessi-theme') . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

                comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_form));
                ?>
            </div>
        </div>
    <?php else : ?>
        <p class="woocommerce-verification-required"><?php esc_html_e('Only logged in customers who have purchased this product may leave a review.', 'elessi-theme'); ?></p>
    <?php endif; ?>
        
    <div class="nasa-clear-both"></div>
        
    <div id="comments">
        <h2 class="woocommerce-Reviews-title">
            <?php
            if ($count && wc_review_ratings_enabled()) :
                /* translators: 1: reviews count 2: product name */
                $reviews_title = sprintf(esc_html(_n('%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'elessi-theme')), esc_html($count), '<span>' . get_the_title() . '</span>');
                echo apply_filters('woocommerce_reviews_title', $reviews_title, $count, $product); // WPCS: XSS ok.
            else :
                esc_html_e('Reviews', 'elessi-theme');
            endif;
            ?>
        </h2>

        <?php if (have_comments()) : ?>
            <ol class="commentlist">
                <?php wp_list_comments(apply_filters('woocommerce_product_review_list_args', array('callback' => 'woocommerce_comments'))); ?>
            </ol>
        <?php
        if (get_comment_pages_count() > 1 && get_option('page_comments')) :
            echo '<nav class="woocommerce-pagination">';
            paginate_comments_links(
                apply_filters('woocommerce_comment_pagination_args', array(
                    'prev_text' => '&larr;',
                    'next_text' => '&rarr;',
                    'type' => 'list',
                ))
            );
            echo '</nav>';
        endif;
        ?>
        <?php else : ?>
            <p class="woocommerce-noreviews"><?php esc_html_e('There are no reviews yet.', 'elessi-theme'); ?></p>
        <?php endif; ?>
    </div>

    <div class="clear"></div>
</div>
