<?php
$host    = "localhost";
$user    = "root";
$pass    = "";
$db      = "praktikum_9";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak berhasil terkoneksi ke databse.");
}

$name      = "";
$email     = "";
$address   = "";
$gender    = "";
$position  = "";
$status    = "";
$berhasil  = "";
$gagal     = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id   = $_GET['id'];
    $sql1 = "delete from karyawan where id = '$id'";
    $q1   = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $berhasil = "Berhasil menghapus data.";
    } else {
        $gagal = "Tidak berhasil menghapus data.";
    }
}

if ($op == 'edit') {
    $id   = $_GET['id'];
    $sql1 = "select * from karyawan where id = '$id'";
    $q1   = mysqli_query($koneksi, $sql1);
    $r1   = mysqli_fetch_array($q1);
    $name = $r1['name'];
    $email = $r1['email'];
    $address = $r1['address'];
    $gender = $r1['gender'];
    $position = $r1['position'];
    $status = $r1['status'];

    if ($name == '') {
        $gagal = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { // create
    $name      = $_POST['name'];
    $email     = $_POST['email'];
    $address   = $_POST['address'];
    $gender    = $_POST['gender'];
    $position  = $_POST['position'];
    $status    = $_POST['status'];

    if ($name && $email && $address && $gender && $position && $status) {
        if ($op == 'edit') { // update
            $sql1    = "update karyawan set name = '$name', email = '$email', address = '$address', gender = '$gender', position = '$position', status = '$status' where id = '$id'";
            $q1      = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $berhasil = "Data berhasil terupdate";
            } else {
                $gagal = "Data tidak berhasil terupdate";
            }
        } else { // insert
            $sql1 = "insert into karyawan(name,email,address,gender,position,status) values ('$name','$email','$address', '$gender','$position','$status')";
            $q1   = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $berhasil   = "Berhasil menginput data.";
            } else {
                $gagal      = "Gagal menginput data.";
            }
        }
    } else {
        $gagal = "Silahkan masukkan semua data.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 1000px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- Input Data-->
        <div class="card">
            <h5 class="card-header">Create / Edit Data</h5>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <?php
                        if ($gagal) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $gagal ?>
                            </div>
                        <?php
                            header("refresh:5;url=index.php"); // 5 disini adalah detik
                        }
                        ?>
                        <?php
                        if ($berhasil) {
                        ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $berhasil ?>
                            </div>
                        <?php
                            header("refresh:5;url=index.php");
                        }
                        ?>
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $email ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $address ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                        <div class="col-sm-10">
                            <select name="gender" class="form-control" id="gender">
                                <option value=""> -- Gender --</option>
                                <option value="Female" <?php if ($gender == "Female") echo "selected" ?>>Female</option>
                                <option value="Male" <?php if ($gender == "Male") echo "selected" ?>>Male</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="position" class="col-sm-2 col-form-label" id="position">Position</label>
                        <div class="col-sm-10">
                            <select name="position" class="form-control" id="position">
                                <option value=""> -- Position --</option>
                                <option value="Boss" <?php if ($gender == "Boss") echo "selected" ?>>Boss</option>
                                <option value="Manager" <?php if ($gender == "Manager") echo "selected" ?>>Manager</option>
                                <option value="Staff" <?php if ($gender == "Staff") echo "selected" ?>>Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="status" class="col-sm-2 col-form-label" id="status">Status</label>
                        <div class="col-sm-10">
                            <select name="status" class="form-control" id="status">
                                <option value=""> -- Status --</option>
                                <option value="Parttime" <?php if ($gender == "Parttime") echo "selected" ?>>Parttime</option>
                                <option value="Fulltime" <?php if ($gender == "Fulltime") echo "selected" ?>>Fulltime</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="+ Add Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <!-- Output Data-->
        <div class="card">
            <h5 class="card-header text-white bg-secondary">Data Karyawan</h5>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Position</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>

                    <tbody>
                        <?php
                        $sql2 = "select * from karyawan order by id desc";
                        $q2   = mysqli_query($koneksi, $sql2);
                        $i    = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id       = $r2['id'];
                            $name     = $r2['name'];
                            $email    = $r2['email'];
                            $address  = $r2['address'];
                            $gender   = $r2['gender'];
                            $position = $r2['position'];
                            $status   = $r2['status'];

                        ?>

                            <tr>
                                <th scope="row"><?php echo $i++ ?></th>
                                <td scope="row"><?php echo $name ?></td>
                                <td scope="row"><?php echo $email ?></td>
                                <td scope="row"><?php echo $address ?></td>
                                <td scope="row"><?php echo $gender ?></td>
                                <td scope="row"><?php echo $position ?></td>
                                <td scope="row"><?php echo $status ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Apakah anda yakin untuk menghapus data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                        <?php

                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</body>

</html>