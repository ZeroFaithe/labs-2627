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

<div class="u-fixed-width" style="margin-top: 20px; margin-bottom: 40px;">
  <div class="p-card">
    <h2>Uploaded File Details</h2>
<?php

$upload_directory = getcwd() . '/uploads/';
if (!file_exists($upload_directory)) {
    mkdir($upload_directory, 0777, true);
}

$file_uploaded = false;

// Handle Text File
if (isset($_FILES['text_file']) && $_FILES['text_file']['error'] === UPLOAD_ERR_OK) {
    $text_filename = basename($_FILES['text_file']['name']);
    $target_text_path = $upload_directory . $text_filename;

    if (move_uploaded_file($_FILES['text_file']['tmp_name'], $target_text_path)) {
        $file_uploaded = true;
        $text_file_content = file_get_contents($target_text_path);
        ?>
        <div style="margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #ddd;">
            <h3>Text File: <?php echo htmlspecialchars($text_filename); ?></h3>
            <textarea cols="70" rows="10" readonly style="width: 100%; max-width: 100%;"><?php echo htmlspecialchars($text_file_content); ?></textarea>
        </div>
        <?php
    } else {
        echo '<p class="p-text--error">Failed to upload text file.</p>';
    }
}

// Handle PDF File
if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
    $pdf_filename = basename($_FILES['pdf_file']['name']);
    $target_pdf_path = $upload_directory . $pdf_filename;

    if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $target_pdf_path)) {
        $file_uploaded = true;
        $pdf_relative_path = 'uploads/' . rawurlencode($pdf_filename);
        ?>
        <div style="margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #ddd;">
            <h3>PDF File: <?php echo htmlspecialchars($pdf_filename); ?></h3>
            <div style="margin-top: 15px;">
                <object data="<?php echo $pdf_relative_path; ?>" type="application/pdf" width="100%" height="600px">
                    <iframe src="<?php echo $pdf_relative_path; ?>" width="100%" height="600px" style="border: 1px solid #ccc; border-radius: 4px;">
                        <p>Your browser does not support inline PDFs. <a href="<?php echo $pdf_relative_path; ?>">Download PDF</a> instead.</p>
                    </iframe>
                </object>
            </div>
        </div>
        <?php
    } else {
        echo '<p class="p-text--error">Failed to upload PDF file.</p>';
    }
}

// Handle Audio (MP3) File
if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] === UPLOAD_ERR_OK) {
    $audio_filename = basename($_FILES['audio_file']['name']);
    $target_audio_path = $upload_directory . $audio_filename;

    if (move_uploaded_file($_FILES['audio_file']['tmp_name'], $target_audio_path)) {
        $file_uploaded = true;
        $audio_relative_path = 'uploads/' . rawurlencode($audio_filename);
        $mime_type = mime_content_type($target_audio_path) ?: 'audio/mpeg';
        ?>
        <div style="margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #ddd;">
            <h3>Audio File: <?php echo htmlspecialchars($audio_filename); ?></h3>
            <audio controls style="width: 100%; margin-top: 10px;">
                <source src="<?php echo $audio_relative_path; ?>" type="<?php echo htmlspecialchars($mime_type); ?>">
                Your browser does not support the audio element.
            </audio>
        </div>
        <?php
    } else {
        echo '<p class="p-text--error">Failed to upload audio file.</p>';
    }
}

// Handle Video (MP4) File
if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
    $video_filename = basename($_FILES['video_file']['name']);
    $target_video_path = $upload_directory . $video_filename;

    if (move_uploaded_file($_FILES['video_file']['tmp_name'], $target_video_path)) {
        $file_uploaded = true;
        $video_relative_path = 'uploads/' . rawurlencode($video_filename);
        $mime_type = mime_content_type($target_video_path) ?: 'video/mp4';
        ?>
        <div style="margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #ddd;">
            <h3>Video File: <?php echo htmlspecialchars($video_filename); ?></h3>
            <video controls width="100%" style="max-height: 500px; border-radius: 4px; margin-top: 10px; background-color: #000;">
                <source src="<?php echo $video_relative_path; ?>" type="<?php echo htmlspecialchars($mime_type); ?>">
                Your browser does not support the video tag.
            </video>
        </div>
        <?php
    } else {
        echo '<p class="p-text--error">Failed to upload video file.</p>';
    }
}

// Handle Image File
if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
    $image_filename = basename($_FILES['image_file']['name']);
    $target_image_path = $upload_directory . $image_filename;

    if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_image_path)) {
        $file_uploaded = true;
        $image_relative_path = 'uploads/' . rawurlencode($image_filename);
        ?>
        <div style="margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #ddd;">
            <h3>Image File: <?php echo htmlspecialchars($image_filename); ?></h3>
            <div style="margin-top: 10px;">
                <img src="<?php echo $image_relative_path; ?>" alt="<?php echo htmlspecialchars($image_filename); ?>" style="max-width: 100%; max-height: 500px; border-radius: 4px; border: 1px solid #ccc;" />
            </div>
        </div>
        <?php
    } else {
        echo '<p class="p-text--error">Failed to upload image file.</p>';
    }
}

if (!$file_uploaded) {
    echo '<p>No file was uploaded or an error occurred during upload.</p>';
}

?>
    <div style="margin-top: 20px;">
        <a href="index.php" class="p-button">Upload Another File</a>
    </div>
  </div>
</div>

</body>
</html>