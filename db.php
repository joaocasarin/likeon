<?php
    class db
    {
        private $host = 'localhost';
        private $user = 'root';
        private $password = '';
        private $db = 'likeon';

        public function mysqlConnect()
        {
            $con = mysqli_connect($this->host, $this->user, $this->password, $this->db);
            mysqli_set_charset($con, 'utf8');

            if(mysqli_connect_errno())
            echo 'Erro ao se conectar ao banco de dados '.mysqli_connect_error();

            return $con;
        }
    }
?>