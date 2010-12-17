<?php

/**
 * Classe plxShow responsable de l'affichage sur stdout
 *
 * @package PLX
 * @author	Florent MONTHEL
 **/
class plxShow {

	var $plxMotor = false; # Objet plxMotor

	/**
	 * Constructeur qui initialise l'objet plxMotor par rйfйrence
	 *
	 * @param	plxMotor	objet plxMotor passй par rйfйrence
	 * @return	null
	 * @author	Florent MONTHEL
	 **/
	function plxShow(&$plxMotor) {

		$this->plxMotor = &$plxMotor;
	}

	/**
	 * Mйthode qui affiche le charset selon la casse $casse
	 *
	 * @param	casse	casse min ou maj
	 * @return	stdout
	 * @author	Florent MONTHEL
	 **/
	function charset($casse='min') {

		if($casse != 'min') # En majuscule
			echo strtoupper(PLX_CHARSET);
		else # En minuscule
			echo strtolower(PLX_CHARSET);
	}

	/**
	 * Mйthode qui affiche la version de Pluxml
	 *
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function version() {

		echo $this->plxMotor->version;
	}

	/**
	 * Mйthode qui affiche la variable get de l'objet plxMotor (variable $_GET globale)
	 *
	 * @return	stdout
	 * @author	Florent MONTHEL
	 **/
	function get() {

		echo $this->plxMotor->get;
	}

	/**
	 * Mйthode qui affiche le temps d'exйcution de la page
	 *
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function chrono() {

		echo round(plxUtils::microtime()-$this->plxMotor->start,3).'s';
	}

	/**
	 * Mйthode qui affiche le dossier de stockage du style actif
	 *
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function template() {

		echo PLX_ROOT.'themes/'.$this->plxMotor->style;
	}

	function introduc() {

		echo $this->plxMotor->intro;
	}


	/**
	 * Mйthode qui affiche le titre de la page selon le mode
	 *
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function pageTitle() {

		if($this->plxMotor->mode == 'home') {
			echo htmlspecialchars($this->plxMotor->aConf['title'].' - '.$this->plxMotor->aConf['description'],ENT_QUOTES,PLX_CHARSET);
			return;
		}
		if($this->plxMotor->mode == 'categorie') {
			echo htmlspecialchars($this->plxMotor->aConf['title'].' - '.$this->plxMotor->aCats[ $this->plxMotor->cible ]['name'],ENT_QUOTES,PLX_CHARSET);
			return;
		}
		if($this->plxMotor->mode == 'article') {
			echo htmlspecialchars($this->plxMotor->plxRecord_arts->f('title').' - '.$this->plxMotor->aConf['title'],ENT_QUOTES,PLX_CHARSET);
			return;
		}
		if($this->plxMotor->mode == 'static') {
			echo htmlspecialchars($this->plxMotor->aConf['title'].' - '.$this->plxMotor->aStats[ $this->plxMotor->cible ]['name'],ENT_QUOTES,PLX_CHARSET);
			return;
		}
		if($this->plxMotor->mode == 'galeria') {
			echo htmlspecialchars($this->plxMotor->aConf['title'].' - '.$this->plxMotor->aGals[ $this->plxMotor->cible ]['name'],ENT_QUOTES,PLX_CHARSET);
			return;
		}
		if($this->plxMotor->mode == 'fonts') {
			echo htmlspecialchars($this->plxMotor->aConf['title'].' - '.$this->plxMotor->aStats[ $this->plxMotor->cible ]['name'],ENT_QUOTES,PLX_CHARSET);
			return;
		}				
		if($this->plxMotor->mode == 'erreur') {
			echo htmlspecialchars($this->plxMotor->aConf['title'],ENT_QUOTES,PLX_CHARSET).' - '.$this->plxMotor->plxErreur->getMessage();
			return;
		}
	}

	/**
	 * Mйthode qui affiche le titre du blog linkй (variable $type='link') ou non
	 *
	 * @param	type	type d'affichage : link => sous forme de lien
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function mainTitle($type='') {

		$title = htmlspecialchars($this->plxMotor->aConf['title'],ENT_QUOTES,PLX_CHARSET);
		if($type == 'link') # Type lien
			echo '<a href="./" title="'.$title.'">'.$title.'</a>';
		else # Type normal
			echo $title;
	}

	/**
	 * Mйthode qui affiche le sous-titre du blog
	 *
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function subTitle() {

		echo htmlspecialchars($this->plxMotor->aConf['description'],ENT_QUOTES,PLX_CHARSET);
	}

	/**
	 * Mйthode qui affiche le nombre de catйgories actives du site.
	 *
	 * @return	stdout
	 * @author	Florent MONTHEL
	 **/
	function nbAllCat() {

		# Initialisation
		$nb = 0;
		# On verifie qu'il y a des categories
		if($this->plxMotor->aCats) {
			foreach($this->plxMotor->aCats as $k=>$v) {
				if($v['articles'] > 0) # On a des articles
					$nb++;
			} # Fin du while
		}
		# On procиde а l'affichage
		if($nb < 2)
			echo $nb.' cat&eacute;gorie';
		else
			echo $nb.' cat&eacute;gories';
	}

