<div class="gallery-header">
    <h1 class="gallery-title">Top <?= $data['tags_count']?> flickr popular tags now</h1>
</div>

<div id="gallery" class="gallery_wr cols_4">
    <div class="gallery_nav_wr media container">
        <div class="gallery_nav media-body media-middle">
            <?php if(!empty($data['tags'])):?>
                <ul>
                    <?php foreach($data['tags'] as $tag):
                        $class = ($tag == $data['tag']) ? 'active' : '';?>
                        <li class="<?= $class?>"><a href="/gallery/tags/<?= $tag?>"><?= $tag?></a></li>
                    <?php endforeach;?>
                </ul>
            <?php endif;?>
        </div>
        <div class="gallery_nav media-right media-middle">
            <a href="#" class="gallery_switcher"></a>
        </div>
    </div>
    <div class="gallery container">
        <?php if($data['images']):?>
            <div class="row">
                <?php foreach($data['images'] as $k => $img):?>
                    <div class="item" style="position: absolute; left: 0px; top: 0px;">
                        <a title="<?= $img['title']?>" rel="fancy_<?= $k?>" class="fancybox" href="<?= $img['url']?>">
                            <img src="<?= $img['url']?>" alt="<?= $img['title']?>">						
                        </a>
                    </div>
                <?php endforeach;?>
            </div>
        <?php else:?>
            <div class="alert alert-warning"><strong>Sorry(</strong> There are currently no images in this category.</div>
        <?php endif;?>
    </div>
</div>