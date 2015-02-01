<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo ASSET ?>/style/style.css" />
        <script>
            var URL = '<?php e(URL) ?>';
            var ASSET = '<?php e(ASSET) ?>';
            var defaultModule = '<?php e('Calendar'); ?>';
        </script>
        <script src="<?php echo ASSET ?>/js/sm.js"></script>
        <title>JS Bin</title>
    </head>
    <body>
        <div id="wrapper">
            <div id="side">
                <a class="m-link" href="Calendar">Calendar</a>
                <a class="m-link" href="Image">Image</a>
                <a class="m-link m-link-normal" href="Logout">Thoát</a>
            </div>
            <div id="content"><?php e($this->loadContent()); ?></div>
        </div>
        <div class="frame2nd"></div>
    </body>
</html>