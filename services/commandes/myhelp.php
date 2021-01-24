<?php

function myhelp ($commandLines)
{
    define("CHAMP_CDE", "commande");
    define("CHAMP_TEXTE", "texte");

        $tableauHelps = [
        [CHAMP_CDE => "Myls", CHAMP_TEXTE => "affiche le contenu du répertoire passer en argument : 
        si vide affichage du répertoire en cours"],
        [CHAMP_CDE => "Mypwd", CHAMP_TEXTE => "donner le chemin en cours, il faut gérer 
        une variable dans l’application my shell"],
		[CHAMP_CDE => "Mycd", CHAMP_TEXTE => "modifier le chemin du mini shell"],
        [CHAMP_CDE => "Mycp", CHAMP_TEXTE => "comme cp : http ://www.linux-france.org/article/man-fr/man1/cp-1.html : 
        Options obligatoires : 
        -r et -R "],
		[CHAMP_CDE => "Mymv", CHAMP_TEXTE => "déplace un fichier ou répertoire"],
        [CHAMP_CDE => "Myfind", CHAMP_TEXTE => "chercher un dossier ou fichier : 
        Options obligatoires : 
        -name	Recherche par nom de fichier
		-type	Recherche par type de fichier 
		-size	Recherche par taille de fichier 
		-atime	Recherche par date de dernier accès 
		-mtime	Recherche par date de dernière modification 
		-ctime	Recherche par date de création 
		-user	Recherche par propriétaire"],
				
        [CHAMP_CDE => "Mymkdir", CHAMP_TEXTE => "mkdir crée un répertoire correspondant à chacun des noms mentionnés :
        Options obligatoires : 
        -p : S'assurer que chaque répertoire indiqué existe.
		Créer les répertoires parents manquants.  
		Ces derniers sont créés. Ne pas considérer les répertoires déjà existants comme des erreurs."],
												
        [CHAMP_CDE => "Mytail", CHAMP_TEXTE => "affiche la dernière partie (par défaut :  
        10 lignes) de chacun des fichiers indiqués. Ne pas gérer l’entrée standard 
        Option obligatoire : 
		-n=N : Afficher N dernières lignes."],
												
        [CHAMP_CDE => "Myrm", CHAMP_TEXTE => "efface chaque fichier indiqué. Par défaut, il n'efface pas les répertoires : 
        Options obligatoires :
		-d : Efface un répertoire avec `unlink' à la place de `rmdir', ne nécessitant pas que le répertoire soit vide.   
		Seul le Super-User peut utiliser cette option.Comme un ‘unlink’ sur un répertoire déréférence tous les fichiers qui y étaient contenus
        -i : Demander à l'utilisateur de confirmer l’effacement de chaque fichier. 
        Si la réponse ne commence pas par `y' ou `Y', le fichier est ignoré.
        -r ou  -R : Supprimer récursivement le contenu des répertoires."],
        
		[CHAMP_CDE => "Myhelp", CHAMP_TEXTE => "afficher les commandes disponibles sur le mini shell"],
        [CHAMP_CDE => "MyPs", CHAMP_TEXTE => "présente un cliche instantané des processus en cours. 
        Pour obtenir un affichage remis à jour régulièrement, utilisez top. 
        Cette page de manuel documente la version de ps basée sur /proc : 
        Options obligatoires :
		-	a
		-	u
		-	x
		et top."]
		
    ];


        echoWithColor("Liste des commandes disponibles sur le mini shell :\n",COLOR_BLUE);
        foreach ($tableauHelps as $help) {
        echoWithColor("=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=" .PHP_EOL,COLOR_GREEN);
        echoWithColor(" - Commande : ".$help["commande"] .PHP_EOL,COLOR_RED);
        echoWithColor(" - Fonction de la commande : \n".$help["texte"] .PHP_EOL,COLOR_GREEN);

        }
}
?>