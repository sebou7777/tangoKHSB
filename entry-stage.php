<?php $infos = get_bloc_stage(); ?>
<div class="tile is-ancestor">
    <div class="tile is-parent">
        <article class="tile is-child">
            <div id="gmap-stage" class="content"></div>
        </article>
    </div>
    <div class="tile is-vertical is-8">
        <div class="tile">
            <?php if($infos['print_date'] != 2): ?>
            <div class="tile is-parent">
                <article class="tile is-child box has-text-centered">
                    <i class="fa fa-calendar-alt fa-3x" aria-hidden="true"></i><br/>
                    Le <?php echo $infos['date_format'] ?><br/>
                    de <?php echo $infos['starttime'] ?> à <?php echo $infos['endtime'] ?>
                </article>
            </div>
            <?php endif; ?>
            <div class="tile is-parent">
                <article class="tile is-child box has-text-centered">
                    <i class="fa fa-address-card fa-3x" aria-hidden="true"></i><br/>
                    <?php echo $infos['adresse'] ?> <br/><?php echo $infos['codepostal'] ?> <?php echo $infos['ville'] ?>
                </article>
            </div>
            <div class="tile is-parent">
                <article class="tile is-child box has-text-centered">
                    <i class="fa fa-phone fa-3x" aria-hidden="true"></i><br/>
                    <br/><?php echo $infos['telephone'] ?>
                </article>
            </div>
        </div>
        <div class="tile is-parent">
            <article class="tile is-child ">
                <?php the_content() ?>
            </article>
        </div>
    </div>
</div>

<script>
    locationIQAddresses.push({"address":"<?php echo $infos['adresse'] ?> <?php echo $infos['codepostal'] ?> <?php echo $infos['ville'] ?>", "title":"Ecole Victor", "zoom":"15", "pin_url":"", 'container':'gmap-stage'});
</script>
