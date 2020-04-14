<?php


class DatabaseManager
{
    private $con;

    function __construct($con_settings)
    {
        $this->con = $this->connectDB($con_settings);
    }

    public function connectDB($con_settings)
    {
        $con = mysqli_connect($con_settings[0], $con_settings[1], $con_settings[2], $con_settings[3]);
        return $con;
    }
    public function select($statement){
        return $this->con->query($statement);
    }
    public function query($query, $param_type, $param_value_array)
    {
        $sql = $this->con->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }

        if (!empty($resultset)) {
            return $resultset;
        }
    }
    public function bindQueryParams($sql, $param_type, $param_value_array)
    {
        $param_value_reference[] = &$param_type;
        for ($i = 0; $i < count($param_value_array); $i++) {
            $param_value_reference[] = &$param_value_array[$i];
        }
        call_user_func_array(array(
            $sql,
            'bind_param'
        ), $param_value_reference);
    }

    public function insert($query, $param_type, $param_value_array)
    {
        $sql = $this->con->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
    }
}
