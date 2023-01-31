<link rel="stylesheet/less" type="text/css" href="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'less/variables.less'); ?>" />
<link rel="stylesheet/less" type="text/css" href="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'less/framework.less'); ?>" />
<link rel="stylesheet/less" type="text/css" href="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'less/app.less'); ?>" />
<? if(@$_GET['styletype'] == 'checkout') { ?> 
    <link rel="stylesheet/less" type="text/css" href="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'less/checkout.less'); ?>">
<? } ?>
<? if(@$_GET['styletype'] == 'printable') { ?> 
    <link rel="stylesheet/less" type="text/css" href="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'less/printable.less'); ?>" />
<? } ?>
<script>
  less = {
    env: "development",
    async: false,
    fileAsync: false,
    poll: 1000,
    functions: {},
    dumpLineNumbers: "comments",
    relativeUrls: false,
    rootpath: "https://yoy-nay-bude.webbrain.pro/"
  };
</script>
<script src="https://cdn.jsdelivr.net/npm/less" ></script>