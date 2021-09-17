<?php

class dump {
    private PDO $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }


    public function sendThese() {
        $sql = 'SELECT * FROM theses';
        $req = $pdo->query($sql);
        while($row = $req->fetch()) {
            echo "<p>" . $row['author'] . " | " . $row['title'] . "</p>";
        }
        $req->closeCursor();
    }

}