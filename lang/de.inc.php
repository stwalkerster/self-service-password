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
# German
#==============================================================================
$messages['nophpldap'] = "Sie ben&ouml;tigen die PHP-Ldap Erweiterung um dieses Tool zu nutzen";
$messages['nophpmash'] = "Sie ben&ouml;tigen die PHP mhash Erweiterung um den Samba Modus zu nutzen";
$messages['ldaperror'] = "Kein Zugriff auf das LDAP m&ouml;glich";
$messages['loginrequired'] = "Ihr Login wird ben&ouml;tigt";
$messages['oldpasswordrequired'] = "Ihr altes Passwort wird ben&ouml;tigt";
$messages['newpasswordrequired'] = "Ihr neues Passwort wird ben&ouml;tigt";
$messages['confirmpasswordrequired'] = "Bitte best&auml;tigen Sie Ihr neues Passwort";
$messages['passwordchanged'] = "Ihr Passwort wurde erfolgreich ge&auml;ndert";
$messages['nomatch'] = "Passw&ouml;rter stimmen nicht &uuml;berein";
$messages['badcredentials'] = "Login oder Passwort inkorrekt";
$messages['passworderror'] = "Passwort wurde vom LDAP nicht akzeptiert";
$messages['title'] = "Self service password";
$messages['login'] = "Login";
$messages['oldpassword'] = "Altes Passwort";
$messages['newpassword'] = "Neues Passwort";
$messages['confirmpassword'] = "Best&auml;tigen";
$messages['submit'] = "Senden";
$messages['tooshort'] = "Ihr Passwort ist zu kurz";
$messages['toobig'] = "Ihr Password ist zu lang";
$messages['minlower'] = "Ihr Passwort hat nicht genug Kleinbuchstaben";
$messages['minupper'] = "Ihr Passwort hat nicht genug Großbuchstaben";
$messages['mindigit'] = "Ihr Passwort hat nicht genug Ziffern";
$messages['minspecial'] = "Ihr Passwort hat nicht genug Sonderzeichen";
$messages['policy'] = "Ihr Passwort muss diese Regeln beachten:";
$messages['policyminlength'] = "Minimale L&auml;nge:";
$messages['policymaxlength'] = "Maximale L&auml;nge:";
$messages['policyminlower'] = "Minimale Anzahl Kleinbuchstaben:";
$messages['policyminupper'] = "Minimale Anzahl Gro&szlig;buchstaben:";
$messages['policymindigit'] = "Minimale Anzahl Ziffern:";
$messages['policyminspecial'] = "Minimale Anzahl Sonderzeichen:";
$messages['forbiddenchars'] = "Ihr Passwort enth&auml;lt nicht erlaubte Zeichen";
$messages['policyforbiddenchars'] = "Nicht erlaubte Zeichen:";
$messages['questions']['birthday'] = "Wie lautet Ihr Geburtstag?";
$messages['questions']['color'] = "Wie lautet Ihre Lieblingsfarbe?";
$messages['password'] = "Passwort";
$messages['question'] = "Frage";
$messages['answer'] = "Antwort";
$messages['setquestionshelp'] = "Richten Sie f&uuml;r die Passwort zur&uuml;cksetzung eine Sicherheitsfrage ein.
Sie k&ouml;nnen anschlie&szlig;end ihr Passwort <a href=\"?action=resetbyquestions\">hier</a> &auml;ndern.";
$messages['answerrequired'] = "Es wurde keine Antwort eingegeben";
$messages['questionrequired'] = "Es wurde keine Frage ausgew&auml;hlt";
$messages['passwordrequired'] = "Bitte geben Sie Ihre Passwort ein";
$messages['answermoderror'] = "Ihre Antwort wurde nicht gespeichert";
$messages['answerchanged'] = "Ihre Antwort wurde gespeichert";
$messages['answernomatch'] = "Ihr Antwort war nicht korrekt";
$messages['resetbyquestionshelp'] = "W&auml;hlen Sie eine Frage Sicherheitsfrage aus und beantworten diese ansch&szlig;end.
Hierzu m&uuml;ssen Sie vorher eine <a href=\"?action=setquestions\">Antwort festgelegt</a> haben.";
$messages['changehelp'] = "Um ein neues Passwort festzulegen m&uuml;ssen Sie zuerst Ihr Altes eingeben. 
Falls Sie Ihr altes Passwort vergessen haben k�nnen Sie Ihr Passwort<a href=\"?action=resetbyquestions\">zur&uuml;cksetzen durch Beantwortung 
einer Sicherheitsfrage</a>.";

?>
