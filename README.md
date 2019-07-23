<p>Závislosti:<br />
PHP 7.2+<br />
Databáze MySQL&nbsp; s&nbsp;názvem &bdquo;Acmark&ldquo; (lze konfigurovat)<br />
Composer</p>


<p>Defaultní nastavení spojení s DB:</p>

<pre>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Acmark
DB_USERNAME=root
DB_PASSWORD=</pre>
<p>Pokud vyžadujete jinak, tak lze změnit v&nbsp;souboru .env</p>



<p>Instalace:</p>
<ul>
	<li>V&nbsp;příkazovém řádku přejít do rootu projektu</li>
	<li>Zadat příkaz &bdquo;php artisan migrate&ldquo; - abychom vytvořili tabulku v DB
	<ul style="list-style-type:circle;">
		<li>Pokud se objeví chybná hláška, pak v&nbsp;souboru php.ini (ne v&nbsp;projektu, ale přímo v&nbsp;místě kde máte nainstalované PHP) přidáme:
		<ul>
			<li>Pro windows: extension=php_pdo_mysql.dll</li>
			<li>Pro Linux: extension= pdo_mysql.so</li>
		</ul>
		</li>
	</ul>
	</li>
	<li>Zadat příkaz &bdquo;php artisan serve&ldquo; který nám spustí projekt =&gt; přejdeme na vypsanou url</li>
</ul>
