<?php

// https://apisql.github.io/php/
// curl https://php.apisql.com/api_sql.php --output api_sql.php

/**
 * @param string $uri
 * @param string $sql
 * @param $callback
 * @return array
 */
function api_sql($uri, $sql, $callback = null)
{
    //'sqlite:db.sqlite3'
    $conn = new PDO($uri);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $conn->prepare($sql);
    $query->execute();

    if (is_callable($callback)) {
        while ($item = $query->fetch()) {
            $callback($item);
        }
    }

    return $query->fetchAll();
}

/**
 * Class ApiSql
 */
class ApiSql
{

    /**
     * @var PDO
     */
    public $conn;

    /**
     * @var string
     */
    public $sql = '';

    /**
     * LetSql constructor.
     * @param PDO $conn
     * @param string $sql
     */
    public function __construct(PDO $conn, string $sql)
    {
        $this->conn = $conn;
        $this->sql = $sql;
    }

    /**
     * @param PDO $conn
     * @param string $sql
     * @return false|PDOStatement
     */
    static function db(PDO $conn, string $sql)
    {
        return $conn->query($sql);
    }

    function fetch()
    {
        $query = $this->conn->prepare($this->sql);
        $query->execute();
        return $query->fetch();
    }


    static function sqlFetch(PDO $conn, string $sql)
    {
        $query = $conn->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    function first()
    {
        return $this->json[0];
    }


    public function each($callback)
    {
        $query = $this->conn->prepare($this->sql);
        $query->execute();
        while ($item = $query->fetch()) {
            $callback($item);
        }
//        return $this->json[0];
    }
}