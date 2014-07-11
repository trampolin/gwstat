<?php

if (isset($login)) {
	if ($login->isUserLoggedIn() == true) {
		require_once("bin/database.php");

		$db = new DatabaseConnection();
		
		$q = "SELECT Date(fb_timestamp) as datum, sum(1) as anzahl,sum(fb_eisen) as eisen,sum(fb_silizium) as silizium,sum(fb_wasser) as wasser,sum(fb_wasserstoff) as wasserstoff FROM farmberichte group by Date(fb_timestamp)";
		
		$result =$db->query($q);
		
		if ($db->get_last_num_rows() > 0)
		{ ?>
		<div class="contentitem round">
			<p>Gesamt Farmertr&auml;ge pro Tag <a href="#" id="togglefarmperday">anzeigen</a></p>
			<div id="farmperday" class="hidden">
				<table class="auswertung">
				<tr>
					<th>Datum</th>
					<th>Anzahl</th>
					<th>Eisen</th>
					<th>Silizium</th>
					<th>Wasser</th>
					<th>Wasserstoff</th>
				</tr>
				<?php
					while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
					{
						?>

						<tr>
						<?php
						foreach($row as $key => $value)
						{
							?><td><?php echo $value; ?></td><?php
						}
						?>
						</tr>
						<?php
					}
					?>
					</table>
			</div>
		</div>
			<?php
		}
		
		$q = "SELECT CONCAT(  `fb_galaxie_from` ,  ':',  `fb_system_from` ,  ':',  `fb_planet_from` ) AS Planet, SUM( 1 ) AS anzahl, SUM( fb_eisen ) AS eisen, SUM( fb_silizium ) AS silizium, SUM( fb_wasser ) AS wasser, SUM( fb_wasserstoff ) AS wasserstoff FROM farmberichte GROUP BY 1  ORDER BY  `fb_galaxie_from` ,  `fb_system_from` ,  `fb_planet_from`";
		
		$result =$db->query($q);
		
		if ($db->get_last_num_rows() > 0)
		{ ?>
		<div class="contentitem round">
		<p>Gesamt Farmertr&auml;ge pro eigenem Planet <a href="#" id="togglefarmperownplanet">anzeigen</a></p>
		<div id="farmperownplanet" class="hidden">
		<table class="auswertung">
		<tr>
			<th>Planet</th>
			<th>Anzahl</th>
			<th>Eisen</th>
			<th>Silizium</th>
			<th>Wasser</th>
			<th>Wasserstoff</th>
		</tr>
		<?php
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
			{
				?>

				<tr>
				<?php
				foreach($row as $key => $value)
				{
					?><td><?php echo $value; ?></td><?php
				}
				?>
				</tr>
				<?php
			}
			?>
			</table></div></div>
			<?php
		}
		
		$q = "SELECT CONCAT(  `fb_galaxie` ,  ':',  `fb_system` ,  ':',  `fb_planet` ) AS Planet, SUM( 1 ) AS anzahl, SUM( fb_eisen ) AS eisen, SUM( fb_silizium ) AS silizium, SUM( fb_wasser ) AS wasser, SUM( fb_wasserstoff ) AS wasserstoff FROM farmberichte GROUP BY 1  ORDER BY  `fb_galaxie` ,  `fb_system` ,  `fb_planet`";
		
		$result =$db->query($q);
		
		if ($db->get_last_num_rows() > 0)
		{ ?>
		<div class="contentitem round">
		<p>Gesamt Farmertr&auml;ge pro Farm <a href="#" id="togglefarmperplanet">anzeigen</a></p>
		<div id="farmperplanet" class="hidden">
		<table class="auswertung">
		<tr>
			<th>Farm</th>
			<th>Anzahl</th>
			<th>Eisen</th>
			<th>Silizium</th>
			<th>Wasser</th>
			<th>Wasserstoff</th>
		</tr>
		<?php
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
			{
				?>

				<tr>
				<?php
				foreach($row as $key => $value)
				{
					?><td><?php echo $value; ?></td><?php
				}
				?>
				</tr>
				<?php
			}
		?>
		</table></div></div>
		
			<script type="text/javascript">
			$(function() {
				makeToggleAble('togglefarmperday','farmperday');
				makeToggleAble('togglefarmperownplanet','farmperownplanet');
				makeToggleAble('togglefarmperplanet','farmperplanet');
			});
			</script>
		<?php
		
		}
	}
}
else
{
	?>
	<p>Not logged in!</p>
	<?php
}
?>