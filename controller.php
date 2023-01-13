<?php
include "connect.php";

$obj = json_decode(file_get_contents('php://input'));
$action = $obj->action;
$result = null;
if ($action == "add") {
    $m_id =  $obj->m_id;
    $p_name = $obj->p_name;
    $p_price = $obj->p_price;

    $sql = "INSERT INTO tb_payproduct(product_name,total_price,m_id) VALUES ('$p_name',$p_price,$m_id)";
    $query =  mysqli_query($con, $sql);
    $lastP_id = mysqli_insert_id($con);

    // $sql = "INSERT INTO tb_paydetails(p_id,pd_price,remain) VALUES ('$lastP_id',0,$p_price)";
    // $query =  mysqli_query($con, $sql);

    if ($query) {
        echo  "1";
    } else {
        echo "0";
    }
} else if ($action == "views") {
    $p_id = $obj->p_id;
    $m_id = $obj->m_id;

    $sql = "SELECT pd_id,tb_paydetails.p_id,pd_price,remain,tb_paydetails.time_reg,\n" .
        "product_name,total_price,tb_payproduct.time_reg p_time_reg \n" .
        "FROM tb_paydetails \n" .
        "INNER JOIN tb_payproduct ON tb_paydetails.p_id = tb_payproduct.p_id\n" .
        "WHERE tb_paydetails.p_id = $p_id AND tb_payproduct.m_id = $m_id  ORDER BY pd_id DESC";
    $query = mysqli_query($con, $sql);

    $return_arr = array();

    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $row_array['pd_id'] = $row['pd_id'];
        $row_array['p_id'] = $row['p_id'];
        $row_array['pd_price'] = $row['pd_price'];
        $row_array['remain'] = $row['remain'];
        $row_array['time_reg'] = $row['time_reg'];
        $row_array['product_name'] = $row['product_name'];
        $row_array['total_price'] = $row['pd_price'];
        $row_array['p_time_reg'] = $row['p_time_reg'];

        array_push($return_arr, $row_array);
    }

    $result = array('status' => 1, 'data' => $return_arr);
    echo json_encode($result);
} else if ($action == "login") {
    $username = $obj->username;
    $password = $obj->password;
    $sql = sprintf(
        "SELECT * FROM tb_member WHERE m_user = '%s' AND m_pass = '%s'",
        $con->escape_string($username),
        $con->escape_string($password)
    );

    $query = mysqli_query($con, $sql);
    $rows = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $row = mysqli_num_rows($query);
    if ($row > 0) {
        $result = array("status" => 1, "member" => $rows);
        echo json_encode($result);
    } else {
        $result = array("status" => 0);
        echo json_encode($result);
    }
} else if ($action == "register") {
    $name = $obj->name;
    $username = $obj->username;
    $password = $obj->password;

    $sql = "SELECT * FROM tb_member WHERE m_user = '$username'";
    $query = mysqli_query($con, $sql);

    //$result = mysqli_fetch_array($query,MYSQLI_ASSOC);

    if (mysqli_num_rows($query) > 0) {
        $result =  array("status" => 0);
        echo json_encode($result);
    } else {
        $sql = sprintf(
            "INSERT INTO tb_member(m_name,m_user,m_pass) values ('%s','%s','%s')",
            $con->escape_string($name),
            $con->escape_string($username),
            $con->escape_string($password)
        );
        $result = mysqli_query($con, $sql);
        if ($result) {
            $result = array("status" => 1);
            echo json_encode($result);
        }
    }
} else if ($action == "deletepay") {
    $pd_id = $obj->pd_id;
    $sql = sprintf(
        "DELETE FROM tb_paydetails  WHERE pd_id = %d",
        $con->escape_string($pd_id),
    );

    $delete = mysqli_query($con, $sql);
    if ($delete) {
        echo "1";
    } else {
        echo "0";
    }
} else if ($action == "pay") {
    $p_id = $obj->p_id;
    $price = $obj->price;
    $total = $obj->total;


    $sql = "UPDATE tb_payproduct SET total_price = $total WHERE p_id = $p_id";
    $updatePay = mysqli_query($con, $sql);

    $sql = sprintf(
        "INSERT INTO tb_paydetails(p_id,pd_price,remain) values (%d,%d,%d)",
        $con->escape_string($p_id),
        $con->escape_string($price),
        $con->escape_string($total)
    );
    $result = mysqli_query($con, $sql);
    if ($result) {
        $result = array("status" => 1);
        echo json_encode($result);
    } else {
        $result = array("status" => 0);
        echo json_encode($result);
    }
} else if ($action == "List_pay") {
    $p_id = $obj->p_id;
    $m_id = $obj->m_id;

    $sql = "SELECT * FROM tb_payproduct";
    $query = mysqli_query($con, $sql);

    $return_arr = array();

    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $row_array['p_id'] = $row['p_id'];
        $row_array['product_name'] = $row['product_name'];
        $row_array['total_price'] = $row['total_price'];
        $row_array['time_reg'] = $row['time_reg'];
        $row_array['product_name'] = $row['product_name'];
        $row_array['total_price'] = $row['pd_price'];
        $row_array['p_time_reg'] = $row['p_time_reg'];

        array_push($return_arr, $row_array);
    }

    $result = array('status' => 1, 'data' => $return_arr);
    echo json_encode($result);
} else if ($action == "deleteList") {
    $p_id = $obj->p_id;
    $sql = sprintf(
        "DELETE FROM tb_paydetails  WHERE p_id = %d",
        $con->escape_string($p_id),
    );
    $delete = mysqli_query($con, $sql);

    $sql = sprintf(
        "DELETE FROM tb_payproduct  WHERE p_id = %d",
        $con->escape_string($p_id),
    );

    $delete = mysqli_query($con, $sql);
    if ($delete) {
        echo "1";
    } else {
        echo "0";
    }
}