	/**
	 * Mйthode qui affiche le nombre d'articles du site.
	 *
	 * @return	stdout
	 * @author	Florent MONTHEL
	 **/
	function nbAllArt() {

		# Initialisation
		$nb = 0;
		# Nouvel objet pour compter le nombre d'articles
		$plxGlob_arts = & new plxGlob(PLX_ROOT.$this->plxMotor->aConf['racine_articles']);
		$plxGlob_arts->query('/^[0-9]{4}.[0-9]{3}.(.+).xml$/');
		$nb = $plxGlob_arts->count;
		# On procиde а l'affichage
		if($nb < 2)
			echo $nb.' article';
		else
			echo $nb.' articles';
	}


	/**
	 * Mйthode qui affiche la liste des pages statiques.
	 * Si la variable $extra est renseignйe, un lien vers la 
	 * page d'accueil (nommй $extra) sera mis en place en premiиre 
	 * position
	 *
	 * @param	extra	nom du lien vers la page d'accueil
	 * @return	stdout
	 * @author	Florent MONTHEL, Stephane F.
	 **/
	function staticList($extra='') {
	if ($this->plxMotor->index_get==0) $href=''; else $href="?news";
		# Si on a la variable extra, on affiche un lien vers la page d'accueil
		if($extra != '') {
			$title = htmlspecialchars($this->plxMotor->aConf['title'],ENT_QUOTES,PLX_CHARSET);
			if($this->plxMotor->mode == 'home' AND $this->plxMotor->cible == '')
				echo '<li class="active"><a class="'.$title.'" href="./'.$href.'" title="'.$title.'">'.$extra.'</a></li>';
			else
				echo '<li><a class="'.$title.'" href="./'.$href.'" title="'.$title.'">'.$extra.'</a></li>';
		}
        if($this->plxMotor->aGals) {
			foreach($this->plxMotor->aGals as $k=>$v) {
				if($v['readable'] == 1 AND $v['active'] == 1) { # La page existe bien et elle est active
					$name = htmlspecialchars($v['name'],ENT_QUOTES,PLX_CHARSET);
					$url = './?galeria'.intval($k).'/'.$v['url'];
					if($this->plxMotor->mode == 'galeria' AND $this->plxMotor->cible == $k)
						echo '<li class="active"><a class="'.$name.'" href="'.$url.'" title="'.$name.'">'.$name.'</a></li>';
					else
						echo '<li><a class="'.$name.'" href="'.$url.'" title="'.$name.'">'.$name.'</a></li>';
				}
			} # Fin du while
		}

		# On verifie qu'il y a des pages statiques
		if($this->plxMotor->aStats) {
			foreach($this->plxMotor->aStats as $k=>$v) {
				if($v['readable'] == 1 AND $v['active'] == 1) { # La page existe bien et elle est active
					$name = htmlspecialchars($v['name'],ENT_QUOTES,PLX_CHARSET);
					$url = './?static'.intval($k).'/'.$v['url'];
					if($this->plxMotor->mode == 'static' AND $this->plxMotor->cible == $k)
						echo '<li class="active"><a class="'.$name.'" href="'.$url.'" title="'.$name.'">'.$name.'</a></li>';
					else
						echo '<li><a class="'.$name.'" href="'.$url.'" title="'.$name.'">'.$name.'</a></li>';
				}
			} # Fin du while
		}
		
				
		
	}

