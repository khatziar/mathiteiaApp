<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Εταιρείες</title>
</head>
<body>
    <h1>Εταιρείες Μαθητείας</h1>

        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Όνομα</th>
                    <th>Διεύθυνση</th>
                    <th>ΤΚ</th>
                    <th>Τηλέφωνο</th>
                    <th>Email</th>
                    <th>URL</th>
                    <th>Σχόλια</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($etaireies as $etaireia): ?>
                <tr>
                    <td><?php echo htmlspecialchars($etaireia['id']); ?></td>
                    <td><?php echo htmlspecialchars($etaireia['onoma']); ?></td>
                    <td><?php echo htmlspecialchars($etaireia['dieuthinsi']); ?></td>
                    <td><?php echo htmlspecialchars($etaireia['tk']); ?></td>
                    <td><?php echo htmlspecialchars($etaireia['til']); ?></td>
                    <td>                        <?php if (!empty($etaireia['email'])): ?>
                            <a href="mailto:<?php echo htmlspecialchars($etaireia['email']); ?>" target="_blank">
                                <?php echo htmlspecialchars($etaireia['email']); ?>
                            </a>
                        <?php endif; ?></td>
                    <td>
                        <?php if (!empty($etaireia['www'])): ?>
                            <a href="<?php echo htmlspecialchars($etaireia['www']); ?>" target="_blank">
                                <?php echo htmlspecialchars($etaireia['www']); ?>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($etaireia['sxolia']); ?></td>
                </tr>
        <?php endforeach; ?>
            </tbody>
        </table>


</body>
</html>