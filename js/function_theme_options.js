jQuery(document).ready(function() {
    jQuery('#add_footer').click(function() { //增加資料輸入
        jQuery("#footer_list > br:last").after("<input type='text' name='footer[]' /><input type='text' name='footer_en[]' /><br />");
    });
    jQuery('#add_flex').click(function() { //增加資料輸入
        jQuery("#flex_list > br:last").after("<input type='text' name='flex[]' /><input type='text' name='flex_en[]' /><br />");
    });
    jQuery('#add_marquee').click(function() { //增加資料輸入
        jQuery("#marquee_list > br:last").after("<input type='text' name='marquee[]' /><input type='text' name='marquee_en[]' /><br />");
    });
    //可改進成末項 != "" ，就新増欄位
});