	/**
	 * Mйthode qui affiche la liste des catйgories actives.
	 * Si la variable $extra est renseignйe, un lien vers la 
	 * page d'accueil (nommй $extra) sera mis en place en premiиre 
	 * position.
	 *
	 * @param	extra	nom du lien vers la page d'accueil
	 * @param	format du texte pour chaque categorie (variable : #cat_id,#cat_name,#art_nb)
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function catList($extra='', $format='#cat_name') {

		# Si on a la variable extra, on affiche un lien vers la page d'accueil (avec $extra comme nom)
		if($extra != '') {
			$title = htmlspecialchars($this->plxMotor->aConf['title'],ENT_QUOTES,PLX_CHARSET);
			if($this->plxMotor->mode == 'home' AND $this->plxMotor->cible == '')
				echo '<li class="active"><a href="./" title="'.$title.'">'.$extra.'</a></li>';
			elseif($this->plxMotor->mode == 'article' AND $this->plxMotor->plxRecord_arts->f('categorie') == 'home')
				echo '<li class="active"><a href="./" title="'.$title.'">'.$extra.'</a></li>';
			else
				echo '<li><a href="./" title="'.$title.'">'.$extra.'</a></li>';
		}
		# On verifie qu'il y a des categories
		if($this->plxMotor->aCats) {
			foreach($this->plxMotor->aCats as $k=>$v) {
				if($v['articles'] > 0) { # On a des articles
					$v['name'] = htmlspecialchars($v['name'],ENT_QUOTES,PLX_CHARSET);
					# On modifie nos motifs
					$name = str_replace('#cat_id',intval($k),$format);
					$name = str_replace('#cat_name',$v['name'],$name);
					$name = str_replace('#art_nb',$v['articles'],$name);
					# Ok
					$url = './?categorie'.intval($k).'/'.$v['url'];
					if($this->plxMotor->mode == 'categorie' AND $this->plxMotor->cible == $k)
						echo '<li class="active"><a href="'.$url.'" title="'.$v['name'].'">'.$name.'</a></li>';
					elseif($this->plxMotor->mode == 'article' AND $this->plxMotor->plxRecord_arts->f('categorie') == $k)
						echo '<li class="active"><a href="'.$url.'" title="'.$v['name'].'">'.$name.'</a></li>';
					else
						echo '<li><a href="'.$url.'" title="'.$v['name'].'">'.$name.'</a></li>';
				}
			} # Fin du while
		}
	}

	/**
	 * Mйthode qui affiche l'id de la catйgorie active (0 si non trouvй)
	 *
	 * @return	stdout
	 * @author	Florent MONTHEL
	 **/
	function catId() {

		# On va verifier que la categorie existe en mode categorie
		if($this->plxMotor->mode == 'categorie' AND isset($this->plxMotor->aCats[ $this->plxMotor->cible ]))
			echo intval($this->plxMotor->cible);
		# On va verifier que la categorie existe en mode article
		elseif($this->plxMotor->mode == 'article' AND isset($this->plxMotor->aCats[ $this->plxMotor->plxRecord_arts->f('categorie') ]))
			echo intval($this->plxMotor->plxRecord_arts->f('categorie'));
		else
			echo '0';
	}

