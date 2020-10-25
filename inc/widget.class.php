<?php
//classe widget_categorie_cle qui hérite du WP_Widget et qui nous permet de gérer notre widget
class widget_categorie_cle extends WP_Widget{

    public function __construct(){
        parent::__construct('id_widget','Liste des Catégorie
         et des mots clés', 
         $widget_ops);
    
    $widget_ops=array('classname'=> 'widget_categorie_cle',
    'description'=> "ce widget permet d'afficher
    la liste des catégorie et des mots clés ");
    }

	// fonction widget pour l'afficher dans ma page web
	public function widget( $args, $instance ) {
        
        wp_enqueue_style('widget-style');
        //on encapsule tous les résultats de notre widget dans un bloc div
        echo "<div class='widget-style'>";
        //si le titre est vide on affiche ce titre
		if (empty($instance['title'])) {
            echo '<h1>Liste des Catégories et Mots clés</h1>' ;
		}else{
            echo '<h1>'.$instance['title'].'</h1>';
            echo '<br>';
           
            //on vérifie si les nos données qu'on reçoit de update sont plus grand que zéro !
            if(isset($instance['nbCat']) && ($instance['nbCat'] > 0 ) && isset($instance['nbCle']) && ($instance['nbCle'] > 0 ) ){
                echo'<h2> Liste des Catégorie : </h2>';
                echo '<br>';
            
                $tab=get_categories( array('orderby' => $instance['liste']) );
                $count=1;
                // on utilise une boucle foreach pour parcourir le tableau retourner de la méthode get_catgories 
                foreach($tab as $val){
                    if($instance['nbCat']>=$count){
                        echo '<p>Catégorie '.$count.' : '.$val->name.'</p>';
                        //on utilise un compteur 
                        $count++;
                    }
                }

                echo'<h2> Liste des Mots Clés : </h2>';
                echo '<br>';
                
                $tab2=get_tags( array('orderby' => $instance['liste']) );
                $count2=1;
                foreach($tab2 as $val2){
                    if($instance['nbCle']>=$count2){
                        echo '<p>Mots clés '.$count2.' : '.$val2->name.'</p>';
                        $count2++;
                    }
                }

            }else{
                echo '<p>veuillez rentrer un nombre valide !</p>';
            }
            
        }
		echo "</div>";
	}

	// fonction form pour créer un formulaire qui me permet de modifier mon widget
	public function form( $instance ) {

        
        if(isset($instance['title']) && isset($instance['nbCat']) && isset($instance['nbCle']) ){
            $titre=$instance['title'];
            $nbCat=$instance['nbCat'];
            $nbCle=$instance['nbCle'];
            
        }else{
            $titre='Catégorie et Mots clés';
            $nbCat=sizeof(get_categories());
            $nbCle=sizeof(get_tags());
           
        }
       

        ?>

        <p>
        <label for="title">Titre :</label>
        <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $titre; ?>" id="<?php echo $this->get_field_id('title'); ?>">
        </p>

        <p>
        <label for="nbCat">Nombre de Catégorie à afficher :</label>
        <input type="text" name="<?php echo $this->get_field_name('nbCat'); ?>" value="<?php echo $nbCat; ?>" id="<?php echo $this->get_field_id('nbCat'); ?>">
        </p>

        <p>
        <label for="nbCle">Nombre de Mots Clés à afficher :</label>
        <input type="text" name="<?php echo $this->get_field_name('nbCle'); ?>" value="<?php echo $nbCle; ?>" id="<?php echo $this->get_field_id('nbCle'); ?>">
        </p>

        <p>
        <label for="liste">L'ordre du tri :</label>
        <select name="<?php echo $this->get_field_name('liste'); ?>" id="<?php echo $this->get_field_id('liste');?>" >
            <option value="name">Nom</option>
            <option value="count">Nombre</option>
        </select>
        </p> 

        <?php
	}

    // fonction update pour les mis à jour de mon widget 

    public function update($new_instance, $old_instance){
        
        //je vérifie si mes nouvelles instances sont correctes pour pouvoir les utiliser sinon je retourne les anciennes instances 
        
        if(isset($new_instance['title']) && isset($new_instance['nbCat']) 
            && !is_numeric($new_instance['title']) &&
            is_numeric($new_instance['nbCat']) &&  
            is_numeric($new_instance['nbCle']) ){
            
            if(($new_instance['nbCat'] > 0) && ($new_instance['nbCle'] > 0 )){
                return $new_instance;
            }else{
                return $old_instance;
            }

        }else{

            return $old_instance;
        }     
    }
}