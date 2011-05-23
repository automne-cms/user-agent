#----------------------------------------------------------------
#
# Messages content for module cms_ua
# English Messages
#
#----------------------------------------------------------------

DELETE FROM messages WHERE module_mes = 'cms_ua' and language_mes = 'en';

INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(1, 'cms_ua', 'en', 'Browser analysis');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(2, 'cms_ua', 'en', '<div class=\"rowComment\"><p>This module can display datas from the user\'s browser or to make conditions on those datas. The browser\'s datas are available following the analysis of the <a target=\"_blank\" href=\"http://fr.wikipedia.org/wiki/User_agent\">User Agent</a> provided by the client browser.</p> <p>It is possible, for example, to easily identify if the browser is a mobile device to provide a suitable display.</p> <h2>Displaying a browser data:</h2> <div class=\"retrait\"><p>The following variables in the format <span class=\"vertclair\">{browscap:<span class=\"keyword\">dataname</span>}</span>  and <span class=\"vertclair\">{wurfl:<span class=\"keyword\">dataname</span>}</span> will be replaced.</p> <p><span class=\"keyword\">dataname </span>is the name of the variable to display.</p> <p>To know the names of variables available, you can use the variable <span class=\"vertclair\">{ua:datas}</span> which will list all available variables.</p></div> <h2>Amking a condition on a browser data:</h2> <div><div class=\"retrait\"><span class=\"code\"> &lt;atm-if what=\"<span class=\"keyword\">condition</span>\"&gt; ... &lt;/atm-if&gt; </span><br /> <br /> The content of this tag will be displayed if the present condition in the attribute <span class=\"vertclair\">what </span>is fulfilled.</div> <div class=\"retrait\"><ul>     <li><span class=\"keyword\">condition</span>: Condition to be fulfilled to view the contents of the tag. Common usage is to validate the presence of a non null value. This condition can also take the form of a valid PHP condition (see: <a target=\"_blank\" href=\"http://www.php.net/if\">Control Structures in PHP</a>). The condition will be satisfied if the value exists or is not zero or not equal to false.</li> </ul> <p>Just as the tag <span class=\"vertclair\">atm-ua</span>, the variables in the format<span class=\"vertclair\">&#160;{browscap:<span class=\"keyword\">dataname</span>}</span>&#160;and <span class=\"vertclair\">{wurfl:<span class=\"keyword\">dataname</span>}</span> will also be replaced by their values within this tag.</p></div> <h3>Examples:</h3> <div class=\"retrait\">Show some data only if the browser is a mobile browser:</div> <div class=\"retrait\">&#160;</div> <div class=\"retrait\"><span class=\"code\">&lt;atm-if what=\"{browscap:isMobileDevice} || {wurfl:is_wireless_device}\"&gt;<br /> &#160;&#160;&#160; I am a mobile using the browser {browscap:Parent}<br /> &lt;/atm-if&gt;</span></div> <div class=\"retrait\"><p>Show some data only if the browser is not a mobile browser:</p> <p><span class=\"code\"> &lt;atm-if what=\"!{browscap:isMobileDevice} &amp;amp;&amp;amp; !{wurfl:is_wireless_device}\"&gt;<br /> &#160;&#160;&#160; I am not a mobile. I use the browser {browscap:Parent}<br /> &lt;/atm-if&gt;</span></p> <p>Show some data only if the browser is an iPhone:</p> <p><span class=\"code\">&lt;atm-if what=\"{browscap:isMobileDevice} &amp;amp;&amp;amp; {browscap:Parent} == \'iPhone\'\"&gt;<br /> &#160;&#160;&#160; I am an iPhone<br /> &lt;/atm-if&gt;</span></p></div> <h2>Forcing a value for a browser:</h2> <div class=\"retrait\">It may be interesting to force a value for a browser even if it is not the default for this browser. This allows for example a mobile browser to access a non-mobile version of the site.<br /> <br /> To do this, it is possible to force any value returned by this module via a parameter in the address of a page using a tag above.</div> <h3>Examples :</h3> <div class=\"retrait\"><p>The next address will force the values of <span class=\"vertclair\">{browscap:isMobileDevice}</span> and <span class=\"vertclair\">{wurfl:is_wireless_device}</span> to 0 for no longer be considered a mobile device:</p></div> <div class=\"retrait\"><span class=\"code\">http://www.domain.tld/web/id-ma-page.php?ua[isMobileDevice]=0&amp;ua[is_wireless_device]=0</span></div> <div class=\"retrait\"><p>Similarly, the next address will force a mobile display:</p></div> <div class=\"retrait\"><span class=\"code\">http://www.domain.tld/web/id-ma-page.php?ua[isMobileDevice]=1&amp;ua[is_wireless_device]=1</span> <p>Those parameters are stored in the user session. It is therefore not useful to provide them each page while browsing. One time is enough.</p></div>  <h2>Miscellaneous</h2> <div class=\"retrait\"><p>Note that the values returned by the variables are directly provided by the libraries and&#160;<a target=\"_blank\" href=\"http://code.google.com/p/phpbrowscap/\">phpbrowscap</a>&#160;and&#160;<a target=\"_blank\" href=\"http://wurfl.sourceforge.net\">WURFL</a>&#160;and are not changed by the module. If some of them are incorrect, you should check on the website concerned if an update is available from their base.</p> <p>To update WURFL and Browscap databases, reset Automne cache (Administration &gt; Server settings &gt; Cache management &gt; Reset Cache).</p></div></div></div><p>&#160;</p>');