<?php
if (isset($_POST['proses'])) {   // Process only when the submit button is pressed (form uses POST method)
    $kataKunci = $_POST['kata'];  // Store input into variable

    $operasi = $_POST['operasi'];
    $tipe = $_POST['tipe'];

    $namaSementara = $_FILES['file']['tmp_name'];  // Get the temporary uploaded file location
    $namaAsli = $_FILES['file']['name'];           // Get the original file name

    if (!file_exists('uploads')) {  // If "uploads" folder doesn't exist
        mkdir('uploads'); // Create the "uploads" folder
    }   

$isi = file($namaSementara);  // Read file content line by line
$hasil = [];             // Array to store modified lines

foreach ($isi as $baris) {   // Loop through each line
    if (strpos($baris, $kataKunci) !== false) {       // Check if the keyword exists in the line
        if ($operasi == "show") {                     // If operation is "show"
            echo $baris;
        } elseif ($operasi == "redact") {             // If operation is "redact"
            $baris = str_replace($kataKunci, "***", $baris);   // Replace keyword with "***"
            echo $baris;
        }
    }
    $hasil[] = $baris; // Save the (possibly modified) line to result
}

if ($tipe == "O") {          // If output type is "O" (overwrite original file)
    file_put_contents($namaAsli, implode('', $hasil));       // Save changes to original file
} elseif ($tipe == "N") {                       // If output type is "N" (new file)
    $baru = str_replace(".html", "-new.html", $namaAsli);    // Create new file name
    file_put_contents($baru, implode('', $hasil));      // Save changes to new file
    }
}
?>