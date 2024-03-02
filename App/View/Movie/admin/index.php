<header>
    <h1>Liste des films en salles</h1>

</header>
<table class="table table-striped align-middle">
    <thead class="table-light">
        <tr>
            <th>Nom</th>
            <th>Cinéma</th>
            <th>Ville</th>
            <th>Début d'exploitation</th>
            <th>Fin d'exploitation</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody >

    <?php foreach($movies as $movie): ?>

        <tr>
            <td><?= $movie->nom ?></td>
            <td>cinéma</td>
            <td>ville</td>
            <td>début d'exploitation</td>
            <td>fin d'exploitation</td>
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