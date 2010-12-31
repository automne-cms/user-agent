#----------------------------------------------------------------
#
# Messages content for module cms_ua
# French Messages
#
#----------------------------------------------------------------

DELETE FROM messages WHERE module_mes = 'cms_ua' and language_mes = 'fr';

INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(1, 'cms_ua', 'fr', 'Analyse du Navigateur');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(2, 'cms_ua', 'fr', '<div class="rowComment">\r\n<p>Ce module permet d''afficher des donn�es provenant du navigateur de l''internaute ou d''effectuer des conditions sur ces donn�es. Les donn�es du navigateur sont disponibles suite � l''analyse du <a target="_blank" href="http://fr.wikipedia.org/wiki/User_agent">User Agent</a> fourni par le navigateur client.</p>\r\n<p>Il est ainsi possible par exemple, d''identifier facilement si le navigateur est un mobile pour lui fournir un affichage adapt�.</p>\r\n<h2>Affiche une donn�e du navigateur :</h2>\r\n<div class="retrait">\r\n<p><span class="code"> &lt;atm-ua&gt;...&lt;/atm-ua&gt; </span><br />\r\nCe tag permet d''afficher une des nombreuses donn�es connues sur le navigateur.</p>\r\n<p>Dans ce tag, les variables au format <span class="vertclair">{{browscap:<span class="keyword">dataname</span>}}</span> et <span class="vertclair">{{wurfl:<span class="keyword">dataname</span>}}</span> seront remplac�es.</p>\r\n<p><span class="keyword">dataname </span>�tant le nom de la variable � afficher.</p>\r\n<p>Pour connaitre le nom des variables disponibles, vous pouvez utiliser la variable <span class="vertclair">{{ua:datas}}</span> qui vous listera l''ensemble des variables disponibles.</p>\r\n<p>Notez que les valeurs retourn�es par les variables sont directement fournies par les librairies <a href="http://code.google.com/p/phpbrowscap/" target="_blank">phpbrowscap</a> et <a href="http://wurfl.sourceforge.net" target="_blank">WURFL</a> et ne sont pas modifi�es par le module. Si certaines d''entre elles sont incorrectes, vous devez v�rifier sur le site de la librairie concern�e si une mise � jour de leur base est disponible.</p>\r\n<p>Vous trouverez plus d''informations sur la mise � jour des base de ses librairies sur l''aide en ligne de ce module.</p>\r\n</div>\r\n<h2>Faire une condition sur une donn�e du navigateur :</h2>\r\n<div>\r\n<div class="retrait"><span class="code"> &lt;atm-ua-if what="<span class="keyword">condition</span>"&gt; ... &lt;/atm-ua-if&gt; </span><br />\r\n<br />\r\nLe contenu de ce tag sera affich� si la condition pr�sente dans l''attribut <span class="vertclair">what </span>est remplie.<br />\r\n<ul>\r\n    <li><span class="keyword">condition</span> : Condition � remplir pour afficher le contenu du tag. L''usage courant est de valider la pr�sence d''une valeur non nulle. Cette condition peut aussi prendre toutes les formes valides d''une condition PHP (voir : <a target="_blank" href="http://www.php.net/if" class="admin">Les structures de contr�le en PHP</a>). La condition sera remplie si la valeur existe ou bien n''est pas nulle ou bien n''est pas �gale � faux (false).</li>\r\n</ul>\r\n<br />\r\nAu m�me titre que le tag <span class="vertclair">atm-ua</span>, les variables au format <span class="vertclair">{{browscap:<span class="keyword">dataname</span>}}</span> et <span class="vertclair">{{wurfl:<span class="keyword">dataname</span>}}</span> seront aussi remplac�es par leurs valeurs � l''int�rieur de ce tag.</div>\r\n<h3>Exemples :</h3>\r\n<div class="retrait">Afficher certaines donn�es uniquement si le navigateur est un navigateur mobile :</div>\r\n<div class="retrait"><span class="code">&lt;atm-ua-if what="{{browscap:isMobileDevice}} || {{wurfl:is_wireless_device}}"&gt;<br />\r\n&#160;&#160;&#160; Je suis un mobile utilisant le navigateur {{browscap:Parent}}<br />\r\n&lt;/atm-ua-if&gt;</span></div>\r\n<div class="retrait">\r\n<p>Afficher certaines donn�es uniquement si le navigateur n''est pas un navigateur mobile :</p>\r\n<p><span class="code"> &lt;atm-ua-if what="!{{browscap:isMobileDevice}} &amp;amp;&amp;amp; !{{wurfl:is_wireless_device}}"&gt;<br />\r\n&#160;&#160;&#160; Je ne suis pas un mobile. J''emploi le navigateur {{browscap:Parent}}<br />\r\n&lt;/atm-ua-if&gt;</span></p>\r\n<p>Afficher certaines donn�es uniquement si le navigateur est un iPhone :</p>\r\n<p><span class="code">&lt;atm-ua-if what="{{browscap:isMobileDevice}} &amp;amp;&amp;amp; {{browscap:Parent}} == ''iPhone''"&gt;<br />\r\n&#160;&#160;&#160; Je suis un iPhone<br />\r\n&lt;/atm-ua-if&gt;</span></p>\r\n</div>\r\n<h2>Forcer une valeur pour un navigateur :</h2>\r\n<div class="retrait">Il peut �tre int�ressant de vouloir forcer une valeur pour un navigateur m�me si ce n''est pas la valeur par d�faut de ce navigateur. Cela permet par exemple � un navigateur mobile de pouvoir acc�der � la version non mobile du site.</div>\r\n<div class="retrait">Pour ce faire, il est possible de forcer n''importe quelle valeur retourn�e par ce module via un param�tre dans l''adresse d''une page utilisant un des tags ci-dessus.</div>\r\n<h3>Exemples :</h3>\r\n<div class="retrait">\r\n<p>L''adresse suivante permettra de forcer les valeurs de <span class="vertclair">{{browscap:isMobileDevice}}</span> et de <span class="vertclair">{{wurfl:is_wireless_device}}</span> � 0 pour ne plus �tre consid�r� comme un appareil mobile :</p>\r\n</div>\r\n<div class="retrait"><span class="code">http://www.domain.tld/web/id-ma-page.php?ua[isMobileDevice]=0&amp;ua[is_wireless_device]=0</span></div>\r\n</div>\r\n<div class="retrait">\r\n<p>De m�me, l''adresse suivante permettra de forcer un affichage mobile :</p>\r\n</div>\r\n<div class="retrait"><span class="code">http://www.domain.tld/web/id-ma-page.php?ua[isMobileDevice]=1&amp;ua[is_wireless_device]=1</span></div>\r\n</div>\r\n<div class="retrait">\r\n<p>Ces param�tres sont stock�s dans la session de l''utilisateur. Il n''est donc pas utile de les fournir � chaque pages lors de la navigation. Une seule fois suffit pour toute la navigation de l''internaute.</p>\r\n</div>\r\n<p>&#160;</p>');