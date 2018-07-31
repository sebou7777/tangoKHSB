<div class="box menu tostick">
    <p class="menu-label">CATEGORIES</p>
    <ul class="menu-list">
        <?php foreach(tango_get_categories() as $category): ?>
            <li><a <?php echo (($category->is_selected) ? 'class="is-active"' : '') ?> href="<?php echo get_category_link($category) ?>"><?php echo $category->name ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="box menu">
    <p class="menu-label">ARTICLES RECENTS</p>
    <ul class="menu-list">
        <?php foreach(tango_get_recents() as $post): ?>
            <li><a href="<?php echo $post->post_url ?>"><?php echo $post->post_title ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>