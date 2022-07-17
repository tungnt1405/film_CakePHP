<url>
    <loc><?php echo BASE_URL?></loc>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
</url>
<url>
    <loc><?= $url; ?></loc>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
</url>
<url>
    <loc><?= $url; ?>articles</loc>
    <priority>0.8</priority>
</url>
<url>
    <loc><?= $url; ?>blogs</loc>
    <priority>0.8</priority>
</url>
<url>
    <loc><?= $url; ?>projects</loc>
    <priority>0.8</priority>
</url>
<url>
    <loc><?= $url; ?>contact</loc>
    <priority>0.5</priority>
</url>
<?php foreach($articles as $article){?>
<url>
    <loc><?php echo $url.'articles/'.$article->slug ?></loc>
    <lastmod><?php echo $article->modified ?></lastmod>
    <priority>0.8</priority>
</url>
<?php } ?>
<?php foreach($blogs as $blog){?>
<url>
    <loc><?php echo $url.'blogs/'.$blog->slug ?></loc>
    <lastmod><?php echo $blog->modified ?></lastmod>
    <priority>0.8</priority>
</url>
<?php } ?>
<?php foreach($projects as $project){?>
<url>
    <loc><?php echo $url.'projects/'.$project->slug ?></loc>
    <lastmod><?php echo $project->modified ?></lastmod>
    <priority>0.8</priority>
</url>
<?php } ?>