	/**
	 * Mйthode qui affiche le nom de la catйgorie active (linkй ou non)
	 *
	 * @param	type	type d'affichage : link => sous forme de lien
	 * @return	stdout
	 * @author	Florent MONTHEL
	 **/
	function catName($type='') {

		# On va verifier que la categorie existe en mode categorie
		if($this->plxMotor->mode == 'categorie' AND isset($this->plxMotor->aCats[ $this->plxMotor->cible ])) {
			# On recupere les infos de la categorie
			$id = $this->plxMotor->cible;
			$name = htmlspecialchars($this->plxMotor->aCats[ $id ]['name'],ENT_QUOTES,PLX_CHARSET);
			$url = $this->plxMotor->aCats[ $id ]['url'];
			# On effectue l'affichage
			if($type == 'link')
				echo '<a href="./?categorie'.intval($id).'/'.$url.'" title="'.$name.'">'.$name.'</a>';
			else
				echo $name;
		}
		# On va verifier que la categorie existe en mode article
		elseif($this->plxMotor->mode == 'article' AND isset($this->plxMotor->aCats[ $this->plxMotor->plxRecord_arts->f('categorie') ])) {
			# On recupere les infos de la categorie
			$id = $this->plxMotor->plxRecord_arts->f('categorie');
			$name = htmlspecialchars($this->plxMotor->aCats[ $id ]['name'],ENT_QUOTES,PLX_CHARSET);
			$url = $this->plxMotor->aCats[ $id ]['url'];
			# On effectue l'affichage
			if($type == 'link')
				echo '<a href="./?categorie'.intval($id).'/'.$url.'" title="'.$name.'">'.$name.'</a>';
			else
				echo $name;
		}
		# Mode home
		elseif($this->plxMotor->mode == 'home') {
			if($type == 'link')
				echo '<a href="./" title="'.htmlspecialchars($this->plxMotor->aConf['title'],ENT_QUOTES,PLX_CHARSET).'">Accueil</a>';
			else
				echo 'Accueil';
		} else {
			echo 'Non class&eacute;';
		}
	}

	/**
	 * Mйthode qui retourne l'identifiant de l'article en question (sans les 0 supplйmentaires)
	 *
	 * @return	int
	 * @author	Florent MONTHEL
	 **/
	function artId() {

		return intval($this->plxMotor->plxRecord_arts->f('numero'));
	}

