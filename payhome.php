<?php include "connect.php";?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://i.ibb.co/Xb4WCJr/table.png" type="image/gif" sizes="18x18" rounded="true">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.2/b-2.0.0/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.2/b-2.0.0/datatables.min.js"></script>

    <title>pay - home</title>
</head>

<body>
    <nav class="navbar navbar-light bg-primary fixed-top">
        <a class="navbar-brand text-light" href="home.php"><Strong class="h3">pay</Strong></a>
        <form class="form-inline my-2 my-lg-0">
            <button class="btn btn-outline-light my-2 my-sm-0" type="button" onclick="logout()"><i class="fas fa-sign-out-alt"></i></button>
        </form>
    </nav>

    <div class="container" style="margin-top:100px;">

        <div class="row">
            <div class="col-md">
                <h3>ตารางผ่อน</h3>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPay"><i class="fas fa-plus"></i></button>
            </div>

        </div>

        <br>

        <div class="row">
            <div class="col-md">
                <table class="table" id="bodytable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ชื่อสินค้า</th>
                            <th scope="col">คงเหลือ</th>
                            <th scope="col">*</th>
                            <th scope="col">*</th>
                        </tr>
                    </thead>
                    <tbody >
                        <?php
$sql   = "SELECT * FROM tb_payproduct";
$query = mysqli_query($con, $sql);
$i     = 1;
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    ?>
                            <tr>
                                <th scope="row"><?php echo $i; ?></th>
                                <td><?php echo $row["product_name"]; ?></td>
                                <td><?php echo $row["total_price"]; ?></td>
                                <td><button type="button" class="btn btn-warning" onclick="views(<?php echo $row['p_id']; ?>)"><i class="far fa-eye"></i></button></td>
                                <td><button type="button" class="btn btn-primary" onclick="pay(<?php echo $row['p_id']; ?>,'<?php echo $row['product_name']; ?>',<?php echo $row['total_price']; ?>)"><Strong>จ่าย</Strong></button></td>
                            </tr>
                        <?php
$i++;
}
?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Modal Add-->
    <div class="modal fade" id="addPay" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มสินค้าที่ผ่อน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAdd">
                        <div class="form-group">
                            <label for="exampleInputEmail1">ชื่อสินค้า</label>
                            <input type="text" class="form-control" id="p_name" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">ราคา</label>
                            <input type="text" class="form-control" id="p_price" autocomplete="off">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success" name="addsubmit">บันทึก</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Views-->
    <div class="modal fade" id="viewsPay" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title_view"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ยอดผ่อน</th>
                                <th scope="col">คงเหลือ</th>
                                <th scope="col">*</th>
                            </tr>
                        </thead>
                        <tbody id="payTbody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pay-->
    <div class="modal fade" id="Paymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title_pay"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formPay">
                        <div class="form-group">
                            <label for="remain">ยอดคงเหลือ</label>
                            <input type="text" class="form-control" id="remain" disabled>
                            <input type="hidden" class="form-control" id="p_idhidden">
                        </div>
                        <div class="form-group">
                            <label for="price">ราคา</label>
                            <input type="text" class="form-control" id="price" placeholder="ใส่ราคาที่ต้องการผ่อน" autocomplete="off">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">บันทึกการจ่าย</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
