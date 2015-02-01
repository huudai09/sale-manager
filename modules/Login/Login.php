<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo ASSET ?>/style/style.css" />
        <script>
            var URL = '<?php e(URL) ?>';
            var ASSET = '<?php e(ASSET) ?>';
        </script>
        <script src="<?php echo ASSET ?>/js/sm.js"></script>
        <title>JS Bin</title>
    </head>
    <body>
        <div id="wrapper" class="noside">
            <div id="content"><?php e($this->loadContent()); ?></div>
        </div>
    </body>
</html>