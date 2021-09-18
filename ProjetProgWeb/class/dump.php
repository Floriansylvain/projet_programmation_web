<?php

class dump {
    private these $these;

    /**
     * @param these $these
     */
    public function __construct(these $these) {
        $this->these = $these;
    }

    public function sendThese() {
        $data = [
            'author' => $this->these->getAuthor(),
            'id_author' => $this->these->getIdAuthor(),
            'these_director' => $this->these->getTheseDirector(),
            'title' => $this->these->getTitle(),
            'these_director_name_lastname' => $this->these->getTheseDirectorNameLastname(),
            'id_director' => $this->these->getIdDirector(),
            'soutenance_establishment' => $this->these->getSoutenanceEstablishment(),
            'id_establishment' => $this->these->getIdEstablishment(),
            'discipline' => $this->these->getDiscipline(),
            'status' => $this->these->getStatus(),
            'date_first_registration' => $this->these->getDateFirstRegistration(),
            'date_soutenance' => $this->these->getDateSoutenance(),
            'language' => $this->these->getLanguage(),
            'id_these' => $this->these->getIdThese(),
            'online' => $this->these->isOnline() ? "yes" : "no",
            'date_publication' => $this->these->getDatePublication(),
            'date_update' => $this->these->getDateUpdate()
        ];
        $sql = "INSERT INTO theses (author, id_author, these_director, title, these_director_name_lastname, id_director, soutenance_establishment, id_establishment, discipline, status, date_first_registration, date_soutenance, language, id_these, online, date_publication, date_update) VALUES (:author, :id_author, :these_director, :title, :these_director_name_lastname, :id_director, :soutenance_establishment, :id_establishment, :discipline, :status, :date_first_registration, :date_soutenance, :language, :id_these, :online, :date_publication, :date_update)";
        $pdo = new PDO('mysql:host=localhost;dbname=projet_prog_web', 'root', 'root');
        $stmt= $pdo->prepare($sql);
        $stmt->execute($data);
    }

}