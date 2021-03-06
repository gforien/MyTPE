<?php
        session_start();

                        /* stockage des valeurs renvoyées par les formulaires */
        if(isset($_POST['form']) && is_string($_POST['form']) && ($_POST['form'] == 'form-1.php')) {
                if(is_string($_POST['username']) &&
                   is_string($_POST['address']) &&
                   is_string($_POST['title']) &&
                   is_string($_POST['title_extended']) &&
                   is_string($_POST['class']) &&
                   is_string($_POST['subject']) &&
                   is_string($_POST['number_people']) &&
                   is_string($_POST['structure_axe'])) {

                        $_SESSION['TPE_username'] = $_POST['username'];
                        $_SESSION['TPE_address'] = $_POST['address'];
                        $_SESSION['TPE_title'] = $_POST['title'];
                        $_SESSION['TPE_title_extended'] = $_POST['title_extended'];
                        $_SESSION['TPE_class'] = $_POST['class'];
                        $_SESSION['TPE_subject'] = $_POST['subject'];
                        $_SESSION['TPE_number_people'] = $_POST['number_people'];

                        $_SESSION['TPE_structure_intro'] = (isset($_POST['structure_intro']))? 1: 0;
                        $_SESSION['TPE_structure_axe'] = $_POST['structure_axe'];
                        $_SESSION['TPE_structure_conclu'] = (isset($_POST['structure_conclu']))? 1: 0;
                        $_SESSION['TPE_structure_synth'] = (isset($_POST['structure_synth']))? 1: 0;
                        $_SESSION['TPE_number_axe'] = $_SESSION['TPE_structure_intro'] + $_SESSION['TPE_structure_axe'] +
                                                      $_SESSION['TPE_structure_conclu'] + $_SESSION['TPE_structure_synth'];

                        if($_SESSION['TPE_structure_intro'] == 1)
                                $_SESSION['TPE_number_part_axe_1'] = 0;
                        if($_SESSION['TPE_structure_conclu'] == 1 && $_SESSION['TPE_structure_synth'] == 1) {
                                $_SESSION['TPE_number_part_axe_'.$_SESSION['TPE_number_axe']] = 0;
                                $_SESSION['TPE_number_part_axe_'.($_SESSION['TPE_number_axe']-1)] = 0;
                        }
                        elseif($_SESSION['TPE_structure_conclu'] == 1 && $_SESSION['TPE_structure_synth'] == 0)
                                $_SESSION['TPE_number_part_axe_'.$_SESSION['TPE_number_axe']] = 0;
                        elseif($_SESSION['TPE_structure_synth'] == 1 && $_SESSION['TPE_structure_conclu'] == 0)
                                $_SESSION['TPE_number_part_axe_'.$_SESSION['TPE_number_axe']] = 0;

                        $_SESSION['form_1'] = true;
                        $_SESSION['form_2'] = false;
                        $_SESSION['form_3'] = false;
                        $_SESSION['generate'] = false;
                        header('Location: ../creation.php?page=2');
                } else {
                        $_SESSION['form_1'] = false;
                        header('Location: ../creation.php?page=1');
                }
        }
        elseif(isset($_POST['form']) && is_string($_POST['form']) && ($_POST['form'] == 'form-2.php') &&
               isset($_SESSION['form_1']) && ($_SESSION['form_1'])) {
                for ($i = 1; $i <= $_SESSION['TPE_number_people']; $i++) {
                        if(isset($_POST['people_'.$i]) && is_string($_POST['people_'.$i]))
                                $_SESSION['TPE_people_'.$i] = $_POST['people_'.$i];
                        else
                                $form_2_error = true;
                }

                $debut = $_SESSION['TPE_structure_intro'] + 1;
                $fin = $_SESSION['TPE_number_axe'] - $_SESSION['TPE_structure_conclu'] - $_SESSION['TPE_structure_synth'];
                for ($i = $debut; $i <= $fin; $i++) {
                        if(isset($_POST['number_part_axe_'.$i]) && is_string($_POST['number_part_axe_'.$i]))
                                $_SESSION['TPE_number_part_axe_'.$i] = $_POST['number_part_axe_'.$i];
                        else
                                $form_2_error = true;
                }

                if(!(isset($form_2_error))) {
                        $_SESSION['form_2'] = true;
                        $_SESSION['form_3'] = false;
                        $_SESSION['generate'] = false;
                        header('Location: ../creation.php?page=3');
                } else {
                        $_SESSION['form_2'] = false;
                        header('Location: ../creation.php?page=2');
                }
        }
        elseif(isset($_POST['form']) && is_string($_POST['form']) && ($_POST['form'] == 'form-3.php') &&
                isset($_SESSION['form_2']) && ($_SESSION['form_2'])) {

                if($_SESSION['TPE_structure_intro']) {
                        if(isset($_POST['title_1-0']))
                                $_SESSION['TPE_title_1-0'] = $_POST['title_1-0'];
                        else
                                $form_3_error = true;
                }
                if($_SESSION['TPE_structure_conclu']) {
                        if(!($_SESSION['TPE_structure_synth']) && isset($_POST['title_'.$_SESSION['TPE_number_axe'].'-0']))
                                $_SESSION['TPE_title_'.$_SESSION['TPE_number_axe'].'-0'] = $_POST['title_'.$_SESSION['TPE_number_axe'].'-0'];
                        elseif(($_SESSION['TPE_structure_synth']) && isset($_POST['title_'.($_SESSION['TPE_number_axe']-1).'-0'])) {
                                $_SESSION['TPE_title_'.($_SESSION['TPE_number_axe']-1).'-0'] = $_POST['title_'.($_SESSION['TPE_number_axe']-1).'-0'];
//                                      on annule alors la valeur du titre des fiches de synthèses : elles ne sont pas des parties
                                $_SESSION['TPE_title_'.$_SESSION['TPE_number_axe'].'-0'] = '';
                        }
                        else $form_3_error = true;
                }
                elseif($_SESSION['TPE_structure_synth'])
                        $_SESSION['TPE_title_'.$_SESSION['TPE_number_axe'].'-0'] = '';

                $debut = $_SESSION['TPE_structure_intro'] + 1;
                $fin = $_SESSION['TPE_number_axe'] - $_SESSION['TPE_structure_conclu'] - $_SESSION['TPE_structure_synth'];
                for ($i = $debut; $i <= $fin; $i++) {
                        for ($j = 0; $j <= $_SESSION['TPE_number_part_axe_'.$i]; $j++) {
                                if(isset($_POST['title_'.$i.'-'.$j]) && is_string($_POST['title_'.$i.'-'.$j]))
                                        $_SESSION['TPE_title_'.$i.'-'.$j] = $_POST['title_'.$i.'-'.$j];
                                else
                                        $form_3_error = true;
                        }
                }

                if(!(isset($form_3_error))) {
                        $_SESSION['form_3'] = true;
                        $_SESSION['generate'] = false;
                        $download = true;
                } else {
                        $_SESSION['form_3'] = false;
                        header('Location: ../creation.php?page=3');
                }
        }
        else {
                header('Location: ../creation.php');
        }



                /* appel du script master.sh qui génèrera le dossier */
                /* uniquement si le troisième formulaire est rempli et conforme */

        if(isset($download) && ($download)) {
                $command = '../generate/master.sh';

                $command = $command.' '.escapeshellarg($_SESSION['TPE_username']);
                $command = $command.' '.escapeshellarg($_SESSION['TPE_address']);
                $command = $command.' '.escapeshellarg($_SESSION['TPE_title']);
                $command = $command.' '.escapeshellarg($_SESSION['TPE_title_extended']);
                $command = $command.' '.escapeshellarg($_SESSION['TPE_class']);
                $command = $command.' '.escapeshellarg($_SESSION['TPE_subject']);

                $command = $command.' '.escapeshellarg($_SESSION['TPE_number_people']);
                for ($i = 1; $i <= $_SESSION['TPE_number_people']; $i++)
                        $command = $command.' '.escapeshellarg($_SESSION['TPE_people_'.$i]);


                $command = $command.' '.escapeshellarg($_SESSION['TPE_number_axe']);

                for ($i = 1; $i <= $_SESSION['TPE_number_axe']; $i++)
                        $command = $command.' '.escapeshellarg($_SESSION['TPE_number_part_axe_'.$i]);

                $command = $command.' '.escapeshellarg($_SESSION['TPE_structure_intro']);
                $command = $command.' '.escapeshellarg($_SESSION['TPE_structure_conclu']);
                $command = $command.' '.escapeshellarg($_SESSION['TPE_structure_synth']);

                for ($i = 1; $i <= $_SESSION['TPE_number_axe']; $i++)
                        for ($j = 0; $j <= $_SESSION['TPE_number_part_axe_'.$i]; $j++)
                                $command = $command.' '.escapeshellarg($_SESSION['TPE_title_'.$i.'-'.$j]);

                exec($command, $shell_return);

                foreach($shell_return as $key)
                        if($shell_return[$key] != '')
                                $generate_error = true;
                if(isset($generate_error) && ($generate_error)) {
                        $_SESSION['generate'] = false;
                        header('Location: ../creation.php');
                }
                else {
                        $_SESSION['generate'] = true;

                                /* DEBUG */
/*                        include('../view/HEAD.html');include('../view/NAV.php');echo '<section>';
                        echo '<p>$command : '.$command.'</p>';
                        echo '<pre>';print_r($shell_return);echo '</pre>';
                        echo '</section>';include('../view/FOOT.html');
*/
                }

 
                       /* WARNING : PAGE=4 A LA MAIN !! PAGE doit être égal à $number_pages de creation.php */
                        header('Location: ../creation.php?page=4&address='.$_SESSION['TPE_address']);
        }
?>
