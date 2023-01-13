<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>pay - login</title>
</head>

<body>
    <nav class="navbar navbar-light bg-primary fixed-top">
        <a class="navbar-brand text-light" href="home.php"><Strong class="h3">pay</Strong></a>
    </nav>

    <div class="container" style="margin-top:60px;">

        <div class="row">
            <h1 class="ml-4">Sign In</h1>
            <div class="col-md">
                <form id="formLogin">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" autocomplete="off">
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="signup.php"><Strong>Not a member Sign up ?</a>
                        <button type="submit" class="btn btn-primary">login</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        localStorage.clear();

    });

    $("#formLogin").submit(function(event) {
        event.preventDefault();
        const data = {
            "username": $("#username").val(),
            "password": $("#password").val(),
            "action": "login"
        }
        if ($("#username").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'ลืมกรอกข้อมูล',
                text: 'โปรดกรอกให้ครบ !'
            })
        } else if ($("#password").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'ลืมกรอกข้อมูล',
                text: 'โปรดกรอกให้ครบ !'
            })
        } else {
            axios.post(location.origin + "/controller.php",
                JSON.stringify(data)
            ).then(function(res) {
                if (res.data.status == 1) {
                    const member = res.data.member;
                    localStorage.setItem("MemberData", JSON.stringify(member));
                    localStorage.setItem("status", 1);
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'กำลังเข้าสู่ระบบ',
                        text: 'จะพาไปยังหน้า หน้าแรก',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    setTimeout(function() {
                        location.href = location.origin + "/payhome.php";
                    }, 2300);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: 'ไม่สามารถเข้าสู่ระบบได้',
                        confirmButtonText: 'ลองใหม่',
                    }).then((result) => {

                    })
                }
            });
        }
    });
</script>

</html>