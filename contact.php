<?php if(isset($_POST['submit'])): ?>
<section class="hero is-light">
    <div class="hero-body">
        <div class="container has-text-centered">
            <p class="subtitle">
                Votre message a bien été envoyé.<br/>
                Nous vous répondrons dès que possible.
            </p>
        </div>
    </div>
</section>
<?php endif; ?>

<div class="columns content contact">
    <div class="column is-three-quarters">
        <div class="column">
            <?php the_content() ?>
        </div>
        <form method="post" action="" id="#contact">
            <div class="contact">
                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field">
                            <p class="control is-expanded has-icons-left">
                                <input class="input" type="text" name="nom" id="nom" placeholder="Prénom Nom" required value="">
                                <span class="icon is-small is-left">
                          <i class="fas fa-user"></i>
                        </span>
                            </p>
                        </div>
                        <div class="field">
                            <p class="control is-expanded has-icons-left">
                                <input class="input" type="email" name="email" id="email" placeholder="Email" value="" required>
                                <span class="icon is-small is-left">
                          <i class="fas fa-envelope"></i>
                        </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field">
                            <p class="control is-expanded has-icons-left">
                                <input class="input" type="text" name="objet" id="objet" placeholder="Objet du mail" required value="">
                                <span class="icon is-small is-left">
                          <i class="fas fa-comments"></i>
                        </span>
                            </p>
                        </div>
                        <div class="field">
                            <p class="control is-expanded has-icons-left">
                                <input class="input" type="text" name="telephone" id="telephone" placeholder="Téléphone" value="">
                                <span class="icon is-small is-left">
                          <i class="fas fa-phone"></i>
                        </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field">
                            <p class="control">
                                <textarea name="message" class="textarea" id="message" placeholder="Votre message" required></textarea>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-grouped is-grouped-centered">
                    <div class="control">
                        <button class="button" type="submit" name="submit">Envoyer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="column is-one-quarter">
        <div id="gmap-contact"></div>
    </div>
</div>
<script>
    locationIQAddresses.push({"address":"35 rue Jussieu 75005 Paris", "title":"Ecole Victor", "zoom":"15", "pin_url":"", 'container':'gmap-contact'});
</script>





