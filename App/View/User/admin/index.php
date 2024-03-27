<header>
    <h1>Liste des membres</h1>
</header>
<table class="table table-striped align-middle">
    <thead class="table-light">
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>E-mail</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody >

    <?php foreach($users as $user): ?>

        <tr>
            <td><?= $user->nom ?></td>
            <td><?= $user->prenom ?></td>
            <td><?= $user->email ?></td>
            <td>
                <nav class="action-menu">
                    <ul>
                        <li>Editer</li>
                        <li>Supp</li>
                    </ul>
                </nav>
            </td>
        </tr>

    <?php endforeach; ?>

    </tbody>

    <tfoot>
    <tr>
        <td colspan="6">Pagination</td>
    </tr>
    </tfoot>
</table>

