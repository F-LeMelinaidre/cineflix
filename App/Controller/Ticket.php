<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\DAO\List\StatusFilm;
    use Cineflix\App\DAO\TicketDao;
    use Cineflix\App\Model\TicketModel;
    use Cineflix\Core\AbstractController;
    use Cineflix\Core\Util\AuthConnect;

    class Ticket extends AbstractController
    {

        public function __construct()
        {
            parent::__construct();

            if(!AuthConnect::isConnected()) {
                header('Location: /');
                exit();
            }

            $this->page_active = StatusFilm::EN_SALLE;
        }
        public function buy(int $seance = null): string
        {
            if(is_numeric($seance)) {
                $_SESSION['film']['seance'] = $seance;
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                if($_POST['quantity']>=1 || $_POST['quantity']<=10) {

                    $ticketDao = new TicketDao();
                    $id = $ticketDao->count() + 1;

                    $nb = $_POST['quantity'];
                    $tickets = [];
                    $total_tarifs = 0;

                    for($i = 1; $i<=$nb; $i++) {
                        $ticket = new TicketModel($_SESSION['film']);
                        $ticket->setTicketId($id);

                        $tickets[] = [ 'id' => $ticket->getTicketId(),
                                       'adherent_id' => AuthConnect::getSession()['id'],
                                       'tarif' => 8.50
                        ];
                        $total_tarifs += 8.5;
                        $id++;
                    }
var_dump($tickets);
                    echo $total_tarifs.'€';
                    //$ticketDao->saveAll();

                }

            }


            $this->addJavascript(...['path' => 'js/component/FormValidation.js', 'module' => true]);
            return $this->render('Ticket.buy',[]);
        }
    }