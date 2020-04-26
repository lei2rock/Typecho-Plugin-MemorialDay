<?php
/**
 * 哀悼日全站黑白滤镜 <a href="https://github.com/lei2rock/Typecho-Plugin-MemorialDay" target="_blank">Github</a>
 *
 * @package MemorialDay
 * @author lei2rock
 * @version 1.1.0
 * @link https://github.com/lei2rock
 */

class MemorialDay_Plugin implements Typecho_Plugin_Interface
{
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array(__CLASS__, 'website_set');
        return _t('MemorialDay 插件已启用');
    }

    public static function deactivate()
    {
        return _t('MemorialDay 插件已禁用');
    }

    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $days = new Typecho_Widget_Helper_Form_Element_Text(
            'days',
            null,
            "",
            _t('日期：'),
            _t('日期使用英文逗号 <code>,</code> 分隔，可以自行增加删除日期，举例：<code>0512,0918,1213</code>；<br>如果使用了 CDN，请自行刷新缓存。')
        );
        $form->addInput($days);

        $background = new Typecho_Widget_Helper_Form_Element_Text(
            'background',
            null,
            "",
            _t('替换背景图片地址：'),
            _t('如果设置了 <code>body</code> 背景图片，请选择一张黑白的图片来替换原来的背景图片。')
        );
        $form->addInput($background);
    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {}

    public static function website_set()
    {
        $days = Typecho_Widget::widget('Widget_Options')->plugin('MemorialDay')->days;
        $day_arr = explode(",", $days);
        $background = Typecho_Widget::widget('Widget_Options')->plugin('MemorialDay')->background;
        if (in_array(date('md'), $day_arr)) {
            echo "<style type='text/css'>html{ filter: grayscale(100%); -webkit-filter: grayscale(100%); -moz-filter: grayscale(100%); -ms-filter: grayscale(100%); -o-filter: grayscale(100%); filter: url('data:image/svg+xml;utf8,#grayscale'); filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1); -webkit-filter: grayscale(1);}</style>";
            if ($background != null) {
                echo "<style type='text/css'>body{background:url('$background')!important;background-size:auto!important;background-repeat:repeat!important;background-attachment:fixed!important;}</style>";
            }
        }
    }
}