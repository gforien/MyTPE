<?php
        echo '<h2>Informations de base :</h2>';

        if (isset($_SESSION['form_1']) && $_SESSION['form_1'] == true) {
                echo '<form action="model/master.php" method="post">';
                echo '<input name="form" type="hidden" value="form-1.php"/>';
                echo '<label for="a">Nom d\'utilisateur :</label>
                      <input name="username" type="text" size="15" id="a" value="'.$_SESSION['TPE_username'].'"/><br />';
                echo '<label for="b">Adresse du site :</label>
                      <input name="address" type="text" size="15" id="b" value="'.$_SESSION['TPE_address'].'"/><br />';
                echo '<label for="c">Titre des travaux :</label>
                      <input name="title" type="text" size="15" id="c" value="'.$_SESSION['TPE_title'].'"/><br />';
                echo '<label for="d">Extension, titre secondaire :</label>
                      <input name="title_extended" type="text" size="40" id="d" value="'.$_SESSION['TPE_title_extended'].'"/><br />';
                echo '<label for="e">Classe :</label>
                      <input name="class" type="text" size="10" id="e" value="'.$_SESSION['TPE_class'].'"/><br />';
                echo '<label for="f">Matières concernées :</label>
                      <input name="subject" type="text" size="40" id="f" value="'.$_SESSION['TPE_subject'].'"/><br />';
                echo '<label for="g">Nombre de personnes :</label>
                      <input name="number_people" type="text" id="g" value="'.$_SESSION['TPE_number_people'].'"/><br />';
                echo '<label for="h">Nombre d\'axes d\'étude du sujet :</label>
                      <input name="number_axe" type="text" id="h" value="'.$_SESSION['TPE_number_axe'].'"/><br />';
                echo '<input type="submit" value="Continuer"/>';
                echo '</form>';
        }
        else {
?>
                <form action="model/master.php" method="post">
                        <input name="form" type="hidden" value="form-1.php"/>

                        <label for="a">Nom d'utilisateur :</label>             <input name="username" type="text" size="15" id="a"/><br />
                        <label for="b">Adresse du site :</label>                <input name="address" type="text" size="15" id="b"/><br />
                        <label for="c">Titre des travaux :</label>              <input name="title" type="text" size="15" id="c"/><br />
                        <label for="d">Extension, titre secondaire :</label>    <input name="title_extended" type="text" size="40" id="d"/><br />
                        <label for="e">Classe :</label>                         <input name="class" type="text" size="10" id="e"/><br />
                        <label for="f">Matières concernées :</label>            <input name="subject" type="text" size="40" id="f"/><br />
                        <label for="g">Nombre de personnes :</label>            <input name="number_people" type="text" id="g"/><br />
                        <label for="h">Nombre d'axes d'étude du sujet :</label> <input name="number_axe" type="text" id="h"/><br />
                        <input type="submit" value="Continuer"/>
                </form>
<?php
        }
?>
