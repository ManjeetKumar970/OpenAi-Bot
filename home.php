<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <link rel="stylesheet" href="style.css">
    <style>
textarea {

  width: 100%;
  min-height: 100px;
  padding: 6px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
  resize: vertical;
  height: 700px;
}
</style>

</head>


<?php
$sanitizedMessage = isset($_GET['text']) ? htmlspecialchars($_GET['text']) : null;
?>
<body>
    <div class="chat-container" style=" margin-right: 10px;">
    <h1>Message</h1>
    <form method="POST" action="flitterText.php">
        <textarea type="text" name="text" placeholder="Type your message..." rows="10" cols="50" style="width: 100%; resize: vertical;" required></textarea>
        <button type="submit">Send</button>
    </form>
</div>



<div class="chat-container">
    <h1>Sanitiz Data</h1>
    <form method="POST" action="">
    <textarea name="text" placeholder="Type your message..." rows="10" cols="50" style="width: 100%; resize: vertical;"><?php echo nl2br($sanitizedMessage); ?></textarea>
        <button type="submit">Send</button>
    </form>
</div>



    <script src="script.js"></script>
</body>
</html>