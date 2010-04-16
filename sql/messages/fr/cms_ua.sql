#----------------------------------------------------------------
#
# Messages content for module cms_ua
# French Messages
#
#----------------------------------------------------------------

DELETE FROM messages WHERE module_mes = 'cms_ua' and language_mes = 'fr';

INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(1, 'cms_ua', 'fr', 'User Agent');