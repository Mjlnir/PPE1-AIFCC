<?php
namespace PPE1;

class Month {
    
    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    private $months = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    public $month,$year;
    
    /**
     * Month constructor
     * @param int $month Mois compris entre 1 et 12
     * @param int $year Annee
     * @throws \Exception
     */
    public function __construct(?int $month = null, ?int $year = null)
    {
        if ($month === null || $month < 1 || $month > 12) {
            $month = intval(date('m'));
        }
        if( $year === null){
            $year = intval(date('Y'));
        }
        $this->month = $month;
        $this->year = $year;
    }
    
    /**
     * Retourne le mois en string
     * @return string
     */
    public function toString (): string {
        return $this->months[$this->month - 1].' '.$this->year;
    }
    
    /**
     * Renvoie le nombre de semaine dans le mois
     * @return int
     */
    public function getWeeks(): int {
        $start = $this->getFirstDay();
        $end = (clone $start)->modify('+1 month -1 day');
        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;
        if($weeks < 0){
            $weeks = intval($end->format('W'));
        }
        return $weeks;
    }
    
    /**
     * Renvoie le premier jour du mois
     * @return \DateTime
     */
    public function getFirstDay(): \DateTime {
        return new \DateTime("{$this->year}-{$this->month}-01");
    }
    
    /**
     * Est-ce que jour et dans le mois en cours
     * @param \DateTime $date 
     * @return bool
     */
    public function withinMonth(\DateTime $date) : bool {
        return $this->getFirstDay()->format('Y-m') === $date->format('Y-m');
    }
    
    /**
     * Reourne le mois précédent
     * @return Month
     */
    public function previousMonth(): Month {
        $month = $this->month - 1;
        $year = $this->year;
        if($month < 1){
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }
    /**
     * Reourne le mois suivant
     * @return Month
     */
    public function nextMonth(): Month {
        $month = $this->month + 1;
        $year = $this->year;
        if($month > 12){
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }
}