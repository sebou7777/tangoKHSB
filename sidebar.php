<div class="box menu tostick">
    <h4>CATEGORIES</h4>
    <ul class="menu-list">
        <?php foreach(tango_get_categories() as $category): ?>
            <li><a <?php echo (($category->is_selected) ? 'class="is-active"' : '') ?> href="<?php echo get_category_link($category) ?>"><?php echo $category->name ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="box menu">
    <h4>ARTICLES RECENTS</h4>
    <ul class="menu-list">
        <?php foreach(tango_get_recents() as $post): ?>
            <li><a href="<?php echo $post->post_url ?>"><?php echo $post->post_title ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>