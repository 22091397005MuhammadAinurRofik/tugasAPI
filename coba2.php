<?php
// Membangun koneksi ke database
$connection = mysqli_connect('localhost', 'root', '', 'tugasapi1');

// mengambil metode request
$request_method = $_SERVER["REQUEST_METHOD"];

// metode apa yang digunakan client?
switch ($request_method) {
    case 'GET':
        // Metode GET
        if (!empty($_GET["id_lagu"])) {
            $id_lagu = intval($_GET["id_lagu"]);
            get_playlist($id_lagu);
        } else {
            get_playlist();
        }
        break;

    case 'POST':
        // Metode POST
        insert_playlist();
        break;

    case 'PUT':
        // Metode PUT
        $id_lagu = intval($_GET["id_lagu"]);
        update_playlist($id_lagu);
        break;

    case 'DELETE':
        // Metode DELETE
        $id_lagu = intval($_GET["id_lagu"]);
        delete_playlist($id_lagu);
        break;

    default:
        // Jika bukan salah satu dari 4 metode di atas
        header("HTTP/1.0 405 Metode Tidak Dikenali.");
        break;
}

function get_playlist($id_lagu = 0)
{
    global $connection;

    // query mengambil semua data playlist
    $query = "SELECT * FROM playlist";

    // hanya mengambil satu playlist sesuai id_lagu
    if ($id_lagu != 0) {
        $query .= " WHERE id_lagu = " . $id_lagu . " LIMIT 1";
    }

    $response = array();
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }

    // respon untuk client dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_playlist()
{
    global $connection;
    $judul_lagu = $_POST["judul_lagu"];
    $genre_lagu = $_POST["genre_lagu"];
    $penyanyi = $_POST["penyanyi"];
    $followers = $_POST["followers"];

    $query = "INSERT INTO playlist (judul_lagu, genre_lagu, penyanyi, followers) VALUES('$judul_lagu', '$genre_lagu', '$penyanyi', '$followers')";

    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Lagu berhasil ditambahkan.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Lagu GAGAL ditambahkan.'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function update_playlist($id_lagu)
{
    global $connection;
    parse_str(file_get_contents("php://input"), $post_vars);
    $judul_lagu = $post_vars["judul_lagu"];
    $genre_lagu = $post_vars["genre_lagu"];
    $penyanyi = $post_vars["penyanyi"];
    $followers = $post_vars["followers"];

    $query = "UPDATE playlist SET judul_lagu='$judul_lagu', genre_lagu='$genre_lagu', penyanyi='$penyanyi', followers='$followers' WHERE id_lagu=" . $id_lagu;

    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Lagu berhasil diupdate.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Lagu GAGAL diupdate.'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function delete_playlist($id_lagu)
{
    global $connection;
    $query = "DELETE FROM playlist WHERE id_lagu=" . $id_lagu;

    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Lagu berhasil dihapus.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Lagu GAGAL dihapus.'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

?>
