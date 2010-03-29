<?php
#==============================================================================
# LTB Self Service Password
#
# Copyright (C) 2009 Clement OUDOT
# Copyright (C) 2009 LTB-project.org
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# GPL License: http://www.gnu.org/licenses/gpl.txt
#
#==============================================================================

#==============================================================================
# English
#==============================================================================
$messages['en']['nophpldap'] = "You should install PHP-Ldap to use this tool";
$messages['en']['nophpmhash'] = "You should install PHP mhash to use Samba mode";
$messages['en']['ldaperror'] = "Cannot access to LDAP directory";
$messages['en']['loginrequired'] = "Your login is required";
$messages['en']['oldpasswordrequired'] = "Your old password is required";
$messages['en']['newpasswordrequired'] = "Your new password is required";
$messages['en']['confirmpasswordrequired'] = "Please confirm your new password";
$messages['en']['passwordchanged'] = "Your password was changed";
$messages['en']['nomatch'] = "Passwords mismatch";
$messages['en']['badcredentials'] = "Login or password incorrect";
$messages['en']['passworderror'] = "Password was refused by the LDAP directory";
$messages['en']['title'] = "Self service password";
$messages['en']['login'] = "Login";
$messages['en']['oldpassword'] = "Old password";
$messages['en']['newpassword'] = "New password";
$messages['en']['confirmpassword'] = "Confirm";
$messages['en']['submit'] = "Send";
$messages['en']['tooshort'] = "Your password is too short";
$messages['en']['toobig'] = "Your password is too big";
$messages['en']['minlower'] = "Your password has not enough lower characters";
$messages['en']['minupper'] = "Your password has not enough upper characters";
$messages['en']['mindigit'] = "Your password has not enough digits";
$messages['en']['minspecial'] = "Your password has not enough special characters";
$messages['en']['policy'] = "Your password should respect the following constraints:";
$messages['en']['policyminlength'] = "Minimal length:";
$messages['en']['policymaxlength'] = "Maximal length:";
$messages['en']['policyminlower'] = "Minimal lower characters:";
$messages['en']['policyminupper'] = "Minimal upper characters:";
$messages['en']['policymindigit'] = "Minimal digits:";
$messages['en']['policyminspecial'] = "Minimal special characters:";
$messages['en']['forbiddenchars'] = "You password contains forbidden characters";
$messages['en']['policyforbiddenchars'] = "Forbidden characters:";

#==============================================================================
# French
#==============================================================================
$messages['fr']['nophpldap'] = "Vous devriez installer PHP-Ldap pour utiliser cet outil";
$messages['fr']['nophpmhash'] = "Vous devriez installer PHP mhash pour utiliser le mode Samba";
$messages['fr']['ldaperror'] = "Erreur d'acc&egrave;s &agrave; l'annuaire";
$messages['fr']['loginrequired'] = "Vous devez indiquer votre identifiant";
$messages['fr']['oldpasswordrequired'] = "Vous devez indiquer votre ancien mot de passe";
$messages['fr']['newpasswordrequired'] = "Vous devez indiquer votre nouveau mot de passe";
$messages['fr']['confirmpasswordrequired'] = "Vous devez confirmer votre nouveau mot de passe";
$messages['fr']['passwordchanged'] = "Votre mot de passe a &eacute;t&eacute; chang&eacute;";
$messages['fr']['nomatch'] = "Les mots de passe ne correspondent pas";
$messages['fr']['badcredentials'] = "Identifiant ou mot de passe incorrect";
$messages['fr']['passworderror'] = "Le mot de passe a &eacute;t&eacute; refus&eacute;";
$messages['fr']['title'] = "Gestion du mot de passe";
$messages['fr']['login'] = "Identifiant";
$messages['fr']['oldpassword'] = "Ancien mot de passe";
$messages['fr']['newpassword'] = "Nouveau mot de passe";
$messages['fr']['confirmpassword'] = "Confirmation";
$messages['fr']['submit'] = "Envoyer";
$messages['fr']['tooshort'] = "Votre mot de passe est trop court";
$messages['fr']['toobig'] = "Votre mot de passe est trop long";
$messages['fr']['minlower'] = "Votre mot de passe n'a pas assez de minuscules";
$messages['fr']['minupper'] = "Votre mot de passe n'a pas assez de majuscules";
$messages['fr']['mindigit'] = "Votre mot de passe n'a pas assez de chiffres";
$messages['fr']['minspceial'] = "Votre mot de passe n'a pas assez de caractères spéciaux";
$messages['fr']['policy'] = "Votre mot de passe doit respecter les contraintes suivantes&nbsp;:";
$messages['fr']['policyminlength'] = "Nombre minimum de caractères&nbsp;:";
$messages['fr']['policymaxlength'] = "Nombre maximum de caractères&nbsp;:";
$messages['fr']['policyminlower'] = "Nombre minimum de minuscules&nbsp;:";
$messages['fr']['policyminupper'] = "Nombre minimum de majuscules&nbsp;:";
$messages['fr']['policymindigit'] = "Nombre minimum de chiffres&nbsp;:";
$messages['fr']['policyminspecial'] = "Nombre minimum de caractères spéciaux&nbsp;:";
$messages['fr']['forbiddenchars'] = "Votre mot de passe contient des caractères interdits";
$messages['fr']['policyforbiddenchars'] = "Caractères interdits&nbsp;:";

