<?php
class WPSE_299521_Form {
    public function __construct()
    {
        $this->define_hooks();
    }

    public function controller()
    {

        if(isset($_POST['submit'])) {
            $nom        = filter_input( INPUT_POST, 'nom', FILTER_SANITIZE_STRING );
            $email      = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_STRING | FILTER_SANITIZE_EMAIL );
            $objet      = filter_input( INPUT_POST, 'objet', FILTER_SANITIZE_STRING );
            $telephone  = filter_input( INPUT_POST, 'telephone', FILTER_SANITIZE_STRING );
            $message    = filter_input( INPUT_POST, 'message', FILTER_SANITIZE_STRING );

            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=utf-8';
            $headers[] = 'From: '.$email;
            $headers[] = 'Reply-To: '.$email;

            $text  = '<b>Nom/Prénom : </b>'.$nom.'<br/>';
            $text .= '<b>Email : </b>'.$nom.'<br/><br/>';
            $text .= '<b>Téléphone : </b>'.$telephone.'<br/><br/>';
            $text .= '<b>Objet : </b>'.$objet.'<br/><br/>';
            $text .= '<b>Message : </b><br/>'.nl2br($message);

            mail('tangopolis@free.fr', $objet, $text, implode("\r\n", $headers));
        }
    }

    private function define_hooks()
    {
        add_action('wp', array($this, 'controller'));
    }
}

new WPSE_299521_Form();