	/**
	 * Mйthode qui affiche le titre de l'article linkй (variable $type='link') ou non
	 *
	 * @param	type	type d'affichage : link => sous forme de lien
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function artTitle($type='') {

		if($type == 'link') { # Type lien
			# On recupere les infos de l'article
			$num = $this->artId();
			$title = htmlspecialchars($this->plxMotor->plxRecord_arts->f('title'),ENT_QUOTES,PLX_CHARSET);
			$url = $this->plxMotor->plxRecord_arts->f('url');
			# On effectue l'affichage
			echo '<a href="./?article'.$num.'/'.$url.'" title="'.$title.'">'.$title.'</a>';
		} else { # Type normal
			echo htmlspecialchars($this->plxMotor->plxRecord_arts->f('title'),ENT_QUOTES,PLX_CHARSET);
		}
	}


	/**
	 * Mйthode qui affiche l'auteur de l'article
	 *
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function artAuthor() {

		echo htmlspecialchars($this->plxMotor->plxRecord_arts->f('author'),ENT_QUOTES,PLX_CHARSET);
	}

	/**
	 * Mйthode qui affiche la date de publication de l'article 
	 * au format samedi 12 septembre 2009
	 *
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function artDate() {

		echo plxUtils::dateIsoToHum($this->plxMotor->plxRecord_arts->f('date'));
	}

	/**
	 * Mйthode qui affiche l'heure de publication de l'article 
	 * au format 12:45
	 *
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function artHour() {

		echo plxUtils::heureIsoToHum($this->plxMotor->plxRecord_arts->f('date'));
	}

	/**
	 * Mйthode qui affiche la catйgorie linkй de l'article 
	 * ou la chaоne de caractиre 'Non classй' si la catйgorie 
	 * de l'article n'existe pas
	 *
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function artCat() {

		# Initialisation de notre variable interne
		$catId = $this->plxMotor->plxRecord_arts->f('categorie');
		# On verifie que la categorie n'est pas "home"
		if($catId != 'home') {
			# On va verifier que la categorie existe
			if(isset($this->plxMotor->aCats[ $catId ])) {
				# On recupere les infos de la categorie
				$name = htmlspecialchars($this->plxMotor->aCats[ $catId ]['name'],ENT_QUOTES,PLX_CHARSET);
				$url = $this->plxMotor->aCats[ $catId ]['url'];
				# On effectue l'affichage
				echo '<a href="./?categorie'.intval($catId).'/'.$url.'" title="'.$name.'">'.$name.'</a>';
			} else { # La categorie n'existe pas
				echo 'Non class&eacute;';
			}
		} else { # Categorie "home"
			echo '<a href="./" title="'.htmlspecialchars($this->plxMotor->aConf['title'],ENT_QUOTES,PLX_CHARSET).'">Последние известия</a>';
		}
	}
	
		function artCateg() {

		$catId = $this->plxMotor->plxRecord_arts->f('categorie');
		if($catId != 'home') {
			if(isset($this->plxMotor->aCats[ $catId ])) {
				$name = htmlspecialchars($this->plxMotor->aCats[ $catId ]['name'],ENT_QUOTES,PLX_CHARSET);
				$url = $this->plxMotor->aCats[ $catId ]['url'];
				echo ''.$url.'';
			} else {
				echo 'none';
			}
		} else { 
			echo '';
		}
	}

	/**
	 * Mйthode qui affiche le chвpo de l'article ainsi qu'un lien 
	 * pour lire la suite de l'article. Si l'article n'a pas de chapф, 
	 * le contenu de l'article est affichй
	 *
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function artChapo() {

		# On verifie qu'un chapo existe
		if($this->plxMotor->plxRecord_arts->f('chapo') != '') {
			# On recupere les infos de l'article
			$num = $this->artId();
			$title = htmlspecialchars($this->plxMotor->plxRecord_arts->f('title'),ENT_QUOTES,PLX_CHARSET);
			$url = $this->plxMotor->plxRecord_arts->f('url');
			# On effectue l'affichage
			echo $this->plxMotor->plxRecord_arts->f('chapo') ;
			echo ' <a class="more" href="./?article'.$num.'/'.$url.'" title="full text : '.$title.'"> дальше</a>&nbsp;»'."\n";
		} else { # Pas de chapo, affichage du contenu
			echo $this->plxMotor->plxRecord_arts->f('content')."\n";
		}
	}

	/**
	 * Mйthode qui affiche le chapф suivi du contenu de l'article
	 *
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function artContent() {

		echo $this->plxMotor->plxRecord_arts->f('chapo')."\n"; # Chapo
		echo $this->plxMotor->plxRecord_arts->f('content')."\n"; # Contenu
	}

	function artAdres() {
		echo $this->plxMotor->plxRecord_arts->f('adres')."\n"; # Chapo
	}


	/**
	 * Mйthode qui affiche un lien vers le fil RSS ou ATOM des articles
	 *
	 * @param	type	type de flux : rss ou atom
	 * @return	stdout
	 * @author	Anthony GUЙRIN et Florent MONTHEL
	 **/
	function artFeed($type='atom') {

		if($type == 'rss') # Type RSS
			echo '<a href="./feed.php?rss" title="RSS">News RSS</a>';
		else # Type ATOM
			echo '<a href="./feed.php?atom" title="Atom">новостной атом™</a>';
	}




	/**
	 * Mйthode qui affiche le titre de la page statique
	 *
	 * @return	stdout
	 * @author	Florent MONTHEL
	 **/
	function staticTitle() {

		echo htmlspecialchars($this->plxMotor->aStats[ $this->plxMotor->cible ]['name'],ENT_QUOTES,PLX_CHARSET);
	}

