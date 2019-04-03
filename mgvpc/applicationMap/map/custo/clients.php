<?php	
	include ("../inc/header.inc.php");
	include ("../inc/menu.inc.php");

	function __autoload($class_name){
	    require('../../classes/' . $class_name . '.class.php'); 
	}
?>

<html>
	<head>
		<title>	Tous les clients</title>		
		<meta charset="UTF-8">
		<script>
			function matchRuleShort(str, rule) {
				return new RegExp("^" + rule.split("*").join(".*") + "$").test(str);
			}

			function Filtre()
			{	
				var filtre = document.getElementById("filtre").value;
				//on récupère tous les codes GETaux
				var cp = document.getElementsByName("cp");
				//pour chaque code GETal
				for (var i = 0; i < cp.length; i++) 
				{
					//masquer les lignes
					cp.item(i).parentNode.parentNode.style.display="none";
					if (matchRuleShort(cp.item(i).value,filtre+"*"))
					{
						//afficher la ligne 
					   	cp.item(i).parentNode.parentNode.style.display="";
					}
				}
			}
			
			//Récupération des valeurs du client sélectionné
			function Modifier(idC)
			{
				var nomC = "nom" + idC;
				var prenomC = "prenom" + idC;
				var rueC = "rue" + idC;
				var cpC = "codeGETal" + idC;
				var villeC = "ville" + idC;

				var nom = document.getElementById(nomC).innerText;
				var prenom = document.getElementById(prenomC).innerText;
				var rue = document.getElementById(rueC).innerText;
				var cp = document.getElementById(cpC).value;
				var ville = document.getElementById(villeC).innerText;
				
				document.getElementById('modif_nom').value = nom;
				document.getElementById('modif_prenom').value = prenom;
				document.getElementById('modif_rue').value = rue;
				document.getElementById('modif_cp').value = cp;
				document.getElementById('modif_ville').value = ville;
			}
		</script>
	</head>
	
	<body> <div id="client">
		<form id="form" name="formulaire" action = "#" method = "GET">
			<h1 align="center"> Clients</h1>
			<table id="tabpers" align="center" cellpadding="5" width="100%" border="2">
				<tr align="center" bgcolor="lightgrey">
				    <th><a href="clients.php?tri=nom"/><b>Nom</b></th>
				    <th><b>Prénom</b></th>
				    <th><b>Rue</b></th>
                    		    <th><b>Code GETal</b>
					<select id="filtre">
						<option>0</option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
					</select>
					<input type="button" value="Filtrer" onClick="Filtre();">
				    </th>
                    		    <th><a href="clients.php?tri=ville"><b>Ville</b></th>
                    		    <th><b>Modifier</b></th>
	<!------------------------------------------TRI---------------------------------------------------------------------------------!-->			
			<?php
				$clientManager = new clientManager(database::getDB());
				if(isset($_GET['tri'])&&($_GET['tri']!="")){
					if($_GET['tri']=="nom")
					{
						$tabClient=$clientManager->getList("order by nomCli");
					}
					
					if($_GET['tri']=="ville")
					{
						$tabClient=$clientManager->getList("order by villeCli");
					}
				}else
				{
					$tabClient=$clientManager->getList();
				}
				
				foreach($tabClient as $client)
				{
					echo"<tr><td id='nom".$client->getId()."'>".$client->getNom()."</td>";
					echo"<td id='prenom".$client->getId()."'>".$client->getPrenom()."</td>";
					echo"<td id='rue".$client->getId()."'>".$client->getRue()."</td>";
					echo"<td id='cp".$client->getId()."'><input type='text' id='codeGETal".$client->getId()."'name='cp' value='".$client->getCp()."' readonly /></td>";
					echo"<td id='ville".$client->getId()."'>".$client->getVille()."</td>";
					echo"<td><input type='button' value='Modifier' onClick='Modifier(".$client->getId().");'></td></tr>\n";
				}

			?>
			</table>
		</form> <br />
	<!----------------------------------------------MODIFICATION-----------------------------------------------------------------------------!-->
		<form id="form" name="formulaire" action="clients.php" method="GET">
			<table id="tabclient" align="center" cellpadding="5" width="50%" border="2">
				<tr><td>Nom du client : <input type="text" id="modif_nom"></td></tr>
				<tr><td>Prénom du client : <input type="text" id="modif_prenom"></td></tr>
				<tr><td>Rue : <input type="text" id="modif_rue"/></td></tr>
				<tr><td>Code GETal : <input type="text" id="modif_cp"/></td></tr>
				<tr><td>Ville : <input type="text" id="modif_ville"/></td></tr>
				<tr><td><input type="submit" value="Valider"></tr>
			</table>
		</form>
		
			
			
		<?php		
			include ("../inc/footer.inc.php");
			
			$clientManager = new clientManager(database::getDB());
			
		?>
	</div></body>
</html>
