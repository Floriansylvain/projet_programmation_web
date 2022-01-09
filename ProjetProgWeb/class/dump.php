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

    public static function getTheses(string $search, string $option, int $offset) : array {
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
                  OR soutenance_establishment LIKE :search
                LIMIT 10 OFFSET :offset;
            "),
            'author' => $pdo->prepare("SELECT * FROM theses WHERE author LIKE :search ORDER BY author LIMIT 10 OFFSET :offset;"),
            'title' => $pdo->prepare("SELECT * FROM theses WHERE title LIKE :search LIMIT 10 OFFSET :offset;"),
            'director' => $pdo->prepare("SELECT * FROM theses WHERE these_director LIKE :search LIMIT 10 OFFSET :offset;"),
            'establishment' => $pdo->prepare("SELECT * FROM theses WHERE soutenance_establishment LIKE :search LIMIT 10 OFFSET :offset;"),
            default => "",
        };

        $stmt->bindParam(':search', $search, PDO::PARAM_STR, 100);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $i = 0;
        while ($obj = $stmt->fetchObject()) {
            $theses_array[$i] = array();
            foreach ($obj as $elem) {
                // TODO Mettre le nom du champ à la place du vide
                $theses_array[$i][] = empty($elem) ? "Non définit" : $elem;
            }
            $i++;
        }

        return $theses_array;
    }

    public static function getSuggestions(string $search, string $option) : ?array {
        $array = [];

        $search = '%' . $search . '%';

        $pdo_obj = new conf();
        $pdo = $pdo_obj->getPDO();

        if ($option == 'auto') {
            return null;
        }

        $stmt = match ($option) {
            'author' => $pdo->prepare("SELECT DISTINCT author FROM theses WHERE author LIKE :search LIMIT 10;"),
            'title' => $pdo->prepare("SELECT DISTINCT title FROM theses WHERE title LIKE :search LIMIT 5;"),
            'director' => $pdo->prepare("SELECT DISTINCT these_director FROM theses WHERE these_director LIKE :search LIMIT 10;"),
            'establishment' => $pdo->prepare("SELECT DISTINCT soutenance_establishment FROM theses WHERE soutenance_establishment LIKE :search LIMIT 10;"),
            default => "",
        };
        $stmt->bindParam(':search', $search, PDO::PARAM_STR, 100);
        $stmt->execute();

        while ($obj = $stmt->fetchObject()) {
            foreach ($obj as $elem) {
                $array[] = $elem;
            }
        }

        return $array;
    }

    public static function getThesesCount(string $search, string $option) : array {
        $array = [];

        $search = '%' . $search . '%';

        $pdo_obj = new conf();
        $pdo = $pdo_obj->getPDO();

        $stmt = match ($option) {
            'auto' => $pdo->prepare("
                SELECT COUNT(*)
                FROM theses
                WHERE author LIKE :search
                  OR title LIKE :search
                  OR these_director LIKE :search
                  OR soutenance_establishment LIKE :search;
            "),
            'author' => $pdo->prepare("SELECT COUNT(author) FROM theses WHERE author LIKE :search;"),
            'title' => $pdo->prepare("SELECT COUNT(title) FROM theses WHERE title LIKE :search;"),
            'director' => $pdo->prepare("SELECT COUNT(these_director) FROM theses WHERE these_director LIKE :search;"),
            'establishment' => $pdo->prepare("SELECT COUNT(soutenance_establishment) FROM theses WHERE soutenance_establishment LIKE :search;"),
            default => "",
        };
        $stmt->bindParam(':search', $search, PDO::PARAM_STR, 100);
        $stmt->execute();

        while ($obj = $stmt->fetchObject()) {
            foreach ($obj as $elem) {
                $array[] = $elem;
            }
        }

        return $array;
    }

    public static function getThesesYears(string $search, string $option) : array {
        $years_array = [];

        $pdo_obj = new conf();
        $pdo = $pdo_obj->getPDO();

        $search = '%' . $search . '%';

        $stmt = match ($option) {
            'auto' => $pdo->prepare("
                SELECT Date, theses_online, theses_offline
                FROM (SELECT DATE_FORMAT(date_soutenance, '%Y') AS Date,
                             COUNT(DATE_FORMAT(date_soutenance, '%Y')) AS theses_online
                      FROM theses
                      WHERE `online` LIKE 'yes'
                        AND (author LIKE :search
                         OR title LIKE :search
                         OR these_director LIKE :search
                         OR soutenance_establishment LIKE :search)
                      GROUP BY Date) t_online
                NATURAL JOIN (
                       SELECT DATE_FORMAT(date_soutenance, '%Y') AS Date,
                              COUNT(DATE_FORMAT(date_soutenance, '%Y')) AS theses_offline
                      FROM theses
                      WHERE `online` LIKE 'no'
                         AND (author LIKE :search
                         OR title LIKE :search
                         OR these_director LIKE :search
                         OR soutenance_establishment LIKE :search)
                      GROUP BY Date) t_offline
                ORDER BY `t_online`.`Date`;
            "),
            'author' => $pdo->prepare("
                SELECT Date, theses_online, theses_offline
                FROM (SELECT DATE_FORMAT(date_soutenance, '%Y') AS Date,
                             COUNT(DATE_FORMAT(date_soutenance, '%Y')) AS theses_online
                      FROM theses WHERE `online` LIKE 'yes' AND author LIKE :search GROUP BY Date) t_online
                NATURAL JOIN (SELECT DATE_FORMAT(date_soutenance, '%Y') AS Date,
                                              COUNT(DATE_FORMAT(date_soutenance, '%Y')) AS theses_offline
                              FROM theses WHERE `online` LIKE 'no' AND author LIKE :search GROUP BY Date) t_offline
                ORDER BY `t_online`.`Date`;"),
            'title' => $pdo->prepare("
                SELECT Date, theses_online, theses_offline
                FROM (SELECT DATE_FORMAT(date_soutenance, '%Y') AS Date,
                             COUNT(DATE_FORMAT(date_soutenance, '%Y')) AS theses_online
                      FROM theses WHERE `online` LIKE 'yes' AND title LIKE :search GROUP BY Date) t_online
                NATURAL JOIN (SELECT DATE_FORMAT(date_soutenance, '%Y') AS Date,
                                              COUNT(DATE_FORMAT(date_soutenance, '%Y')) AS theses_offline
                              FROM theses WHERE `online` LIKE 'no' AND title LIKE :search GROUP BY Date) t_offline
                ORDER BY `t_online`.`Date`;"),
            'director' => $pdo->prepare("
                SELECT Date, theses_online, theses_offline
                FROM (SELECT DATE_FORMAT(date_soutenance, '%Y') AS Date,
                             COUNT(DATE_FORMAT(date_soutenance, '%Y')) AS theses_online
                      FROM theses WHERE `online` LIKE 'yes' AND these_director LIKE :search GROUP BY Date) t_online
                NATURAL JOIN (SELECT DATE_FORMAT(date_soutenance, '%Y') AS Date,
                                              COUNT(DATE_FORMAT(date_soutenance, '%Y')) AS theses_offline
                              FROM theses WHERE `online` LIKE 'no' AND these_director LIKE :search GROUP BY Date) t_offline
                ORDER BY `t_online`.`Date`;"),
            'establishment' => $pdo->prepare("
                SELECT Date, theses_online, theses_offline
                FROM (SELECT DATE_FORMAT(date_soutenance, '%Y') AS Date,
                             COUNT(DATE_FORMAT(date_soutenance, '%Y')) AS theses_online
                      FROM theses WHERE `online` LIKE 'yes' AND soutenance_establishment LIKE :search GROUP BY Date) t_online
                NATURAL JOIN (SELECT DATE_FORMAT(date_soutenance, '%Y') AS Date,
                                              COUNT(DATE_FORMAT(date_soutenance, '%Y')) AS theses_offline
                              FROM theses WHERE `online` LIKE 'no' AND soutenance_establishment LIKE :search GROUP BY Date) t_offline
                ORDER BY `t_online`.`Date`;"),
            default => "",
        };

        $stmt->bindParam(':search', $search, PDO::PARAM_STR, 100);
        $stmt->execute();

        $i = 0;
        while ($obj = $stmt->fetchObject()) {
            $years_array[$i] = array(
                $obj->Date => array(
                    "online" => $obj->theses_online,
                    "offline" => $obj->theses_offline
                )
            );
            $i++;
        }

        return $years_array;
    }

    public static function getThesesDisciplines(string $search, string $option) : array {
        $disciplines_array = [];

        $pdo_obj = new conf();
        $pdo = $pdo_obj->getPDO();

        $search = '%' . $search . '%';

        $stmt = match ($option) {
            'auto' => $pdo->prepare("
                SELECT discipline AS Discipline,
                        COUNT(discipline) AS Number
                FROM theses
                WHERE author LIKE :search
                  OR title LIKE :search
                  OR these_director LIKE :search
                  OR soutenance_establishment LIKE :search
                GROUP BY Discipline
                ORDER BY `Number` DESC
                LIMIT 10;
            "),
            'author' => $pdo->prepare("SELECT discipline AS Discipline, COUNT(discipline) AS Number FROM theses WHERE author LIKE :search GROUP BY Discipline ORDER BY `Number` DESC LIMIT 10;"),
            'title' => $pdo->prepare("SELECT discipline AS Discipline, COUNT(discipline) AS Number FROM theses WHERE title LIKE :search GROUP BY Discipline ORDER BY `Number` DESC LIMIT 10;"),
            'director' => $pdo->prepare("SELECT discipline AS Discipline, COUNT(discipline) AS Number FROM theses WHERE these_director LIKE :search GROUP BY Discipline ORDER BY `Number` DESC LIMIT 10;"),
            'establishment' => $pdo->prepare("SELECT discipline AS Discipline, COUNT(discipline) AS Number FROM theses WHERE soutenance_establishment LIKE :search GROUP BY Discipline ORDER BY `Number` DESC LIMIT 10;"),
            default => "",
        };

        $stmt->bindParam(':search', $search, PDO::PARAM_STR, 100);
        $stmt->execute();

        $i = 0;
        while ($obj = $stmt->fetchObject()) {
            $disciplines_array[$i] = array(
                $obj->Discipline => $obj->Number
            );
            $i++;
        }

        return $disciplines_array;
    }

    public static function getThesesEstablishments(string $search, string $option) : array {
        $establishments_array = [];

        $pdo_obj = new conf();
        $pdo = $pdo_obj->getPDO();

        $search = '%' . $search . '%';

        $stmt = match ($option) {
            'auto' => $pdo->prepare("
                SELECT soutenance_establishment AS Establishment,
                        COUNT(soutenance_establishment) AS Number
                FROM theses
                WHERE author LIKE :search
                  OR title LIKE :search
                  OR these_director LIKE :search
                GROUP BY Establishment
                ORDER BY `Number` DESC
                LIMIT 10;
            "),
            'author' => $pdo->prepare("SELECT soutenance_establishment AS Establishment, COUNT(soutenance_establishment) AS Number FROM theses WHERE author LIKE :search GROUP BY Establishment ORDER BY `Number` DESC LIMIT 10;"),
            'title' => $pdo->prepare("SELECT soutenance_establishment AS Establishment, COUNT(soutenance_establishment) AS Number FROM theses WHERE title LIKE :search GROUP BY Establishment ORDER BY `Number` DESC LIMIT 10;"),
            'director' => $pdo->prepare("SELECT soutenance_establishment AS Establishment, COUNT(soutenance_establishment) AS Number FROM theses WHERE these_director LIKE :search GROUP BY Establishment ORDER BY `Number` DESC LIMIT 10;"),
            'establishment' => $pdo->prepare("SELECT soutenance_establishment AS Establishment, COUNT(soutenance_establishment) AS Number FROM theses WHERE soutenance_establishment LIKE :search GROUP BY Establishment ORDER BY `Number` DESC LIMIT 10;"),
            default => "",
        };

        $stmt->bindParam(':search', $search, PDO::PARAM_STR, 100);
        $stmt->execute();

        $i = 0;
        while ($obj = $stmt->fetchObject()) {
            $establishments_array[$i] = array(
                $obj->Establishment => $obj->Number
            );
            $i++;
        }

        return $establishments_array;
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
