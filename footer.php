    <footer class="footer">
        <div class="copyright">
            © 2014-2015 <a href="<? bloginfo("url");?>"><? bloginfo("name");?></a>
        </div>
        <div>
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
        <?//頁尾資訊
        $options = ThemeOptions::getOptions();
        foreach ($options['footer'][substr(get_locale(), 0, 2)] as $key => $value) {
            echo '<div>'.$value.'</div>';
        }
        ?>
        <!--<div id='adress'><?get_option('adress');?></div>
        <div id='phone'><?get_option('phone');?></div>
        <div id='fax'>school_fax</div>
        <div id='email'>school_email</div> -->
    </footer>
    </div>
</body>
</html>