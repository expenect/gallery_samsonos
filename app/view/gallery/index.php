<div id="content" class="wrapper">
    <div class="top_menu">
        <div id="line1">
            <!--        Load sorter menu-->
            <?php iv('gallery_sorter')?>
        </div>
        <div id="line2">
            <!--        Load pager-->
            <ul id="pager"><?php iv('pager_html')?></ul>
            <!--        Load language switcher-->

        </div>
    </div>
    <div class="gallery-container">
        <!-- Load list of images-->
        <?php iv('gallery_list')?>
    </div>
</div>
