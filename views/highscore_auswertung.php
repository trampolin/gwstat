<?php

if (isset($login)) {
	if ($login->isUserLoggedIn() == true) {
		highscoreMenu();
		require_once("bin/database.php");

		$db = new DatabaseConnection();
		
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
							?><td><?php echo $value; ?></td><?php
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
?>
	<script type="text/javascript">
	$(function() {
		makeToggleAble('togglecompletehighscore','completehighscore');
	});
	</script>