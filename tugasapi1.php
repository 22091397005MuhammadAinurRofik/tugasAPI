<?php
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "tugasapi1"); // Membuat koneksi PHP dengan database MySQL

// Perintah GET
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = "SELECT * FROM playlist";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while($data = mysqli_fetch_assoc($query)){
        $array_data[] = $data;
    }
    echo json_encode($array_data);

// Perintah POST
}else if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $judul_lagu = $_POST['judul_lagu'];
    $genre_lagu = $_POST['genre_lagu'];
    $penyanyi = $_POST['penyanyi'];
    $followers = $_POST['followers'];
    $sql = "INSERT INTO playlist (judul_lagu, genre_lagu, penyanyi, followers) VALUES('$judul_lagu', '$genre_lagu', '$penyanyi', '$followers')";
    $cek = mysqli_query($koneksi, $sql);

    if($cek){
        $data = [
            'status' => "berhasil"
        ];
        echo json_encode([$data]);
    }else{
        $data = [
            'status' => "gagal"
        ];
        echo json_encode([$data]);
    }

// Perintah DELETE
}else if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    $id_lagu = $_GET['id_lagu'];
    $sql = "DELETE FROM playlist WHERE id_lagu='$id_lagu'";
    $cek =  mysqli_query($koneksi, $sql);

    if($cek){
        $data = [
            'status' => "berhasil"
        ];
        echo json_encode([$data]);
    }else{
        $data = [
            'status' => "gagal"
        ];
        echo json_encode([$data]);
    }

// Perintah PUT
}else if ($_SERVER['REQUEST_METHOD'] === 'PUT'){
    $id_lagu = $_GET['id_lagu'];
    $judul_lagu = $_GET['judul_lagu'];
    $genre_lagu = $_GET['genre_lagu'];
    $penyanyi = $_GET['penyanyi'];
    $followers = $_GET['followers'];

    $sql = "UPDATE playlist SET judul_lagu='$judul_lagu', genre_lagu='$genre_lagu', penyanyi='$penyanyi', followers='$followers' WHERE id_lagu='$id_lagu'";
    $cek = mysqli_query($koneksi, $sql);

    if($cek){
        $data = [
            'status' => "berhasil"
        ];
        echo json_encode([$data]);
    }else{
        $data = [
            'status' => "gagal"
        ];
        echo json_encode([$data]);
    }
}