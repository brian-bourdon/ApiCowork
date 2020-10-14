<?php
class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('User_model');
        $this->load->model('ResAbonnement_model');
    }

    public function index() {
        $ress = $this->ResAbonnement_model->get_all()->result_array();
        print_r($ress);
        foreach ($ress as $res) {
            if($res["id_abonnement"] == 2 || $res["id_abonnement"] == 4) {
                $infos_user = $this->User_model->get_user_by_id($res["id_user"])->row_array();
                if($res["id_abonnement"] == 2) $delay = "12";
                else $delay = "4";
                $now = new DateTime();
                $created = new DateTime($res["created_at"]);
                $created = $created->modify('+'.$delay.' month');
                $interval = $created->diff($now);
                if((int)$interval->format("%r%d") >= -1 && (int)$interval >= 0) {
                    $to  = $infos_user["email"];
                    $subject = 'Renouveler votre abonnement CO\'Work !';
                    $message = '
                    <html>
                    <head>
                    <title>Rennouveler votre abonnement CO\'Work !</title>
                    </head>
                    <body>
                    <p>Il vous reste plus que '.(string)$interval->format("%d").' jours pour renouveller votre abonnement.</p>
                    </body>
                    </html>
                    ';

                    $headers[] = 'MIME-Version: 1.0';
                    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
                    $headers[] = 'From: Cowork <noreply@cowork.com>';

                    mail($to, $subject, $message, implode("\r\n", $headers));
                }
            }
        }
    }
}
?>