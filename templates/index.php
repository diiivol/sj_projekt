<!-- Header -->
<?php
/**
 * Tento súbor sa používa na spustenie relácie a zahrnutie všetkých potrebných tried.
 */
if (!file_exists('partials/header.php')) {
    die('Chyba: chýba súbor s hlavičkou stránky. Prosím, kontaktujte administrátora.');
}

/**
 * Zahrnutie headeru
 */
include 'partials/header.php';

?>
<!--  -->
<!-- Content -->
<div class="main-content text-center">
    <div class="container">
    <!--  -->
    <!-- Rôzne nadpisy (1b) -->
    <!-- Formátovanie (1b) -->
    <!--  -->
        <h1 class="main-heading">Vitajte v našej reštaurácii</h1>
        <h2 class="sub-heading">Chutné jedlá podávané s láskou!</h2>
        <!--  -->
    </div>
    <div class="hodiny p-4">
    <!--  -->
    <!-- Tabuľka (1b)  -->
    <!--  -->
        <table>
            <thead>
                <tr>
                    <th>DEŇ</th>
                    <th>OD</th>
                    <th>DO</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PO-ST</td>
                    <td>10:30</td>
                    <td>20:00</td>
                </tr>
                <tr>
                    <td>ŠT</td>
                    <td>10:00</td>
                    <td>21:00</td>
                </tr>
                <tr>
                    <td>SO</td>
                    <td>11:30</td>
                    <td>20:00</td>
                </tr>
                <tr>
                    <td>NE</td>
                    <td>11:00</td>
                    <td>21:00</td>
                </tr>
            </tbody>
        </table>
    <!--  -->
    </div>
</div>
<!-- Odkazy na scripty -->
<script src="../assets/js/preload.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!--  -->
</body>
</html>