<?php

if (isset($login)) {
	if ($login->isUserLoggedIn() == true) {
		highscoreMenu();
		require_once("bin/database.php");

		$db = new DatabaseConnection();
		
		
		// aktive Spieler
		$q = "select t1.hs_platz,t1.hs_name,t1.hs_timestamp,t1.hs_punkte as PunkteNeu,t2.hs_punkte as PunkteAlt from highscore as t1 join highscore as t2 on t1.hs_name = t2.hs_name and t1.hs_timestamp > t2.hs_timestamp where t1.hs_punkte <> t2.hs_punkte group by 2,1,3,4,5 order by t1.hs_platz";
		
		$result =$db->query($q);
		
		$bla = 0;
		
		if ($db->get_last_num_rows() > 0)
		{ ?>
		<div class="contentitem round">
			<p>Aktive Spieler <a href="#" id="toggleactivehighscore">anzeigen</a></p>
			<div id="activehighscore" class="hidden">
				<table class="auswertung">
				<tr>
					<th>Platz</th>
					<th>Name</th>
					<th>Aktiv</th>
					<th>Punkte Neu</th>
					<th>Punkte Alt</th>
				</tr>
				<?php
					while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
					{
						$bla++;
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
						
						if ($bla%30==29) {
						?>
						<tr>
							<th>Platz</th>
							<th>Name</th>
							<th>Aktiv</th>
							<th>Punkte Neu</th>
							<th>Punkte Alt</th>
						</tr>
						<?php
						}
					}
					?>
					</table>
			</div>
		</div>
			<?php
		}
		
		$q = "SELECT * from highscore order by hs_platz asc, hs_timestamp asc";
		
		$result =$db->query($q);
		
		$bla = 0;
		
		if ($db->get_last_num_rows() > 0)
		{ ?>
		<div class="contentitem round">
			<p>Komplette Highscore <a href="#" id="togglecompletehighscore">anzeigen</a></p>
			<div id="completehighscore" class="hidden">
				<table class="auswertung">
				<tr>
					<th>Timestamp</th>
					<th>Name</th>
					<th>Allianz</th>
					<th>Platz</th>
					<th>Planetenpkt.</th>
					<th>Forschungspkt.</th>
					<th>Punkte</th>
					<th>Planeten</th>
				</tr>
				<?php
					while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
					{
						$bla++;
						?>

						<tr>
						<?php
						foreach($row as $key => $value)
						{
							if ($key != 'hs_playercard') {
								if ($key == 'hs_name')
								{
									if ($row['hs_playercard'] == '')
									{
										?><td><?php echo $value; ?></td><?php
									}
									else
									{
										?><td><a href="http://uni1.gigrawars.de/playercard.php?u=<?php echo $row['hs_playercard']; ?>"><?php echo $value; ?></td></a><?php
									}
								}
								else
								{
									?><td><?php echo $value; ?></td><?php
								}
							}
							
						}
						?>
						</tr>
						<?php
						
						if ($bla%30==29) {
						?>
							<tr>
								<td><b>Timestamp</b></td>
								<td><b>Name</b></td>
								<td><b>Allianz</b></td>
								<td><b>Platz</b></td>
								<td><b>Planetenpkt.</b></td>
								<td><b>Forschungspkt.</b></td>
								<td><b>Punkte</b></td>
								<td><b>Planeten</b></td>
							</tr>
						<?php
						}
					}
					?>
					</table>
			</div>
		</div>
			<?php
		}
		
	}
}

//select t1.hs_name,t1.hs_timestamp,t1.hs_punkte as PunkteNeu,t2.hs_punkte as PunkteAlt from highscore as t1 join highscore as t2 on t1.hs_name = t2.hs_name and t1.hs_timestamp > t2.hs_timestamp where t1.hs_punkte <> t2.hs_punkte group by 1,2,3,4 order by t1.hs_platz

?>
	<script type="text/javascript">
	$(function() {
		makeToggleAble('togglecompletehighscore','completehighscore');
		makeToggleAble('toggleactivehighscore','activehighscore');
	});
	</script>