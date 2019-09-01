<?php

function rcl_init_reviews_type($args){

    if(!function_exists('rcl_register_rating_type'))
        return false;

    $args['review-type'] = true;

    rcl_register_rating_type($args);

}

function rcl_get_review_form($atts){

    if(isset($atts['review_id'])){

        $review = rcl_get_review($atts['review_id']);

        $atts = array(
            'user_id' => $review->user_id,
            'object_id' => $review->object_id,
            'rating_type' => $review->rating_type,
            'object_author' => $review->object_author,
            'review_id' => $review->review_id,
        );

    }

    extract(shortcode_atts(array(
        'user_id' => 0,
        'object_id' => 0,
        'rating_type' => '',
        'object_author' => 0,
        'review_id' => 0
    ),
    $atts));

    $ratingBox = new Rcl_Rating_Box(array(
        'object_id' => $object_id,
        'object_author' => $object_author,
        'rating_type' => $rating_type,
        'view_total_rating' => false,
        'output_type' => rcl_get_option('rating_type_' . $rating_type, 2),
        'item_count' => rcl_get_option('rating_item_amount_' . $rating_type, 5),
        'vote_max' => rcl_get_option('rating_point_' . $rating_type, 5),
        'vote_count' => ($review_id)? 1: 0,
        'total_rating' => ($review_id)? $review->rating_value: 0,
        'user_can' => array(
            'vote' => true
        )
    ));

    $formFields = array(
        array(
            'type' => 'custom',
            'slug' => 'rvs-rating-box',
            'title' => __('Укажите значение рейтинга и текст отзыва ниже'),
            'content' => $ratingBox->box_content()
        ),
        array(
            'slug' => 'rvs-review-content',
            'type' => 'textarea',
            'title' => __('Текст отзыва'),
            'default' => $review_id? $review->review_content: '',
            'required' => 1
        ),
        array(
            'slug' => 'rvs-rating-data',
            'type' => 'hidden',
            'value' => 0
        ),
        array(
            'slug' => 'rvs-review-type',
            'type' => 'hidden',
            'value' => $rating_type
        )
    );

    if($review_id){
        $formFields[] = array(
            'slug' => 'review_id',
            'type' => 'hidden',
            'value' => $review_id
        );
    }

    $content = '<div class="rvs-review-box">';

    $content .= rcl_get_form(array(
        'fields' => $formFields,
        'submit' => __('Отправить'),
        'onclick' => 'rcl_send_form_data("rcl_send_review",this);return false;'
    ));

    $content .= '</div>';

    return $content;
}

function rcl_get_reviews_list($args){

    $query = new Rcl_Reviews();

    $count = $query->count($args);

    if(!$count) return false;

    $pagenavi = new Rcl_PageNavi('rvs', $count);

    $args['offset'] = $pagenavi->offset;
    $args['number'] = 30;

    $reviews = rcl_get_reviews($args);

    global $review;

    $content = $pagenavi->pagenavi();

    $content .= '<div class="rvs-reviews-list">';

    foreach($reviews as $review){

        $RclRatingBox = new Rcl_Rating_Box(array(
            'view_total_rating' => (rcl_get_option('rating_type_' . $review->rating_type, 2) == 2)? false: true,
            'output_type' => rcl_get_option('rating_type_' . $review->rating_type, 2),
            'item_count' => rcl_get_option('rating_item_amount_' . $review->rating_type, 5),
            'vote_max' => rcl_get_option('rating_point_' . $review->rating_type, 5),
            'vote_count' => 1,
            'total_rating' => $review->rating_value //rcl_get_vote_value($review->user_id, $review->service_id, 'service')
        ));

        $button = $review->rating_value > 0? $RclRatingBox->buttons['plus']: $RclRatingBox->buttons['minus'];

        $ratingBox = ($RclRatingBox->output_type == 2)? $RclRatingBox->box_content(): '<div class="rcl-rating-box rating-type-review-customer box-default">'
                    . '<div class="rating-wrapper">'
                        . '<span class="user-vote '.$RclRatingBox->get_class_vote_button($button['type']).' '.$button['class'].'">'
                                . '<i class="rcli '.$button['icon'].'" aria-hidden="true"></i>'
                            . '</span>'
                        . '</div>'
                    . '</div>';

        $content .= '<div class="review-item" id="review-'.$review->review_id.'">';

        $content .= rcl_get_include_template('rvs-review.php', __FILE__, array(
            'review' => $review,
            'rating_box' => $ratingBox
        ));

        $content .= '</div>';

    }

    $content .= '</div>';

    $content .= $pagenavi->pagenavi();

    return $content;

}

function rcl_get_manager($items){

    if(!$items) return false;

    rcl_dialog_scripts();

    $content = '<div class="rvs-manager preloader-box">';

    foreach($items as $item){

        $class = (isset($item['class']))? $item['class']: '';
        $link = (isset($item['url']))? $item['url']: '#';
        $attrs['title'] = (isset($item['title']))? $item['title']: $item['label'];
        $attrs['onclick'] = (isset($item['onclick']))? $item['onclick']: false;
        $datas = array();
        $attributs = array();

        if(isset($item['data'])){

            foreach($item['data'] as $k=>$value){
                if(!$value) continue;
                $datas[] = 'data-'.$k.'="'.$value.'"';
            }

        }

        foreach($attrs as $attr=>$value){
            if(!$value) continue;
            $attributs[] = $attr.'=\''.$value.'\'';
        }

        $content .= '<div id="'.$item['id'].'-item" class="manager-item '.$class.'">';

            $content .= '<a href="'.$link.'" class="recall-button" '.implode(' ',$attributs).' '.implode(' ',$datas).'>';

            if(isset($item['icon'])):
                $content .= '<i class="rcli '.$item['icon'].'" aria-hidden="true"></i>';
            endif;

            if(isset($item['label'])):
                $content .= '<span class="item-label">'.$item['label'].'</span>';
            endif;

            if(isset($item['counter'])):
                $content .= '<span class="item-counter">'.$item['counter'].'</span>';
            endif;

            $content .= '</a>';

        $content .= '</div>';

    }

    $content .= '</div>';

    return $content;
}

function rcl_get_review_manager($review_id = false){
    global $user_ID, $review;

    if(!is_object($review))
        $review = rcl_get_review($review_id);

    if(!$review) return false;

    $items = array();

if($review->user_id == $user_ID || rcl_is_user_role($user_ID, 'administrator')){

        $items[] = array(
            'id' => 'rvs-review-remove',
            'label' => __('Удалить'),
            'icon' => 'fa-remove',
            'onclick' => 'ra_ajax('.json_encode(array(
                'action' => 'rcl_ajax_review_remove',
                'review_id' => $review->review_id,
                'confirm' => __('Вы уверены?')
            )).',this);return false;'
        );

        $items[] = array(
            'id' => 'rvs-review-edit',
            'label' => __('Изменить'),
            'icon' => 'fa-pencil-square-o',
            'onclick' => 'ra_ajax('.json_encode(array(
                'action' => 'rcl_ajax_get_review_edit_form',
                'review_id' => $review->review_id
            )).',this);return false;'
        );

    }

    $items = apply_filters('rcl_manager_review_items', $items, $review->review_id, $review);

    return rcl_get_manager($items);

}

