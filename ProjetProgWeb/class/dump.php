<?php

ini_set('max_execution_time', 0);

require_once("these.php");
require_once("conf.php");

class dump {
    private these $these;

    public function __construct(these $these) {
        $this->these = $these;
    }

    public static function convertDate($old_date) : string {
        return date("Y-m-d", strtotime($old_date));
    }

    public static function getTheses(string $search, string $option) : array {
        $theses_array = [];

        $pdo_obj = new conf();
        $pdo = $pdo_obj->getPDO();

        $search = '%' . $search . '%';

        $stmt = match ($option) {
            'auto' => $pdo->prepare("
                SELECT *
                FROM theses
                WHERE author LIKE :search
                  OR title LIKE :search
                  OR these_director LIKE :search
                  OR soutenance_establishment LIKE :search;
            "),
            'author' => $pdo->prepare("SELECT * FROM theses WHERE author LIKE :search ORDER BY author;"),
            'title' => $pdo->prepare("SELECT * FROM theses WHERE title LIKE :search;"),
            'director' => $pdo->prepare("SELECT * FROM theses WHERE these_director LIKE :search;"),
            'establishment' => $pdo->prepare("SELECT * FROM theses WHERE soutenance_establishment LIKE :search;"),
            default => "",
        };

        $stmt->bindParam(':search', $search, PDO::PARAM_STR, 100);
        $stmt->execute();

        $i = 0;
        while ($obj = $stmt->fetchObject()) {
            $theses_array[$i] = array();
            foreach ($obj as $elem) {
                array_push($theses_array[$i], empty($elem) ? "Non définit" : $elem);
            }
            $i++;
        }

        return $theses_array;
    }

    public static function getSuggestions(string $search, string $option) : array {
        $array = [];

        $search = '%' . $search . '%';

        $pdo_obj = new conf();
        $pdo = $pdo_obj->getPDO();

        $stmt = $pdo->prepare("SELECT DISTINCT author FROM theses WHERE author LIKE :search LIMIT 10;");
        $stmt->bindParam(':search', $search, PDO::PARAM_STR, 100);
        $stmt->execute();

        while ($obj = $stmt->fetchObject()) {
            foreach ($obj as $elem) {
                array_push($array, $elem);
            }
        }

        return $array;
    }

    public function sendThese($pdo) {
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
            'online' => $this->these->getOnline() == "oui" ? "yes" : "no",
            'date_publication' => empty($this->these->getDatePublication()) ? NULL : $this->these->getDatePublication(),
            'date_update' => empty($this->these->getDateUpdate()) ? NULL : $this->these->getDateUpdate()
        ];
        $sql = "INSERT INTO theses (author, id_author, these_director, title, these_director_name_lastname, id_director, soutenance_establishment, id_establishment, discipline, status, date_first_registration, date_soutenance, language, id_these, online, date_publication, date_update) VALUES (:author, :id_author, :these_director, :title, :these_director_name_lastname, :id_director, :soutenance_establishment, :id_establishment, :discipline, :status, :date_first_registration, :date_soutenance, :language, :id_these, :online, :date_publication, :date_update)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
    }
}