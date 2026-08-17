<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Uploaded Files - IPT10 Laboratory Activity</title>
    <link rel="icon" href="https://phpsandbox.io/assets/img/brand/phpsandbox.png">
    <link rel="stylesheet" href="https://assets.ubuntu.com/v1/vanilla-framework-version-4.15.0.min.css" />   
</head>

<body style="background-color: pink;">
<div class="u-fixed-width">
  <div class="p-logo-section">
    <div class="p-logo-section__items">
      <div class="p-logo-section__item">
        <img class="p-logo-section__logo" src="https://www.auf.edu.ph/home/images/logo2.png" alt="Angeles University Foundation">
      </div>
    </div>
  </div>
</div>

<div class="u-fixed-width" style="margin-top: 20px;">
  <div class="p-card">
    <h2>Uploaded File Details</h2>
<?php

$upload_directory = getcwd() . '/uploads/';
if (!file_exists($upload_directory)) {
    mkdir($upload_directory, 0777, true);
}

$file_uploaded = false;

// Handle PDF File
if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
    $pdf_filename = basename($_FILES['pdf_file']['name']);
    $target_pdf_path = $upload_directory . $pdf_filename;

    if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $target_pdf_path)) {
        $file_uploaded = true;
        $pdf_relative_path = 'uploads/' . rawurlencode($pdf_filename);
        ?>
        <h3>PDF File: <?php echo htmlspecialchars($pdf_filename); ?></h3>
        <div style="margin-top: 15px;">
            <object data="<?php echo $pdf_relative_path; ?>" type="application/pdf" width="100%" height="600px">
                <iframe src="<?php echo $pdf_relative_path; ?>" width="100%" height="600px" style="border: 1px solid #ccc; border-radius: 4px;">
                    <p>Your browser does not support inline PDFs. <a href="<?php echo $pdf_relative_path; ?>">Download PDF</a> instead.</p>
                </iframe>
            </object>
        </div>
        <?php
    } else {
        echo '<p class="p-text--error">Failed to upload PDF file.</p>';
    }
}

// Handle Text File
if (isset($_FILES['text_file']) && $_FILES['text_file']['error'] === UPLOAD_ERR_OK) {
    $text_filename = basename($_FILES['text_file']['name']);
    $target_text_path = $upload_directory . $text_filename;

    if (move_uploaded_file($_FILES['text_file']['tmp_name'], $target_text_path)) {
        $file_uploaded = true;
        $text_file_content = file_get_contents($target_text_path);
        ?>
        <h3>Text File: <?php echo htmlspecialchars($text_filename); ?></h3>
        <textarea cols="70" rows="15" readonly><?php echo htmlspecialchars($text_file_content); ?></textarea>
        <?php
    } else {
        echo '<p class="p-text--error">Failed to upload text file.</p>';
    }
}

if (!$file_uploaded && (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) && (!isset($_FILES['text_file']) || $_FILES['text_file']['error'] !== UPLOAD_ERR_OK)) {
    echo '<p>No file uploaded or an error occurred during upload.</p>';
}

?>
    <div style="margin-top: 20px;">
        <a href="index.php" class="p-button">Upload Another File</a>
    </div>
  </div>
</div>

</body>
</html>