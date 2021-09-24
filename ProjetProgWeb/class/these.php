<?php

use JetBrains\PhpStorm\Pure;

class these {
    private string $author;
    private string $id_author;
    private string $title;
    private string $these_director;
    private string $these_director_name_lastname;
    private string $id_director;
    private string $soutenance_establishment;
    private string $id_establishment;
    private string $discipline;
    private string $status;
    private string $date_first_registration;
    private string $date_soutenance;
    private string $language;
    private string $id_these;
    private bool $online;
    private string $date_publication;
    private string $date_update;

    #[Pure] public static function emptyThese(): these
    {
        return new self();
    }

    public static function fullThese(string $author, string $id_author, string $title, string $these_director, string $these_director_name_lastname, string $id_director, string $soutenance_establishment, string $id_establishment, string $discipline, string $status, string $date_first_registration, string $date_soutenance, string $language, string $id_these, bool $online, string $date_publication, string $date_update) {
        $these = these::emptyThese();
        $these->setAuthor($author);
        $these->setIdAuthor($id_author);
        $these->setTitle($title);
        $these->setTheseDirector($these_director);
        $these->setTheseDirectorNameLastname($these_director_name_lastname);
        $these->setIdDirector($id_director);
        $these->setSoutenanceEstablishment($soutenance_establishment);
        $these->setIdEstablishment($id_establishment);
        $these->setDiscipline($discipline);
        $these->setStatus($status);
        $these->setDateFirstRegistration($date_first_registration);
        $these->setDateSoutenance($date_soutenance);
        $these->setLanguage($language);
        $these->setIdThese($id_these);
        $these->setOnline($online);
        $these->setDatePublication($date_publication);
        $these->setDateUpdate($date_update);
        return $these;
    }

    public function insertField($field, $index) {
        switch ($index) {
            case 0: $this->setAuthor($field); break;
            case 1: $this->setIdAuthor($field); break;
            case 2: $this->setTitle($field); break;
            case 3: $this->setTheseDirector($field); break;
            case 4: $this->setTheseDirectorNameLastname($field); break;
            case 5: $this->setIdDirector($field); break;
            case 6: $this->setSoutenanceEstablishment($field); break;
            case 7: $this->setIdEstablishment($field); break;
            case 8: $this->setDiscipline($field); break;
            case 9: $this->setStatus($field); break;
            case 10: $this->setDateFirstRegistration(dump::convertDate($field)); break;
            case 11: $this->setDateSoutenance(dump::convertDate($field)); break;
            case 12: $this->setLanguage($field); break;
            case 13: $this->setIdThese($field); break;
            case 14: $this->setOnline($field); break;
            case 15: $this->setDatePublication(dump::convertDate($field)); break;
            case 16: $this->setDateUpdate(dump::convertDate($field)); break;
        }
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getIdAuthor(): string
    {
        return $this->id_author;
    }

    /**
     * @param string $id_author
     */
    public function setIdAuthor(string $id_author): void
    {
        $this->id_author = $id_author;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTheseDirector(): string
    {
        return $this->these_director;
    }

    /**
     * @param string $these_director
     */
    public function setTheseDirector(string $these_director): void
    {
        $this->these_director = $these_director;
    }

    /**
     * @return string
     */
    public function getTheseDirectorNameLastname(): string
    {
        return $this->these_director_name_lastname;
    }

    /**
     * @param string $these_director_name_lastname
     */
    public function setTheseDirectorNameLastname(string $these_director_name_lastname): void
    {
        $this->these_director_name_lastname = $these_director_name_lastname;
    }

    /**
     * @return string
     */
    public function getIdDirector(): string
    {
        return $this->id_director;
    }

    /**
     * @param string $id_director
     */
    public function setIdDirector(string $id_director): void
    {
        $this->id_director = $id_director;
    }

    /**
     * @return string
     */
    public function getSoutenanceEstablishment(): string
    {
        return $this->soutenance_establishment;
    }

    /**
     * @param string $soutenance_establishment
     */
    public function setSoutenanceEstablishment(string $soutenance_establishment): void
    {
        $this->soutenance_establishment = $soutenance_establishment;
    }

    /**
     * @return string
     */
    public function getIdEstablishment(): string
    {
        return $this->id_establishment;
    }

    /**
     * @param string $id_establishment
     */
    public function setIdEstablishment(string $id_establishment): void
    {
        $this->id_establishment = $id_establishment;
    }

    /**
     * @return string
     */
    public function getDiscipline(): string
    {
        return $this->discipline;
    }

    /**
     * @param string $discipline
     */
    public function setDiscipline(string $discipline): void
    {
        $this->discipline = $discipline;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getDateFirstRegistration(): string
    {
        return $this->date_first_registration;
    }

    /**
     * @param string $date_first_registration
     */
    public function setDateFirstRegistration(string $date_first_registration): void
    {
        $this->date_first_registration = $date_first_registration;
    }

    /**
     * @return string
     */
    public function getDateSoutenance(): string
    {
        return $this->date_soutenance;
    }

    /**
     * @param string $date_soutenance
     */
    public function setDateSoutenance(string $date_soutenance): void
    {
        $this->date_soutenance = $date_soutenance;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getIdThese(): string
    {
        return $this->id_these;
    }

    /**
     * @param string $id_these
     */
    public function setIdThese(string $id_these): void
    {
        $this->id_these = $id_these;
    }

    /**
     * @return bool
     */
    public function isOnline(): bool
    {
        return $this->online;
    }

    /**
     * @param bool $online
     */
    public function setOnline(bool $online): void
    {
        $this->online = $online;
    }

    /**
     * @return string
     */
    public function getDatePublication(): string
    {
        return $this->date_publication;
    }

    /**
     * @param string $date_publication
     */
    public function setDatePublication(string $date_publication): void
    {
        $this->date_publication = $date_publication;
    }

    /**
     * @return string
     */
    public function getDateUpdate(): string
    {
        return $this->date_update;
    }

    /**
     * @param string $date_update
     */
    public function setDateUpdate(string $date_update): void
    {
        $this->date_update = $date_update;
    }

}