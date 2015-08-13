        <footer class="footer">
            <div class="copyright">
                © 2014-2015 <a href="<? bloginfo("url");?>"><? bloginfo("name");?></a>
            </div>
            <div class="lastmodified">
                <?_e('last Update:', 'tcc');?>
                <script>
                    //取得最近更新日期
                    update = new Date(document.lastModified);
                    theYear = update.getFullYear();
                    theMonth = update.getMonth() + 1;
                    theDate = update.getDate();
                    document.write(theYear + "/" + theMonth + "/" + theDate);
                </script>
            </div>
            <?//自訂頁尾資訊
            $options = ThemeOptions::getOptions();
            foreach ($options[get_locale()]['footer']['info'] as $key => $value) {
                echo '<div>'.$value.'</div>';
            }
            ?>
        </footer>
    </div>
    <div id="gotop"><i class="fa fa-chevron-up"></i><div></div></div>
    <div class="loading hide"><div><?_e('Loading...', 'tcc');?><br><img src="<?bloginfo('template_directory')?>/images/ajax-loader.gif"></div></div>
</body>
</html>