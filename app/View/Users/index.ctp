<h1>User list</h1>

<table>
    <tr>
        <th>Username</th>
    </tr>
    <?php foreach($users as $user): ?>
    <tr>
        <td><?= $user['User']['username'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