	/**
	 * Mйthode qui inclut le code source de la page statique
	 *
	 * @return	stdout
	 * @author	Florent MONTHEL
	 **/
	function staticContent() {

		# On genere le nom du fichier a inclure
		$file = PLX_ROOT.$this->plxMotor->aConf['racine_statiques'].$this->plxMotor->cible;
		$file .= '.'.$this->plxMotor->aStats[ $this->plxMotor->cible ]['url'].'.php';
		# Inclusion du fichier
		require $file;
	}

function galTitle() {

		echo htmlspecialchars($this->plxMotor->aGals[ $this->plxMotor->cible ]['name'],ENT_QUOTES,PLX_CHARSET);
	}
	function visualis() {

		# On genere le nom du fichier a inclure
		$file = PLX_ROOT.$this->plxMotor->aConf['gallery'].$this->plxMotor->cible;
		$file .= '.'.$this->plxMotor->aGals[ $this->plxMotor->cible ]['url'].'.php';
		# Inclusion du fichier
		require $file;
	}


	/**
	 * Mйthode qui affiche la pagination
	 *
	 * @return	stdout
	 * @author	Florent MONTHEL
	 **/
	function pagination() {

		# On verifie que la variable bypage n'est pas nulle
		if($this->plxMotor->bypage) {
			# Calcul des pages
			$prev_page = $this->plxMotor->page - 1;
			$next_page = $this->plxMotor->page + 1;
			$last_page = ceil($this->plxMotor->plxGlob_arts->count/$this->plxMotor->bypage);
			if($this->plxMotor->mode == 'home') { # En mode home
				# Generation des URLs
				$p_url = './?page'.$prev_page; # Page precedente
				$n_url = './?page'.$next_page; # Page suivante
				$l_url = './?page'.$last_page; # Derniere page
				$f_url = './'; # Premiere page
			} elseif($this->plxMotor->mode == 'categorie') { # En mode categorie
				# Generation des URLs
				$get = explode('/',$this->plxMotor->get);
				$p_url = './?'.$get[0].'/'.$get[1].'/page'.$prev_page; # Page precedente
				$n_url = './?'.$get[0].'/'.$get[1].'/page'.$next_page; # Page suivante
				$l_url = './?'.$get[0].'/'.$get[1].'/page'.$last_page; # Derniere page
				$f_url = './?'.$get[0].'/'.$get[1]; # Premiere page
			}
			# On effectue l'affichage
			if($this->plxMotor->page > 2) # Si la page active > 2 on affiche un lien 1ere page
				echo '<a href="'.$f_url.'" title="Aller а la premi&egrave;re page">&lt;&lt;</a> | ';
			if($this->plxMotor->page > 1) # Si la page active > 1 on affiche un lien page precedente
				echo '<a class="pagi" href="'.$p_url.'" title="back">'.$prev_page.'</a> | ';
			# Affichage de la page courante
			echo 'стр. '.$this->plxMotor->page.' из '.$last_page;
			if($this->plxMotor->page < $last_page) # Si la page active < derniere page on affiche un lien page suivante
				echo ' | <a class="pagi" href="'.$n_url.'" title="next">'.$next_page.'</a>';
			if(($this->plxMotor->page + 1) < $last_page) # Si la page active++ < derniere page on affiche un lien derniere page
				echo ' | <a href="'.$l_url.'" title="Aller а la derni&egrave;re page">&gt;&gt;</a>';
		}
	}

	/**
	 * Mйthode qui affiche la question du capcha
	 *
	 * @return	stdout
	 * @author	Florent MONTHEL
	 **/
	function capchaQ() {

		echo $this->plxMotor->plxCapcha->q();
	}

	/**
	 * Mйthode qui affiche la rйponse du capcha cryptйe en MD5
	 *
	 * @return	stdout
	 * @author	Florent MONTHEL
	 **/
	function capchaR() {

		echo $this->plxMotor->plxCapcha->r();
	}

	/**
	 * Mйthode qui affiche le message d'erreur de l'objet plxErreur
	 *
	 * @return	stdout
	 * @author	Florent MONTHEL
	 **/
	function erreurMessage() {

		echo $this->plxMotor->plxErreur->message;
	}	

}
?>