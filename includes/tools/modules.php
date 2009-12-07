<?php
// set this to the number of inner and outer positions
$new_count = 5;
// define old positions
$old_module_positions = array('splitleft', 'topleft', 'left', 'bottomleft', 'splitright', 'topright', 'right', 'bottom', 'right');
$new_module_positions = array();

for($i=1;$i<=$new_count;$i++){ $new_module_positions[] = 'inner'.$i; }
for($i=1;$i<=$new_count;$i++){ $new_module_positions[] = 'outer'.$i; }

?>

<div id="module-migrator">
	<h2>Sidebar Module Migrator</h2>
	
	<div id="mp-source" class="select-cont">
		<div class="heading">
			<label for="old-positions">Source:</label>
			<select name="old-positions" id="old-positions">
				<option value="">Select a position</option>
				<?php
				foreach($old_module_positions as $omp){
					echo '<option value="'.$omp.'">'.$omp.'</option>';
				}
				?>
			</select>
		</div>
		<div class="contents">
			<select name="old-modules" id="old-modules" multiple="multiple" class="multiselect">
			</select>
			<ul id="new-add-multiselect">
				
			</ul>
			<ul id="new-add-all">
				<li><a href="#" class="ms-add-all">Add all</a></li>
			</ul>
		</div>
	</div>
	
	<div id="mp-dest" class="select-cont">
		<div class="heading">
			<label for="new-positions">Destination:</label>
			<select name="new-positions" id="new-positions">
				<option value="">Select a position</option>
				<?php
				foreach($new_module_positions as $nmp){
					echo '<option value="'.$nmp.'">'.$nmp.'</option>';
				}
				?>
			</select>
		</div>
		<div class="contents">
			<select name="new-modules" id="new-modules" multiple="multiple" class="multiselect">
			</select>
			<ul id="new-remove-multiselect">
				
			</ul>
			<ul id="new-remove-all">
				<li><a href="#" class="ms-remove-all">Remove all</a></li>
			</ul>
		</div>
	</div>
	
	<div id="migrate-submit">
		<a href="#" class="btn-link">Migrate Modules</a>
	</div>

</div>
