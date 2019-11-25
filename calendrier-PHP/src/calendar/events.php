<?php
namespace PPE1\Calendar;

class Events {
   
    /**
     * Renvoie un tableau contenant les events compris entre
     * deux dates
     * @param $start Date de début
     * @param $end Date de fin
     * @return array
     */
    public function getEventsBetween(\DateTime $start,\DateTime $end): array {
        //Code bullshit pour ne pas oublier le TODO
//        $pdo = new PDO();
//        $sql = "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}'";
//        $statement = $pdo->query($sql);
//        $results = $statement->fetchAll();
//        return $results;
        return [];
    }
    
    /**
     * Renvoie un tableau contenant les events compris entre
     * deux dates indéxé par jour
     * @param $start Date de début
     * @param $end Date de fin
     * @return array
     */
    public function getEventsBetweenByDay(\DateTime $start,\DateTime $end): array {
        //Code bullshit pour ne pas oublier le TODO
//        $events = $this->getEventsBetween($start, $end);
//        $days = [];
//        foreach($events as $event){
//            $date = explode(' ', $event['start'])[0];
//            if(!isset($days[$date])){
//                $days[$date] = [$event];
//            }
//            else{
//                $days[$date][] = $event;
//            }
//        }
//        return $days;
        return [];
    }
    
    /**
     * Récupère un évènement
     * @param $id
     * @return array
     */
    public function find(int $id){
        
    }
}
?>