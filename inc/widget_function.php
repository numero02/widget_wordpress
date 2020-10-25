<?php

function affichage_dashBoard(){
    wp_enqueue_style('widget-style');
    // je mets un tableau en paramètre dans la fonction get_categories qui me permet de choisir l'ordre du tri.
    $tab=get_categories(array('orderby' => get_option("liste")));
    $count=1;
    //si la nbCat n'est pas initialisé dans la base de données je mets une valeur par défaults false
    $test=get_option("nbCat",false);
    // je mets un tableau en paramètre dans la fonction get_tags qui me permet de choisir l'ordre du tri.
    $tab2=get_tags(array('orderby' => get_option("liste")));
    
    $count2=1;
    //si la nbCle n'est pas initialisé dans la base de données je mets une valeur par défaults false
    $test2=get_option("nbCle",false);
    //si l'un des deux valeurs n'est pas rentrées dans les réglages je retourne un message d'erreur
    
    if(($test == false) || ($test2 == false) || ($test <= 0) || ($test2 <= 0) || (!is_numeric($test)) || (!is_numeric($test2))  ){
        
        echo "<p>Veuillez remplir le formulaire correctement dans les réglages pour afficher les listes des mots clés et catégories !</p>";
    
    }else{
        echo "<div class='widget-style'>";
        echo '<h2>Listes des Catégories : </h2>';
        foreach($tab as $val){
            if(get_option("nbCat")>=$count){
                echo"<h2>Catégorie ".$count." : </h2>";
                echo "<p>Nom de la catégorie : ".$val->name.".</p>";
                echo "<p>Nombre d'article associé à cette catégorie est : ".$val->category_count.".</p>";
                $count++;
            }
        }

        echo '<h2>Listes des Mots Clés : </h2>';
        foreach($tab2 as $val2){
            if(get_option("nbCle")>=$count2){
                echo"<h2>Mot Clé ".$count2." : </h2>";
                echo "<p>Nom de la Mot Clé : ".$val2->name.".</p>";
                echo "<p>Nombre d'article associé à ce Mot Clé est : ".$val2->count.".</p>";
                $count2++;
            }
        }
        echo "</div>";
    }
}

if(is_admin()){

    add_action('admin_menu', function(){
        add_options_page('Liste Catégories et mots clés' , 'Mots Clés et Catégories' , 'manage_options',
        "form_option", 'form_option_liste');
    });

    add_action('admin_init', function(){
        register_setting("form_cat_cle", "nbCat");
        register_setting("form_cat_cle", "nbCle");
        register_setting("form_cat_cle", "liste");
    });
}

function form_option_liste(){
    
    ?>
    <h2>Réglage de l'extention : </h2>
    <form action="options.php" method="post">
    <?php
        settings_fields('form_cat_cle');
        do_settings_sections('form_cat_cle');
        ?>
        <p>
        <label for="nbCat">Nombre de Catégorie à afficher :</label>
        <input type="text" name="nbCat" id="nbCat">
        </p>
        <p>
        <label for="nbCle">Nombre de Mots clés à afficher :</label>
        <input type="text" name="nbCle" id="nbCle">
        </p>
        <label for="liste">Choississez l'ordre du tri : </label>
        <select name="liste" id="liste">
            <option value="name">nom</option>
            <option value="count">nombre</option>
        </select>

        <?php
        submit_button();
        ?>
    </form>

    <?php
    
}