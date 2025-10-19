<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Etaireia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Μαθητεία App</a>
  </div>
</nav>

<div class="container mt-4">
    <h1 class="mb-4">Add Etaireia</h1>
    <form action="../add_etaireia.php" method="post">
        <div class="mb-3">
            <label for="onoma" class="form-label">Όνομα</label>
            <input type="text" class="form-control" id="onoma" name="onoma" required>
        </div>
        <div class="mb-3">
            <label for="dieuthinsi" class="form-label">Διεύθυνση</label>
            <input type="text" class="form-control" id="dieuthinsi" name="dieuthinsi">
        </div>
        <div class="mb-3">
            <label for="tk" class="form-label">ΤΚ</label>
            <input type="text" class="form-control" id="tk" name="tk">
        </div>
        <div class="mb-3">
            <label for="til" class="form-label">Τηλέφωνο</label>
            <input type="text" class="form-control" id="til" name="til">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="www" class="form-label">URL</label>
            <input type="url" class="form-control" id="www" name="www">
        </div>
        <div class="mb-3">
            <label for="sxolia" class="form-label">Σχόλια</label>
            <textarea class="form-control" id="sxolia" name="sxolia" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="../index.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>