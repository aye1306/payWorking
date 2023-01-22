<?php include "connect.php"; ?>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.2/b-2.0.0/datatables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.2/b-2.0.0/datatables.min.js"></script>

    <title>pay</title>

    <style>
        .loader-content {
            background-color: #1E4AC5;
            height: 100vh;
        }

        .img-logo img {
            width: 100vw;
            height: 70vh;
            object-fit: contain;
        }

        .ring {
            position: absolute;
            top: 65%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150px;
            height: 150px;
            background: transparent;
            border: 3px solid #fff;
            border-radius: 50%;
            text-align: center;
            line-height: 150px;
            font-family: sans-serif;
            font-size: 20px;
            color: #fff;
            letter-spacing: 4px;
            text-transform: uppercase;
            text-shadow: 0 0 10px #1E4AC5;
            box-shadow: 0 0 20px rgba(0, 0, 0, .5);
        }

        .ring:before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            width: 100%;
            height: 100%;
            border: 3px solid transparent;
            border-top: 3px solid #1D92FF;
            border-right: 3px solid #1D92FF;
            border-radius: 50%;
            animation: animateC 2s linear infinite;
        }

        span {
            display: block;
            position: absolute;
            top: calc(50% - 2px);
            left: 50%;
            width: 50%;
            height: 4px;
            background: transparent;
            transform-origin: left;
            animation: animate 2s linear infinite;
        }

        span:before {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #0066FF;
            top: -6px;
            right: -8px;
            box-shadow: 0 0 20px #0066FF;
        }

        @keyframes animateC {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes animate {
            0% {
                transform: rotate(45deg);
            }

            100% {
                transform: rotate(405deg);
            }
        }
    </style>
</head>

<body>
    <div id="content" style="display: none;">
        <nav class="navbar navbar-light bg-primary fixed-top">
            <a class="navbar-brand text-light" href="payhome.php"><Strong class="h3">Pay</Strong> <b id="member_name">คุณ na</b></a>
            <form class="form-inline my-2 my-lg-0">
                <button class="btn btn-outline-light my-2 my-sm-0" type="button" onclick="logout()"><i class="fas fa-sign-out-alt"></i></button>
            </form>
        </nav>

        <div class="container" style="margin-top:100px;">
            <div class="alert alert-primary d-flex justify-content-center" role="alert">
                <strong>อัปเดทใหม่ แก้บัคข้อมูลผู้ใช้งาน</strong>
            </div>
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
                                <th scope="col">รายการ</th>
                                <th scope="col">คงเหลือ</th>
                                <th scope="col">*</th>
                                <th scope="col">*</th>
                            </tr>
                        </thead>
                        <tbody id="body-data">

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-center">รวม</td>
                                <td colspan="5" class="text-start" id="sumprice"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="loader-content" id="loading" style="display: block;">
        <div class="img-logo">
            <img src="./img/logo.jpg">
            <div class="ring">Loading
                <span></span>
            </div>
        </div>
    </div>

    <!-- Modal Add-->
    <div class="modal fade" id="addPay" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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
                            <input type="number" class="form-control" id="p_price" autocomplete="off">
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
                    <div class="row mb-4">
                        <div class="col-12">
                            <input type="hidden" id="p_id">
                            <button class="btn btn-danger" onclick="deleteList()">ลบรายการนี้</button>
                        </div>
                    </div>
                    <div class="table-responsive">
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
                                <tr>
                                    <td colspan="4">ไม่มีรายการ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                            <input type="hidden" class="form-control" id="max_price">
                        </div>
                        <div class="form-group">
                            <label for="price">ราคา</label>
                            <input type="number" class="form-control" id="price" placeholder="ใส่ราคาที่ต้องการผ่อน" autocomplete="off">
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
        setTimeout(() => {
            console.log("wow")
            document.getElementById("loading").style.display = "none";
            document.getElementById("content").style.display = "block";
        }, 2000);

        const length = localStorage.length;
        if (length == 0) {
            location.href = location.origin + "/pay/login.php";
        } // checklogin
        getDataPay();
    });


    function getDataPay() {
        const memberData = JSON.parse(localStorage.MemberData);
        document.getElementById("member_name").innerText = "( คุณ " + memberData.m_name + " )";
        const m_id = memberData.m_id;
        const data = {
            "m_id": m_id,
            "action": "List_pay"
        }
        axios.post(location.origin + "/pay/controller.php",
            JSON.stringify(data)
        ).then(function(res) {

            const dataPay = res.data.data;
            const bodyData = document.getElementById("body-data");
            bodyData.innerHTML = ""
            let sumPrice = 0.0;
            if (dataPay.length == 0) {
                bodyData.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center">คุณไม่มีรายการ</td>
                </tr>
                `

                return;
            }
            dataPay.forEach((ele, i) => {
                sumPrice = sumPrice + parseFloat(ele.total_price)
                bodyData.innerHTML += `
                <tr>
                    <th scope="row">${i+1}</th>
                    <td>${ele.product_name}</td>
                    <td>${ele.total_price}</td>
                    <td>
                        <button type="button" class="btn btn-warning" onclick="views(${ele.p_id})"><i class="far fa-eye"></i></button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" onclick="pay(${ele.p_id},'${ele.product_name}',${ele.total_price})"><Strong>จ่าย</Strong></button>
                    </td>
                </tr>`
            })

            document.getElementById("sumprice").innerText = sumPrice + " บาท"
        });
    }

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
                document.getElementById("p_id").value = p_id;

            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'ไม่มีรายการผ่อน',
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

    function deleteList() {
        const p_id = document.getElementById("p_id").value;
        const data = {
            "p_id": p_id,
            "action": "deleteList"
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
                    if (res.data == 1) {
                        Swal.fire({
                            icon: "success",
                            title: 'ลบสำเร็จ',
                            confirmButtonText: 'ok',
                        }).then((result) => {
                            location.reload();
                        })
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: 'เกิดข้อผิดพลาด',
                            confirmButtonText: 'ลองใหม่',
                        })
                    }

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
        } else if ($("#price").val() <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'ราคาไม่ถูกต้อง',
                text: 'โปรดกรอกข้อมูล !'
            })
        } else if ($("#price").val() > $("#remain").val()) {
            Swal.fire({
                icon: 'error',
                title: 'จำนวนเกินกว่ายอดคงเหลือ',
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
                        getDataPay()
                    })
                } else {
                    Swal.fire({
                        icon: "error",
                        title: 'เกิดข้อผิดพลาด',
                        confirmButtonText: 'ลองใหม่',
                    })
                }
            });
        }

    });
</script>

</html>