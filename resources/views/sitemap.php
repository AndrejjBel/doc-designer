<html lang="ru-RU">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta content="<?php echo $data['description'];?>" name="description" />
    <title>Sitemap</title>

    <!-- favicon -->
    <link rel="icon" href="../public/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="../public/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../public/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../public/images/favicon/favicon-16x16.png">

</head>
<body>
    <?= '<?xml version="1.0" encoding="UTF-8" ?>'; ?><?php $url = config('meta', 'url'); ?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
      <url>
        <loc><?= $url; ?></loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
      </url>

      <url>
        <loc><?= $url; ?>/info</loc>
        <priority>0.5</priority>
        <changefreq>daily</changefreq>
      </url>
    </urlset>
</body>
</html>
