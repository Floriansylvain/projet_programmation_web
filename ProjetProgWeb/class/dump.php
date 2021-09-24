<?php

require_once("these.php");

class dump {
    private these $these;

    /**
     * @param these $these
     */
    public function __construct(these $these) {
        $this->these = $these;
    }

    public static function convertDate($old_date) : string {
        return date("Y-m-d", strtotime($old_date));
    }

    public static function getTheseByAuthor($author) : array {
        $theses_array = [];

        $pdo = new PDO('mysql:host=localhost;dbname=projet_prog_web;charset=utf8', 'root', 'root');
        $stmt = $pdo->query("SELECT * FROM theses WHERE author = '$author';");
        while ($obj = $stmt->fetchObject()) {
            $i = 0;
            $theses_array[`$i`] = array();
            foreach ($obj as $elem) {
                array_push($theses_array[`$i`], empty($elem) ? "NULL" : $elem);
                $i++;
            }
        }

        return $theses_array;
    }

    public function sendThese() {
        $data = [
            'author' => $this->these->getAuthor(),
            'id_author' => empty($this->these->getIdAuthor()) ? NULL : $this->these->getIdAuthor(),
            'these_director' => $this->these->getTheseDirector(),
            'title' => $this->these->getTitle(),
            'these_director_name_lastname' => $this->these->getTheseDirectorNameLastname(),
            'id_director' => empty($this->these->getIdDirector())  ? NULL : $this->these->getIdDirector(),
            'soutenance_establishment' => $this->these->getSoutenanceEstablishment(),
            'id_establishment' => empty($this->these->getIdEstablishment()) ? NULL : $this->these->getIdEstablishment(),
            'discipline' => $this->these->getDiscipline(),
            'status' => $this->these->getStatus(),
            'date_first_registration' => empty($this->these->getDateFirstRegistration()) ? NULL : $this->these->getDateFirstRegistration(),
            'date_soutenance' => empty($this->these->getDateSoutenance()) ? NULL : $this->these->getDateSoutenance(),
            'language' => empty($this->these->getLanguage()) ? NULL : $this->these->getLanguage(),
            'id_these' => empty($this->these->getIdThese()) ? NULL : $this->these->getIdThese(),
            'online' => $this->these->isOnline() ? "yes" : "no",
            'date_publication' => empty($this->these->getDatePublication()) ? NULL : $this->these->getDatePublication(),
            'date_update' => empty($this->these->getDateUpdate()) ? NULL : $this->these->getDateUpdate()
        ];
        $sql = "INSERT INTO theses (author, id_author, these_director, title, these_director_name_lastname, id_director, soutenance_establishment, id_establishment, discipline, status, date_first_registration, date_soutenance, language, id_these, online, date_publication, date_update) VALUES (:author, :id_author, :these_director, :title, :these_director_name_lastname, :id_director, :soutenance_establishment, :id_establishment, :discipline, :status, :date_first_registration, :date_soutenance, :language, :id_these, :online, :date_publication, :date_update)";
        $pdo = new PDO('mysql:host=localhost;dbname=projet_prog_web', 'root', 'root');
        $stmt= $pdo->prepare($sql);
        $stmt->execute($data);
    }
}