<!DOCTYPE html>
<html lang="{snippet:language}" dir="{snippet:text_direction}">
<head>
<title>{snippet:title}</title>
<meta charset="{snippet:charset}" />
<meta name="description" content="{snippet:description}" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php include FS_DIR_APP . 'includes/templates/default.catalog/layouts/styles/less.inc.php'; ?>
{snippet:head_tags}
{snippet:style}
</head>
<body>

{snippet:content}

{snippet:foot_tags}
<script src="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'js/app.min.js'); ?>"></script>
{snippet:javascript}
</body>
</html>