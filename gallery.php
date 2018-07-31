<div class="photos gallery content">
<?php foreach(get_gallery() as $i => $img): ?><a href="<?php echo $img['full'] ?>" data-caption="<?php echo $img['descr'] ?>"><img id="dd<?php echo $i ?>" src="<?php echo $img['thumb'] ?>" alt=""></a><?php endforeach; ?>
</div>
