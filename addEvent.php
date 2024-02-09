<?php
/*
Plugin Name:   addEvent
Description:   addEvent
Version: 1.0
Author: florian
*/

if (!defined('ABSPATH')) {
    exit;
}

add_action('acf/init', 'my_acf_init');

function my_acf_init()
{
    if (function_exists('acf_add_local_field_group'))
//cette section va déclarer un groupe avec des valeurs
// que j'appellerais plus bas pour récupérer les données
        acf_add_local_field_group(
            array(
                'key' => 'group_1',
                'title' => 'évènement',
                'fields' => array(
                    array(
                        'key' => 'field_1',
                        'label' => 'Date',
                        'name' => 'date',
                        'type' => 'date_picker',
                    ),
                    array(
                        'key' => 'field_2',
                        'label' => 'Heure',
                        'name' => 'heure',
                        'type' => 'time_picker'
                    ),
                    array(
                        'key' => 'field_3',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_4',
                        'label' => 'Informations privées',
                        'name' => 'informations',
                        'type' => 'text',
                    )
                    ),
                    //Cette section spécifie où le groupe de champs
                    // doit être affiché (product)
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'product',
                        ),
                    ),
                ),

            )
        );
}


// on récupére les informations des champs avec get_field
function events_shortcode()
{
    $event = '<h2>Détails de l\'événement</h2>
    <p>Date(s) : ' . get_field('date') . ' </p>
    <p>Heure : ' . get_field('heure') . ' </p>
    <p>Description : ' . get_field('description') . ' </p>;
    <p>Informations : ' . get_field('informations') . ' </p>';

    return $event;
}
//créer le shortcode ('event') que j'utiliserais dans WordPress ensuite [event]
add_shortcode('event', 'events_shortcode');

function countdown_timer_shortcode() {
    ob_start(); ?>

    <div id="countdown_timer"></div>

    <script>
        // Fixe la date jusqu'à laquelle nous comptons à rebours
        var countDownDate = new Date("feb 10, 2024 00:00:00").getTime();

       // Met à jour le compte à rebours toutes les 1 seconde
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;

            // Calculer les jours, les heures, les minutes et les secondes
            //Math.floor renvoie un nombre entier inférieur le plus proche du nombre donné
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Afficher le compte à rebours
            document.getElementById("countdown_timer").innerHTML = days + "jours " + hours + "heures " + minutes + "minutes " + seconds + "secconds ";

            // Si le compte à rebours est terminé, affichez un message
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown_timer").innerHTML = "évènement expiré";
            }
        }, 1000);
    </script>

    <?php
    return ob_get_clean();
}

add_shortcode('countdown_timer', 'countdown_timer_shortcode');

?>