<script>
    $(document).ready(function() {
        const length = localStorage.length;
        if (length == 0) {
            location.href = location.origin + "/pay/login.php";
        } // checklogin
    });

    function logout() {
        localStorage.clear();
        localStorage.setItem("status", 0);
        location.href = location.origin + "/pay/login.php";
    }

    $("#formAdd").submit(function(event) {
        event.preventDefault();
        const m_id = JSON.parse(localStorage.getItem("MemberData")).m_id;
        const data = {
            "m_id": m_id,
            "p_name": $("#p_name").val(),
            "p_price": $("#p_price").val(),
            "action": "add"
        }
        if ($("#p_name").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'ลืมกรอกข้อมูล',
                text: 'โปรดกรอกให้ครบ !'
            })
        } else if ($("#p_price").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'ลืมกรอกข้อมูล',
                text: 'โปรดกรอกให้ครบ !'
            })
        } else {
            axios.post(location.origin + "/pay/controller.php",
                JSON.stringify(data)
            ).then(function(res) {
                if (res.data == 1) {
                    Swal.fire({
                        icon: "success",
                        title: 'บันทึกสำเร็จ',
                        confirmButtonText: 'ok',
                    }).then((result) => {
                        if (result.value) {
                            location.reload();
                        }
                    })
                } else {
                    Swal.fire({
                        icon: "error",
                        title: 'เกิดข้อผิดพลาด',
                        confirmButtonText: 'ลองใหม่',
                    }).then((result) => {

                    })
                }

            });
        }

    });

    function views(p_id) {
        const m_id = JSON.parse(localStorage.getItem("MemberData")).m_id;
        const data = {
            "p_id": p_id,
            "m_id": m_id,
            "action": "views"
        }
        axios.post(location.origin + "/pay/controller.php",
            JSON.stringify(data)
        ).then(function(res) {
            const jsonObj = res.data;
            if (jsonObj.data.length > 0) {
                $("#payTbody").empty();
                $("#title_view").empty();
                jsonObj.data.forEach((val, i) => {
                    $("#payTbody").append(
                        "<tr>" +
                        "    <th scope='row'>" + (i + 1) + "</th>" +
                        "    <td>" + val.pd_price + "</td>" +
                        "    <td>" + val.remain + "</td>" +
                        "    <td><button type='submit' class='btn btn-danger' name='addsubmit' onclick='deletePay(" + val.pd_id + ")'><i class='far fa-trash-alt'></i></button></td>" +
                        "</tr>"
                    );
                })
                $("#title_view").append(
                    "รายละเอียดของ " + jsonObj.data[0].product_name
                )
                $('#viewsPay').modal('show');

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่มีรายการผ่อน',
                    text: 'โปรดกรอกให้ครบ !'
                })
            }

        });

    }


    function deletePay(pd_id) {
        const data = {
            "pd_id": pd_id,
            "action": "deletepay"
        }
        Swal.fire({
            title: 'ต้องการลบรายการ ?',
            text: "รายการผ่อนจะถูกลบออกไป ถาวร",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ลบออก',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(location.origin + "/pay/controller.php",
                    JSON.stringify(data)
                ).then(function(res) {
                    $('#viewsPay').modal('hide');
                });
            }
        })

    }


    function pay(p_id, p_name, remain) {
        $("#title_pay").empty();
        $("#remain").val(remain);
        $("#title_pay").append("จ่ายค่า " + p_name);
        $("#p_idhidden").val(p_id);
        $('#Paymodal').modal('show');

    }


    $("#formPay").submit(function(event) {
        event.preventDefault();

        if ($("#price").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'ลืมกรอกราคา',
                text: 'โปรดกรอกข้อมูล !'
            })
        } else {
            const remain = parseFloat($("#remain").val());
            const price = parseFloat($("#price").val());
            const p_id = $("#p_idhidden").val();
            const total = (remain - price);
            const data = {
                "p_id": p_id,
                "price": price,
                "total": total,
                "action": "pay"
            }
            axios.post(location.origin + "/pay/controller.php",
                JSON.stringify(data)
            ).then(function(res) {
                if (res.data.status == 1) {
                    Swal.fire({
                        icon: "success",
                        title: 'บันทึกสำเร็จ',
                        confirmButtonText: 'ok',
                    }).then((result) => {
                        $('#Paymodal').modal('hide');
                        $( "#bodytable" ).load(window.location.href + " #bodytable" );
                    })
                } else {
                    Swal.fire({
                        icon: "error",
                        title: 'เกิดข้อผิดพลาด',
                        confirmButtonText: 'ลองใหม่',
                    }).then((result) => {

                    })
                }
            });
        }

    });
</script>

</html>