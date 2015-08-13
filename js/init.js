$(document).ready(function (){
    $("#marquee").marquee();//執行跑馬燈

    //$(".tablesorter").tablesorter( {sortList: [[1,1], [0,0]]});//表格排序

    $('.flexslider').flexslider({
        animation: "slide"
    });//圖片牆啟動
    click_count = 0;
    $('.copyright').on('click', function test (argument) {
        if (click_count++ > 10) {
            input_string = prompt('你想表示:');
            switch (input_string) {
                case 'color':
                    alert('hey color');
                    break;
            }
        }
    })
    $('.lastmodified').on('click', function test (argument) {
        alert('哈囉，我是這主題設計者，綽號叫TCC，是高應大資工系大學部102級的學生。\n你的瀏覽器版本是：' + navigator.appVersion + '\n平台：' + navigator.platform + '\n語言：' + navigator.language);
        console.log(navigator);
    })
})