#==============================================================================
# German
#==============================================================================
$messages['de']['nophpldap'] = "Sie ben&ouml;tigen die PHP-Ldap Erweiterung um dieses Tool zu nutzen";
$messages['de']['nophpmash'] = "Sie ben&ouml;tigen die PHP mhash Erweiterung um den Samba Modus zu nutzen";
$messages['de']['ldaperror'] = "Kein Zugriff auf das LDAP m&ouml;glich";
$messages['de']['loginrequired'] = "Ihr Login wird ben&ouml;tigt";
$messages['de']['oldpasswordrequired'] = "Ihr altes Passwort wird ben&ouml;tigt";
$messages['de']['newpasswordrequired'] = "Ihr neues Passwort wird ben&ouml;tigt";
$messages['de']['confirmpasswordrequired'] = "Bitte best&auml;tigen Sie Ihr neues Passwort";
$messages['de']['passwordchanged'] = "Ihr Passwort wurde erfolgreich ge&auml;ndert";
$messages['de']['nomatch'] = "Passw&ouml;rter stimmen nicht &uuml;berein";
$messages['de']['badcredentials'] = "Login oder Passwort inkorrekt";
$messages['de']['passworderror'] = "Passwort wurde vom LDAP nicht akzeptiert";
$messages['de']['title'] = "Self service password";
$messages['de']['login'] = "Login";
$messages['de']['oldpassword'] = "Altes Passwort";
$messages['de']['newpassword'] = "Neues Passwort";
$messages['de']['confirmpassword'] = "Best&auml;tigen";
$messages['de']['submit'] = "Senden";
$messages['de']['tooshort'] = "Ihr Passwort ist zu kurz";
$messages['de']['toobig'] = "Ihr Password ist zu lang";
$messages['de']['minlower'] = "Ihr Passwort hat nicht genug Kleinbuchstaben";
$messages['de']['minupper'] = "Ihr Passwort hat nicht genug Großbuchstaben";
$messages['de']['mindigit'] = "Ihr Passwort hat nicht genug Ziffern";
$messages['de']['minspecial'] = "Ihr Passwort hat nicht genug Sonderzeichen";
$messages['de']['policy'] = "Ihr Passwort muss diese Regeln beachten:";
$messages['de']['policyminlength'] = "Minimale L&auml;nge:";
$messages['de']['policymaxlength'] = "Maximale L&auml;nge:";
$messages['de']['policyminlower'] = "Minimale Anzahl Kleinbuchstaben:";
$messages['de']['policyminupper'] = "Minimale Anzahl Gro&szlig;buchstaben:";
$messages['de']['policymindigit'] = "Minimale Anzahl Ziffern:";
$messages['de']['policyminspecial'] = "Minimale Anzahl Sonderzeichen:";
$messages['de']['forbiddenchars'] = "Ihr Passwort enth&auml;lt nicht erlaubte Zeichen";
$messages['de']['policyforbiddenchars'] = "Nicht erlaubte Zeichen:";

?>
