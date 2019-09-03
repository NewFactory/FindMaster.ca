<?php

/*

  ╔═╗╔╦╗╔═╗╔╦╗
  ║ ║ ║ ╠╣ ║║║ http://otshelnik-fm.ru
  ╚═╝ ╩ ╚  ╩ ╩

 */


if ( ! defined( 'ABSPATH' ) )
    exit;

require_once 'inc/settings.php';

/* функция ватермарка на изображение */
add_filter( 'wp_generate_attachment_metadata', 'otfw_watermark', 20, 2 );
function otfw_watermark( $meta, $id ) {
    // нет GD, нет размеров и не изображение
    if ( ! function_exists( 'getimagesize' ) || ! isset( $meta['sizes'] ) || ! wp_attachment_is( 'image', $id ) )
        return $meta;

    // на мелкие не ставим watermark
    $min = absint( rcl_get_option( 'otfw_wh', '300' ) );
    if ( $meta['width'] <= $min || $meta['height'] <= $min )
        return $meta;

    // путь до ватермарка
    $water_path = rcl_get_option( 'otfw_path' );
    if ( ! $water_path )
        return $meta;

    $upload_path = wp_upload_dir();
    if ( isset( $upload_path['basedir'] ) ) {
        $file = trailingslashit( $upload_path['basedir'] . '/' ) . $meta['file'];
    } else {
        $file = trailingslashit( $upload_path['path'] ) . $meta['file'];
    }

    // стоп-слово
    $exclude = rcl_get_option( 'otfw_stop', 'no-water' );
    $title   = get_the_title( $id );

    if ( strpos( $title, $exclude ) !== false )
        return $meta;

    // процесс
    otfw_add_watermark( $file, $water_path );

    return $meta;
}

function otfw_add_watermark( $file, $water_path ) {
    //
    list($orig_w, $orig_h, $orig_type) = @getimagesize( $file );

    //load watermark
    $watermark = imagecreatefromstring( file_get_contents( $water_path ) );

    list($wm_width, $wm_height) = @getimagesize( $water_path );

    // загрузим ресурс изображения
    $image = otfw_load_image( $file );

    $offset_b = rcl_get_option( 'otfw_ob', 0 );
    $offset_r = rcl_get_option( 'otfw_or', 0 );

    // задаем отступ по ширине и высоте
    imagecopy( $image, $watermark, $orig_w - ($wm_width + $offset_r), $orig_h - ($wm_height + $offset_b), 0, 0, $wm_width, $wm_height );

    //save image backout
    switch ( $orig_type ) {
        case IMAGETYPE_GIF:
            imagegif( $image, $file );
            break;
        case IMAGETYPE_PNG:
            imagepng( $image, $file, 9 );
            break;
        case IMAGETYPE_JPEG:
            imagejpeg( $image, $file, 90 );
            break;
    }

    imagedestroy( $watermark );
    $res = imagedestroy( $image );

    return $res;
}

// файл в ресурс
function otfw_load_image( $file ) {
    if ( is_numeric( $file ) )
        $file = get_attached_file( $file );

    // Нужно больше памяти
    wp_raise_memory_limit( 'image' );

    $image = imagecreatefromstring( file_get_contents( $file ) );

    return $image;
}
