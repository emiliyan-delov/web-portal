<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Free Web tutorials">
    <meta name="author" content="Emiliyan Delov">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List - Web Portal</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="wrapper">
    <h1>Task List - Web Portal</h1>

    <div class="head-box">
        <input type="text" id="search" placeholder="Search tasks..." onkeyup="filterTable()">
        <button class="upload_image" onclick="openModal()">Upload Image</button>
    </div>

    <table id="taskTable">
        <thead>
        <tr>
            <th class="w-7">Task</th>
            <th class="w-26">Title</th>
            <th class="w-60">Description</th>
            <th class="w-7">Color</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div id="loading" style="">
        <img src="https://i.gifer.com/ZKZg.gif" width="80px" alt="Loading..."/>
    </div>

    <div id="overlay" onclick="closeModal()"></div>
    <div id="modal">
        <h2>Upload Image</h2>
        <input type="file" id="imageInput" accept="image/*">
        <br><br>
        <img id="selected-image" alt="">
        <br><br>
        <button onclick="closeModal()">Close</button>
    </div>

</div>
<script src="js/scripts.js"></script>
</body>
</html>
